require('dotenv').config();
const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');
const Product = require('./models/Product.js');
const Order = require('./models/Order.js');
const paypal = require('paypal-rest-sdk');

const app = express();

app.set('view engine', 'ejs');
app.use(bodyParser.urlencoded({ extended: true }));
app.use(express.json());
app.use(express.static('public'));

//configuración del paypal
paypal.configure({
  mode: process.env.PAYPAL_MODE,
  client_id: process.env.PAYPAL_CLIENT_ID,
  client_secret: process.env.PAYPAL_CLIENT_SECRET,
});

// connexión a la db
mongoose.connect('mongodb://127.0.0.1:27017/PaulaStore', {});

//rutas
app.get('/', async (req, res) => {//vista de index
  try {
    const products = await Product.find({ stock: { $gt: 0 } });//trae los productos con stock > 0
    res.render('index', { products }); //esto renderiza la vista tras traer los productos
  } catch (error) {
    console.error('Error al obtener productos:', error);
    res.status(500).send('Error al cargar los productos.');
  }
});

app.post('/buy', async (req, res) => {//vista de compra
  try {
    const cart = req.body.cart;

    if (!Array.isArray(cart) || cart.length === 0) { //validar que el carrito tenga productos
      return res.status(400).send('El carrito debe ser un arreglo con productos.');
    }

    const items = [];
    let total = 0;

    for (let item of cart) {
      const product = await Product.findById(item.id);
      if (!product) {
        return res.status(404).send(`Producto con ID ${item.id} no encontrado.`); //si no encuentra el producto
      }

      if (product.stock < item.quantity) {
        return res.status(400).send(`Stock insuficiente para ${product.name}.`);//si no hay suficiente stock
      }

      items.push({//agrega los items a la lista
        name: product.name,
        price: product.price.toFixed(2),
        currency: 'USD',
        quantity: item.quantity,
      });
      total += product.price * item.quantity;
    }

    const order = new Order({ //segmento para crear el objeto de la orden
      code: `M9028-${new Date().toISOString().slice(0, 10).replace(/-/g, '')}-0001`,
      products: cart,
      total,
    });

    const create_payment_json = { 
      intent: 'sale',
      payer: { payment_method: 'paypal' },
      redirect_urls: {
        return_url: 'http://localhost:3000/success',//redirecciona a la vista de exito
        cancel_url: 'http://localhost:3000/cancel',
      },
      transactions: [
        {
          item_list: { items },
          amount: { currency: 'USD', total: total.toFixed(2) },
          description: `Compra en la tienda con código ${order.code}`,
        },
      ],
    };

    paypal.payment.create(create_payment_json, async (err, payment) => { //crea el pago en paypal
        if (err) {
          console.error('Error al crear el pago:', err);
          return res.status(500).send('Error al procesar el pago.');
        }
      
        const approvalUrl = payment.links.find((link) => link.rel === 'approval_url'); //busca la url de aprobación
        if (approvalUrl) {
          order.transactionId = payment.id;
          await order.save(); //esto va a guardar el objeto de la orden
          return res.json({ url: approvalUrl.href });
        }
      
        res.status(500).send('Pago ilválido');
      });
  } catch (error) {
    console.error('Error al procesar la compra:', error);
    res.status(500).send('Error interno del servidor.');
  }
});

app.get('/success', async (req, res) => { //vista de exito
  try {
    const paymentId = req.query.paymentId;
    const payerId = { payer_id: req.query.PayerID };

    paypal.payment.execute(paymentId, payerId, async (err, payment) => {
      if (err) {
        console.error('Error al ejecutar el pago:', err);
        return res.redirect('/');
      }

      const order = await Order.findOne({ transactionId: paymentId });
      if (!order) {
        return res.status(404).send('Orden no encontrada.');
      }

      order.date = new Date();
      await order.save();

      await Promise.all(order.products.map(async (item) => {//promesa para actualizar todos los productos
        await Product.findByIdAndUpdate(item.id, { $inc: { stock: -item.quantity } });
      }));

      res.render('success'); //saca nueva vista
    });
  } catch (error) {
    console.error('Error al completar el pago:', error);
    res.status(500).send('Error interno del servidor.');
  }
});

//Listener
app.listen(3000, () => {
  console.log('Servidor corriendo en http://localhost:3000');
});

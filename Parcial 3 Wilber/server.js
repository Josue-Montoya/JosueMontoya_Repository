require('dotenv').config();
const express = require('express');
const mongoose = require('mongoose');
const bodyParser = require('body-parser');
const Sneaker = require('./models/Sneaker'); // Importación del modelo Sneaker
const Order = require('./models/Order');    // Importación del modelo Order
const paypal = require('paypal-rest-sdk');
const path = require('path');

const app = express();

// Configuración de vistas y middleware
app.set('view engine', 'ejs');
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());
app.use(express.static('public'));

// Configuración de PayPal
paypal.configure({
  mode: process.env.PAYPAL_MODE || 'sandbox',
  client_id: process.env.PAYPAL_CLIENT_ID,
  client_secret: process.env.PAYPAL_CLIENT_SECRET,
});

// Conexión a MongoDB
mongoose.connect('mongodb://127.0.0.1:27017/SneakerHaven')
  .then(() => console.log('Conectado a MongoDB'))
  .catch(err => console.error('Error al conectar a MongoDB:', err));

// Ruta principal - mostrar sneakers en stock
app.get('/', async (req, res) => {
  try {
    const sneakers = await Sneaker.find({ stock: { $gt: 0 } });
    console.log('Sneakers obtenidos:', sneakers); // Verificar los datos obtenidos
    res.render('index', { sneakers });
  } catch (error) {
    console.error('Error al obtener sneakers:', error);
    res.status(500).send('Error al cargar los productos.');
  }
});

// Ruta para procesar compra
// Ruta para procesar la compra
app.post('/buy', async (req, res) => {
  try {
    const cart = req.body.cart;

    if (!Array.isArray(cart) || cart.length === 0) {
      return res.status(400).send('El carrito debe contener productos.');
    }

    const items = [];
    let total = 0;

    // Validar y preparar productos
    for (let item of cart) {
      const product = await Sneaker.findById(item.id);
      if (!product) {
        return res.status(404).send(`Producto con ID ${item.id} no encontrado.`);
      }

      if (product.stock < item.quantity) {
        return res.status(400).send(`Stock insuficiente para ${product.model}.`);
      }

      items.push({
        name: item.name,
        price: product.price.toFixed(2),
        currency: 'USD',
        quantity: item.quantity,
      });
      total += product.price * item.quantity;
    }

    // Crear objeto de orden
    const order = new Order({
      code: `M9028-${new Date().toISOString().slice(0, 10).replace(/-/g, '')}-0001`,
      products: cart.map(item => ({
        id: item.id,
        quantity: item.quantity,
      })),
      total: total,
    });

    // Configuración de pago PayPal
    const create_payment_json = {
      intent: 'sale',
      payer: { payment_method: 'paypal' },
      redirect_urls: {
        return_url: `${process.env.APP_URL || 'http://localhost:3000'}/success`,
        cancel_url: `${process.env.APP_URL || 'http://localhost:3000'}/cancel`,
      },
      transactions: [
        {
          item_list: { items },
          amount: { currency: 'USD', total: total.toFixed(2) },
          description: `Compra en SneakerHaven con código ${order.code}`,
        },
      ],
    };

    // Crear pago en PayPal
    paypal.payment.create(create_payment_json, async (err, payment) => {
      if (err) {
        console.error('Error al crear el pago:', err);
        return res.status(500).send('Error al procesar el pago.');
      }

      const approvalUrl = payment.links.find(link => link.rel === 'approval_url');
      if (approvalUrl) {
        order.transactionId = payment.id;
        await order.save();
        return res.json({ url: approvalUrl.href });
      }

      res.status(500).send('Pago inválido');
    });
  } catch (error) {
    console.error('Error al procesar la compra:', error);
    res.status(500).send('Error interno del servidor.');
  }
});


// Ruta de éxito de pago
app.get('/success', async (req, res) => {
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

      // Actualizar stock de productos
      await Promise.all(
        order.products.map(async item => {
          await Sneaker.findByIdAndUpdate(item.id, { $inc: { stock: -item.quantity } });
        })
      );

      res.render('success');
    });
  } catch (error) {
    console.error('Error al completar el pago:', error);
    res.status(500).send('Error interno del servidor.');
  }
});

// Ruta de cancelación de pago
app.get('/cancel', (req, res) => {
  res.render('cancel');
});

// Listener del servidor
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`SneakerHaven corriendo en http://localhost:${PORT}`);
});

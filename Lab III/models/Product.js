const mongoose = require('mongoose');

const productSchema = new mongoose.Schema({
  name: String,
  stock: Number,
  price: Number
});

module.exports = mongoose.model('Product', productSchema);

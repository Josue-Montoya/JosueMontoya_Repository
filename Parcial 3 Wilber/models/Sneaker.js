const mongoose = require('mongoose');

// models/Sneaker.js
const sneakerSchema = new mongoose.Schema({
  brand: String,
  model: String,
  price: Number,
  stock: Number,
  sizes: [Number],
  color: String,
  imageUrl: String,
  category: String  // running, casual, basketball, etc.
});

const Sneaker = mongoose.model('shoes', sneakerSchema);
module.exports = Sneaker;

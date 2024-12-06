const mongoose = require('mongoose');

const orderSchema = new mongoose.Schema({
   code: String,
   products: [
     {
       id: { type: mongoose.Schema.Types.ObjectId, ref: 'shoes' },
       quantity: Number
     }
   ],
   total: Number,
   transactionId: String,
   date: { type: Date, default: Date.now },
   status: {
     type: String,
     enum: ['pending', 'completed', 'cancelled'],
     default: 'pending'
   }
});

module.exports = mongoose.model('Order', orderSchema);

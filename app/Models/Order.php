<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'payment_session_id',
        'payment_status',
        'customer_id',
        'invoice_id'
    ];

    // Relationship with ic_payment_sessions
    public function paymentSession()
    {
        return $this->belongsTo(PaymentSession::class, 'payment_session_id');
    }
}

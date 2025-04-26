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
    ];

    // Relationship with ic_payment_sessions
    public function paymentSession()
    {
        return $this->belongsTo(IcPaymentSession::class, 'payment_session_id');
    }
}

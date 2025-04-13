<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSession extends Model
{
    use HasFactory;

    protected $table = 'payment_sessions';

    protected $fillable = ['order_id', 'payload','invoice_data'];
}

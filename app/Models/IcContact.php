<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IcContact extends Model
{
    use HasFactory;
    protected $table = 'contacts';
    protected $fillable = [
        'name',       
        'email',      
        'subject',
        'message',      
        'created_at',
        'updated_at'
    ];
}

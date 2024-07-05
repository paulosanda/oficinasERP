<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrderService extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_order_id',
        'service_code',
        'description',
        'quantity',
        'value',
        'discount',
        'subtotal',
    ];
}

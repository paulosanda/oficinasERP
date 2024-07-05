<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrderPart extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_order_id',
        'part_code',
        'description',
        'quantity',
        'value',
        'discount',
        'subtotal',
    ];
}

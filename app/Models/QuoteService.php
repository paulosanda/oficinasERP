<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuoteService extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'service_code',
        'description',
        'quantity',
        'value',
        'discount',
        'subtotal'
    ];
}

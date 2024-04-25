<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'part_code',
        'description',
        'quantity',
        'value',
        'discount',
        'subtotal',
    ];
}

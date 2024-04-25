<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'brand',
        'model',
        'color',
        'year',
        'plate',
        'identification_number',
        'renavam',
        'monthly_mileage',
        'observation',
    ];
}

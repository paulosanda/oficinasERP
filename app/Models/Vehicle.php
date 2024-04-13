<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'marca',
        'modelo',
        'cor',
        'ano',
        'placa',
        'numero_chassi',
        'renavam',
        'media_mensal_km_rodado',
        'observacoes',
    ];
}

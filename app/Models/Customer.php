<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'celular',
        'telefone',
        'cpf',
        'rg',
        'nascimento',
        'endereco',
        'numero',
        'cep',
        'bairro',
        'cidade',
        'estado'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'razao_social',
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'endereco',
        'numero',
        'bairro',
        'cep',
        'cidade',
        'estado',
        'celular',
        'email'
    ];

    public function users(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(User::class, ClientUser::class, 'client_id', 'id', 'id', 'user_id');
    }
}

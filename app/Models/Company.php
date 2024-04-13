<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Company extends Model
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

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, CompanyUser::class, 'company_id', 'id', 'id', 'user_id');
    }
}

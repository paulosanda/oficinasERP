<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Company extends Model
{
    use HasFactory;

    const COMPANY_INDEX = 'company_id';

    protected $with = ['users'];

    protected $table = 'companies';
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

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;

    protected $with = ['vehicle'];
    protected $fillable = [
        'company_id',
        'tipo',
        'name',
        'email',
        'celular',
        'telefone',
        'cpf',
        'rg',
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'nascimento',
        'profissao',
        'endereco',
        'numero',
        'cep',
        'bairro',
        'cidade',
        'estado'
    ];

    public function vehicle(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = encrypt($value);
    }

    public function getNameAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setEmailAttribute(string $value): void
    {
        $this->attributes['email'] = encrypt($value);
    }

    public function getEmailAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setCelularAttribute(string $value): void
    {
        $this->attributes['celular'] = encrypt($value);
    }

    public function getCelularAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setTelefoneAttribute(string $value): void
    {
        $this->attributes['telefone'] = encrypt($value);
    }

    public function getTelefoneAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setCpfAttribute(string $value): void
    {
        $this->attributes['cpf'] = encrypt($value);
    }

    public function getCpfAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setEnderecoAttribute(string $value): void
    {
        $this->attributes['endereco'] = encrypt($value);
    }

    public function getEnderecoAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setCepAttribute(string $value): void
    {
        $this->attributes['cep'] = encrypt($value);
    }

    public function getCepAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setBairroAttribute(string $value): void
    {
        $this->attributes['bairro'] = encrypt($value);
    }

    public function getBairroAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setCidadeAttribute(string $value): void
    {
        $this->attributes['cidade'] = encrypt($value);
    }

    public function getCidadeAttribute(string $value): string
    {
        return decrypt($value);
    }
}

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
        'type',
        'name',
        'email',
        'cellphone',
        'telephone',
        'cpf',
        'rg',
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'birthday',
        'profession',
        'address',
        'number',
        'postal_code',
        'neighborhood',
        'city',
        'estate'
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

    public function setCellphoneAttribute(string $value): void
    {
        $this->attributes['cellphone'] = encrypt($value);
    }

    public function getCellphoneAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setTelephoneAttribute(string $value): void
    {
        $this->attributes['telephone'] = encrypt($value);
    }

    public function getTelephoneAttribute(string $value): string
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

    public function setAddressAttribute(string $value): void
    {
        $this->attributes['address'] = encrypt($value);
    }

    public function getAddressAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setPostalCodeAttribute(string $value): void
    {
        $this->attributes['postal_code'] = encrypt($value);
    }

    public function getPostalCodeAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setNeighborhoodAttribute(string $value): void
    {
        $this->attributes['neighborhood'] = encrypt($value);
    }

    public function getNeighborhoodAttribute(string $value): string
    {
        return decrypt($value);
    }

    public function setCityAttribute(string $value): void
    {
        $this->attributes['city'] = encrypt($value);
    }

    public function getCityAttribute(string $value): string
    {
        return decrypt($value);
    }
}

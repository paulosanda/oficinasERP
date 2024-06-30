<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

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
        'state',
    ];

    public function vehicle(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    public function setEmailAttribute(?string $value): void
    {
        $this->attributes['email'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function getEmailAttribute(?string $value): ?string
    {
        return $value !== null ? Crypt::decryptString($value) : null;
    }

    public function setCellphoneAttribute(?string $value): void
    {
        $this->attributes['cellphone'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function getCellphoneAttribute(?string $value): ?string
    {
        return $value !== null ? Crypt::decryptString($value) : null;
    }

    public function setTelephoneAttribute(?string $value): void
    {
        $this->attributes['telephone'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function getTelephoneAttribute(?string $value): ?string
    {
        return $value !== null ? Crypt::decryptString($value) : null;
    }

    public function setCpfAttribute(?string $value): void
    {
        $this->attributes['cpf'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function getCpfAttribute(?string $value): ?string
    {
        return $value !== null ? Crypt::decryptString($value) : null;
    }

    public function setAddressAttribute(?string $value): void
    {
        $this->attributes['address'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function getAddressAttribute(?string $value): ?string
    {
        return $value !== null ? Crypt::decryptString($value) : null;
    }

    public function setPostalCodeAttribute(?string $value): void
    {
        $this->attributes['postal_code'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function getPostalCodeAttribute(?string $value): ?string
    {
        return $value !== null ? Crypt::decryptString($value) : null;
    }

    public function setNeighborhoodAttribute(?string $value): void
    {
        $this->attributes['neighborhood'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function getNeighborhoodAttribute(?string $value): ?string
    {
        return $value !== null ? Crypt::decryptString($value) : null;
    }

    public function setCityAttribute(?string $value): void
    {
        $this->attributes['city'] = $value !== null ? Crypt::encryptString($value) : null;
    }

    public function getCityAttribute(?string $value): ?string
    {
        return $value !== null ? Crypt::decryptString($value) : null;
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    const COMPANY_INDEX = 'company_id';

    const SYSTEM_ADMIN = 1;

    protected $with = ['users'];

    protected $table = 'companies';

    protected $fillable = [
        'logo',
        'company_name',
        'cnpj',
        'inscricao_estadual',
        'inscricao_municipal',
        'address',
        'number',
        'neighborhood',
        'postal_code',
        'city',
        'state',
        'cellphone',
        'email',
        'active',
        'max_users',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}

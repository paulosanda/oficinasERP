<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduledService extends Model
{
    use HasFactory;

    protected $with = ['company', 'customer', 'vehicle'];

    protected $fillable = [
        'company_id',
        'customer_id',
        'servico',
        'data_prevista',
        'data_realizado',
        'lembrete_ativo',
        'observacao',
        'resposta',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}

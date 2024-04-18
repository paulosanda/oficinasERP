<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Quote extends Model
{
    use HasFactory;

    protected $with = ['customer'];

    protected $fillable = [
        'company_id',
        'company_numbering',
        'customer_id',
        'vehicle_id',
        'data_de_entrada',
        'data_de_saida',
        'descricao_do_problema',
        'laudo',
        'observacao',
        'sub_total_servico',
        'sub_total_produto',
        'total_bruto',
        'desconto',
        'total_liquido',
        'total'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotePart extends Model
{
    use HasFactory;

    protected $fillable = [
        'quote_id',
        'codigo_do_servico',
        'descricao',
        'quantidade',
        'valor',
        'desconto',
        'sub_total',
    ];
}

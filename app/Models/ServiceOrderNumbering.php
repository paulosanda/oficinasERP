<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrderNumbering extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'numbering',
    ];
}

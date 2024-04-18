<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_id',
        'avarias_frente',
        'av_frente_foto',
        'avarias_traseiro',
        'av_traseira_foto',
        'avarias_direito',
        'av_direito_foto',
        'avarias_esquerdo',
        'av_esquerdo_foto',
        'avarias_teto',
        'av_teto_foto',
        'combustivel',
        'combustivel_foto',
        'avaliacao'
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}

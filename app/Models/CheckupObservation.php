<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CheckupObservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'checkup_id',
        'checkup_observation_type_id',
        'observation',
    ];

    public function checkupObservationType(): BelongsTo
    {
        return $this->belongsTo(CheckupObservationType::class);
    }
}

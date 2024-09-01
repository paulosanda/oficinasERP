<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Checkup extends Model
{
    use HasFactory;

    const EVALUATION_PENDING = 'pending';

    const EVALUATION_APPROVED = 'approved for use';

    const EVALUATION_MAINTENANCE = 'maintenance recommended';

    protected $fillable = [
        'company_id',
        'customer_id',
        'vehicle_id',
        'status',
        'front_damage',
        'front_photo',
        'back_damage',
        'back_photo',
        'right_side_damage',
        'right_side_photo',
        'left_side_damage',
        'left_side_photo',
        'roof_damage',
        'roof_photo',
        'fuel_gauge',
        'fuel_gauge_photo',
        'evaluation',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function checkupObservation(): HasMany
    {
        return $this->hasMany(CheckupObservation::class);
    }
}

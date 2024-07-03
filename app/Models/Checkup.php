<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    use HasFactory;

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

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
}

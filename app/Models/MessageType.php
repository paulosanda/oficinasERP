<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MessageType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'schedulable_service_id',
        'model_name',
        'title',
        'message'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    protected function schedulableService(): BelongsTo
    {
        return $this->belongsTo(SchedulableService::class);
    }
}


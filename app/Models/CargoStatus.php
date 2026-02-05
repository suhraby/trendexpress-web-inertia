<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CargoStatus extends Model
{
    protected $table = 'cargo_status_history';

    protected $fillable = [
        'cargo_id',
        'status_id',
        'note',
        'status_at',
    ];

    protected $casts = [
        'status_at' => 'date',
    ];

    public function cargo(): BelongsTo
    {
        return $this->belongsTo(Cargo::class, 'cargo_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function scopeLatestStatus($query)
    {
        return $query->orderByDesc('status_at');
    }
}

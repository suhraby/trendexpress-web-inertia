<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Translatable\HasTranslations;

class Status extends Model
{
    use HasTranslations;

    protected $fillable = [
        'name',
        'sort_order',
        'icon',
        'is_last',
    ];

    protected $casts = [
        'is_last' => 'boolean',
    ];

    public array $translatable = [
        'name',
    ];

    public function cargos(): BelongsToMany
    {
        return $this->belongsToMany(
            Cargo::class,
            'cargo_status_history',
            'status_id',
            'cargo_id'
        )
            ->withPivot(['status_at', 'note'])
            ->withTimestamps();
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(CargoStatus::class, 'status_id');
    }
}

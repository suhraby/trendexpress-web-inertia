<?php

namespace App\Models;

use Spatie\Image\Enums\Fit;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cargo extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'number',
        'weight',
        'received_address',
        'user_id'
    ];

    public function statuses(): BelongsToMany
    {
        return $this->belongsToMany(
            Status::class,
            'cargo_status_history',
            'cargo_id',
            'status_id'
        )
            ->withPivot(['status_at', 'note'])
            ->withTimestamps();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(CargoStatus::class, 'cargo_id');
    }

    public function orderedHistories(): HasMany
    {
        return $this->hasMany(CargoStatus::class, 'cargo_id')
            ->orderBy('status_at');
    }

    public function latestStatus()
    {
        return $this->belongsToMany(
            Status::class,
            'cargo_status_history',
            'cargo_id',
            'status_id'
        )
            ->withPivot(['status_at', 'note'])
            ->orderByPivot('status_at', 'desc')
            ->limit(1);
    }

    public function latestStatusHistory(): HasMany
    {
        return $this->statusHistories()
            ->latest('status_at')
            ->limit(1);
    }

    public function getCurrentStatusAttribute(): ?Status
    {
        return $this->latestStatusHistory->first()?->status;
    }

    public function getCurrentStatusAtAttribute(): ?Carbon
    {
        return $this->latestStatusHistory->first()?->status_at;
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cargo_images')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        // Main image conversion - 1920x1080 maintaining aspect ratio
        $this->addMediaConversion('main')
            ->fit(Fit::Max, 1920, 1080)
            ->quality(85)
            ->format('jpg')
            ->performOnCollections('cargo_images')
            ->nonQueued(); // Use ->queued() for production with queue workers

        // Thumbnail conversion - 300x300 crop
        $this->addMediaConversion('thumbnail')
            ->fit(Fit::Crop, 300, 300)
            ->quality(80)
            ->format('jpg')
            ->performOnCollections('cargo_images')
            ->nonQueued(); // Use ->queued() for production with queue workers
    }
}

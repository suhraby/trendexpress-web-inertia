<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Section extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'name',
        'header',
        'title',
        'description',
        'is_active',
        'sort_order',
        'sectionable_type',
        'sectionable_id'
    ];

    public array $translatable = [
        'header',
        'title',
        'description'
    ];

    public function sectionable(): MorphTo
    {
        return $this->morphTo();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    public function scopeByName($query, $name)
    {
        return $query->where('name', $name);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('section_image')->singleFile();
    }
}

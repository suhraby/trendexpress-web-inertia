<?php

namespace App\Models;

use Illuminate\Console\View\Components\Secret;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Translatable\HasTranslations;

class HeroSection extends Model implements HasMedia
{
    use HasTranslations, InteractsWithMedia;

    protected $fillable = [
        'button_text',
        'button_link',
        'search_label',
        'search_placeholder',
        'search_button_text',
    ];

    public array $translatable = [
        'button_text',
        'search_label',
        'search_placeholder',
        'search_button_text',
    ];

    public function section(): MorphOne
    {
        return $this->morphOne(Section::class, 'sectionable');
    }

    public function sectionItems(): MorphMany
    {
        return $this->morphMany(SectionItem::class, 'itemable');
    }
}

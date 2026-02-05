<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class AboutSection extends Model
{
    public function section(): MorphOne
    {
        return $this->morphOne(Section::class, 'sectionable');
    }

    public function sectionItems(): MorphMany
    {
        return $this->morphMany(SectionItem::class, 'itemable');
    }
}

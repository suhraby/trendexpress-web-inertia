<?php

namespace App\Http\Resources;

use App\Models\HeroSection;
use App\Models\MissionSection;
use App\Models\ServiceSection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class   SectionItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $res = [
            'title' => $this->getTranslations('title'),
        ];

        if ($this->itemable_type === HeroSection::class || $this->itemable_type === MissionSection::class) {
            $res['icon'] = $this?->icon;
        }

        if ($this->itemable_type === MissionSection::class || $this->itemable_type === ServiceSection::class) {
            $res['description'] = $this?->getTranslations('description');
        }

        if ($this->itemable_type === ServiceSection::class) {
            $res['image'] = $this->getFirstMediaUrl('item_image');
        }

        return $res;
    }
}

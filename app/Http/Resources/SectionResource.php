<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $res = [
            'name' => $this->name,
            'items' => SectionItemResource::collection($this->sectionable->sectionItems)
        ];

        if ($this->name !== 'contact') {
            $res['title'] = $this->getTranslations('title');
        }

        if ($this->name !== 'hero') {
            $res['header'] = $this->getTranslations('header');
        }

        if ($this->name === 'hero' || $this->name === 'about' || $this->name === 'contact') {
            $res['description'] = $this->getTranslations('description');
        }

        if ($this->name === 'hero' || $this->name === 'mission' || $this->name === 'about') {
            $res['image'] = $this->getFirstMediaUrl('section_image');
        }

        if ($this->name === 'hero') {
            $res['button_text'] = $this->sectionable->getTranslations('button_text');
            $res['button_link'] = $this->sectionable->button_link;
            $res['search_label'] = $this->sectionable->getTranslations('search_label');
            $res['search_placeholder'] = $this->sectionable->getTranslations('search_placeholder');
            $res['search_button_text'] = $this->sectionable->getTranslations('search_button_text');
        }

        return $res;
    }
}

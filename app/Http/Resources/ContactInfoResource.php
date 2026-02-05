<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'icon' => $this->icon,
            'context' => $this->context ?  $this->context : null,
            'value'  => $this->value ?  $this->value : null,
            'value_localization' => $this->value_localization ?  $this->getTranslations('value_localization') : (object)[],
            'type' => $this->type,
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CargoStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->status->id,
            'name' => $this->status->getTranslations('name'),
            'status_at' => date('d.m.Y', strtotime($this->status_at)),
            'note' => $this->note,
        ];
    }
}

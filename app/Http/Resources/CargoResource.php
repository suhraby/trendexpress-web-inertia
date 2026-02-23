<?php

namespace App\Http\Resources;

use App\Http\Resources\CargoStatusResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CargoImageResource;

class CargoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'number' => $this->number,
            'weight' => $this->weight,
            'received_address' => $this->received_address,
            'current_status_id' => $this->current_status->id,
            'current_status' => $this->current_status->getTranslations('name'),
            'current_status_icon' => $this->current_status->icon,
            'created_at' => date('m.d.Y', strtotime($this->created_at)),
            'status_histories' => CargoStatusResource::collection($this->orderedHistories),
            'images' => CargoImageResource::collection($this->getMedia('cargo_images'))
        ];
    }
}

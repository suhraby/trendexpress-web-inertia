<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'identifier' => $this->identifier,
            'name' => $this->isTempName() ? '' : $this->name,
            'surname' => $this->isTempSurname() ? '' : $this->surname,
            'phone_number' => $this->isTempPhone() ? '' : $this->phone_number,
            'email' => $this->isTempEmail() ? '' : $this->email,
            'has_default_password' => $this->has_default_password,
        ];
    }
}

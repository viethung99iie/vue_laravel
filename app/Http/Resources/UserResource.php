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
            'id' => $this->id,
            'address' => $this->id,
            'birthday' => $this->id,
            'email' => $this->id,
            'image' => $this->id,
            'name' => $this->id,
            'phone' => $this->id,
            'publish' => $this->id,
        ];
    }
}

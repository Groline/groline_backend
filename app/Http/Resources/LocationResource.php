<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'region_id' => $this->region_id,
            'address' => $this->address,
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'region' => $this->whenLoaded('region'),
            'user' => $this->whenLoaded('user'),
        ];
    }
}

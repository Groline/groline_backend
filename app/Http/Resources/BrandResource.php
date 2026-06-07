<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name_ar'    => $this->name_ar,
            'name_en'    => $this->name_en,
            'name_fr'    => $this->name_fr,
            'slug'       => $this->slug,
            'image'      => $this->image,
            'status'     => (bool) $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

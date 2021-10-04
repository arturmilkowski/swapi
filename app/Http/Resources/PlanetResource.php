<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PersonResource;

class PlanetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            // 'people' => PersonResource::collection($this->people),
            'name' => $this->name,
            'terrain' => $this->terrain,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

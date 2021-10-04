<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\PlanetResource;

class PersonResource extends JsonResource
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
            // 'planet_id' => $this->planet_id,
            'planet' => new PlanetResource($this->planet),
            'name' => $this->name,
            'height' => $this->height,
            'mass' => $this->mass,
            'hair_color' => $this->hair_color,
            'gender' => $this->gender,
            'homeworld' => $this->homeworld,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

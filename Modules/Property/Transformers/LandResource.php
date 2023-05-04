<?php

namespace Modules\Property\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Transformers\AgencyResource;
use Modules\City\Transformers\CityResource;
use Modules\City\Transformers\CountryResource;

class LandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'user_id' => $this->user_id,
            'property_type_id' => $this->property_type_id,
            'city_id' => $this->city_id,
            'country_id' => $this->country_id,
            'address' => $this->address ?? '',
            'latitude' => $this->latitude ?? 0,
            'longitude' => $this->longitude ??0,
            'length' => $this->length,
            'width' => $this->width,
            'budget' => $this->budget,
            'description' => $this->description ?? '',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'features' => $this->features->pluck('title'),
            'gallery' => $this->getAllMediaUrls('lands'),
            'user' => new AgencyResource($this->user),
            'property_type' => $this->whenLoaded('propertyType'),
            'city' => new CityResource($this->city->pluck('name')),
            'country' => new CountryResource($this->country->pluck('name'))
        ];
    }
}

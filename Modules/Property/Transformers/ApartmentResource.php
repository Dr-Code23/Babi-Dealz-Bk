<?php

namespace Modules\Property\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Transformers\AgencyResource;
use Modules\City\Transformers\CityResource;
use Modules\City\Transformers\CountryResource;

class ApartmentResource extends JsonResource
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
            'agency' => new AgencyResource($this->user),
            'property_type' => $this->propertytype,
            'city' => new CityResource($this->city->pluck('name')),
            'country' => new CountryResource($this->country->pluck('name')),
            'address' => $this->address ?? '',
            'latitude' => $this->latitude ?? 0,
            'longitude' => $this->longitude ??0,
            'space' => $this->space,
            'budget' => $this->budget,
            'number_of_rooms' => $this->number_of_rooms,
            'number_of_kitchen' => $this->number_of_kitchen,
            'number_of_bathroom' => $this->number_of_bathroom,
            'role_number' => $this->role_number,
            'description' => $this->description ?? '',
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'features' => $this->features->pluck('title'),
            'gallery' => $this->getAllMediaUrls('apartments'),

        ];
    }
}

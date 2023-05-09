<?php

namespace Modules\Property\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Auth\Transformers\AgencyResource;
use Modules\City\Transformers\CityResource;
use Modules\City\Transformers\CountryResource;

class ShopResource extends JsonResource
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
            'length' => $this->length,
            'width' => $this->width,
            'budget' => $this->budget,
            'description' => $this->description ?? '',
            'is_there_path_room'=>$this->is_there_path_room??'',
            'space_path_room'=>$this->space_path_room,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'features' => $this->features->pluck('title'),
            'gallery' => $this->getAllMediaUrls('shops'),
            'type'=> $this->type

        ];
    }
}

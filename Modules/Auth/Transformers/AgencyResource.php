<?php

namespace Modules\Auth\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgencyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'agency_owner'=>$this->agency_owner,
            'address' => $this->address,
            'phone' => $this->phone,
//            'photo' => $this->getFirstMediaUrl('avatar'),
            'type' => $this->type,

        ];
    }
}

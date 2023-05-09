<?php

namespace Modules\Feature\Transformers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


class FeatureResource extends JsonResource
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
            'title' => $this->title,

        ];
    }
}

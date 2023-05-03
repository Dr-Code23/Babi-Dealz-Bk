<?php

namespace Modules\Favorite\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Service\Transformers\ServiceResource;


class FavoriteResource extends JsonResource
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
            'favoritable' => $this->favoritable,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

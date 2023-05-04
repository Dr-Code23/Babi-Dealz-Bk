<?php

namespace Modules\ContactUS\Transformers;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'name' => $this->name ?? '',
            'phone' => $this->phone ?? 0,
            'email' => $this->mail ?? '',
            'subject' => $this->subject ?? '',
            'message' => $this->message ?? '',
            'type' => $this->type,
            'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
        ];    }
}

<?php

namespace Modules\Property\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVillaRequest extends FormRequest
{
    public function rules()
    {
        return [
            'property_type_id' => 'exists:property_types,id',
            'city_id' => 'exists:cities,id',
            'country_id' => 'exists:countries,id',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'space' => 'numeric|min:1',
            'budget' => 'regex:/^\d+(\.\d{1,2})?$/',
            'number_of_rooms' => 'integer|min:1',
            'number_of_kitchen' => 'integer|min:0',
            'number_of_bathroom' => 'integer|min:1',
            'role_villa' => 'integer|min:1',
            'description' => 'nullable|string|max:1000',
            'is_there_swimming_pool' => 'nullable|string|max:1000',
            'gallery' => ['max:2048'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}

<?php

namespace Modules\Property\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShopRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return
            [
                'property_type_id' => 'exists:property_types,id',
                'city_id' => 'exists:cities,id',
                'country_id' => 'exists:countries,id',
                'address' => 'nullable|string|max:255',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'length' => 'numeric|min:1',
                'width' => 'numeric|min:1',
                'budget' => 'regex:/^\d+(\.\d{1,2})?$/',
                'description' => 'nullable|string|max:1000',
                'is_there_path_room' => 'nullable|string|max:1000',
                'space_path_room' =>'string|max:1000',
                'gallery' => ['max:2048'],
            ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}

<?php

namespace Modules\Property\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LandRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'property_type_id' => 'required|exists:property_types,id',
            'city_id' => 'required|exists:cities,id',
            'country_id' => 'required|exists:countries,id',
            'address' => 'nullable|string|max:255',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'length' => 'required|numeric|min:1',
            'width' => 'required|numeric|min:1',
            'budget' => 'required|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'nullable|string|max:1000',
            'gallery' => ['required','max:2048'],
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

<?php

namespace Modules\Auth\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAgencyRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name' => 'required|string|between:2,100',
            'agency_owner' => 'required|string|between:2,100',
            'password' => 'required|string|confirmed|min:6',
            'address' => 'nullable',
            'phone' => ['required', 'numeric', 'digits_between:10,12', 'unique:users,phone'],
            'latitude' => ['regex:/^[-]?([1-8]?\d(\.\d+)?|90(\.0+)?)$/'],
            'longitude' => ['regex:/^[-]?((1[0-7]|[1-9])?\d(\.\d+)?|180(\.0+)?)$/'],

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

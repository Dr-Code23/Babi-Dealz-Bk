<?php

namespace Modules\City\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\City\Entities\Country;
use Modules\City\Http\Requests\CountryRequest;
use Modules\ApiResource\ApiResponse;

class CountryController extends Controller
{
    use apiResponse;

    public function index()
    {
        $countries = Country::all();

        return $this->apiResponse($countries, 'success', 200);
    }

    public function show(Country $country)
    {
        return $this->apiResponse($country, 'success', 200);
    }

    public function store(CountryRequest $request)
    {
        $country = Country::create($request->only('name'));

        if ($request->hasFile('icon')) {
            $country->addMediaFromRequest('icon')->toMediaCollection('icon');
        }

        return $this->apiResponse($country, 'success', 201);
    }

    public function update(Request $request, $country)
    {
        $country->update($request->only('name'));

        if ($request->hasFile('icon')) {
            $country->clearMediaCollection('icon');
            $country->addMediaFromRequest('icon')->toMediaCollection('icon');
        }

        return $this->apiResponse($country, 'success', 200);
    }

    public function destroy(Country $country)
    {
        $country->delete();

        return $this->apiResponse(null, 'success', 204);
    }
}

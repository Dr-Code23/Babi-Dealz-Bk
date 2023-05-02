<?php

namespace Modules\City\Services;

use Illuminate\Http\Request;
use Modules\ApiResource\ApiResponse;
use Modules\City\Entities\Country;
use Modules\City\Http\Requests\CountryRequest;

class CountryService
{

    private $countryModel;

    public function __construct(Country $country)
    {
        $this->countryModel = $country;
    }
    use apiResponse;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function index()
    {
        $countries = $this->countryModel->with('media')->get();

        return $this->apiResponse($countries, 'success', 200);
    }

    /**
     * @param Country $country
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        $country->with('media');
        return $this->apiResponse($country, 'success', 200);
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function store($request)
    {
        $country = $this->countryModel->create($request->only('name'));

        if ($request->hasFile('icon')) {
            $country->addMediaFromRequest('icon')->toMediaCollection('icon');
        }
        $country->with('media');
        return $this->apiResponse($country, 'success', 201);
    }

    /**
     * @param $request
     * @param $country
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function update($request,$country)
    {
        $country = $this->countryModel->find($country);
        $country->update(['name'=>$request->name]);

        if ($request->hasFile('icon')) {
            $country->clearMediaCollection('icon');
            $country->addMediaFromRequest('icon')->toMediaCollection('icon');
        }
        $country->with('media');

        return $this->apiResponse($country, 'success', 200);
    }

    /**
     * @param Country $country
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        $country->delete();

        return $this->apiResponse([], ' deleted success', 200);
    }
}

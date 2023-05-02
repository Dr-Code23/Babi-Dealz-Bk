<?php

namespace Modules\City\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\City\Entities\City;
use Modules\ApiResource\ApiResponse;
use Modules\City\Http\Requests\CityRequest;

class CityController extends Controller
{
    use ApiResponse;

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function index(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $cities = City::all();

        return $this->apiResponse($cities, 'success', 200);
    }

    /**
     * @param City $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function show(City $city)
    {
        return $this->apiResponse($city, 'success', 200);
    }

    /**
     * @param CityRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {


        $city = City::create($request);

        return $this->apiResponse($city, 'City created successfully.', 201);
    }

    /**
     * @param CityRequest $request
     * @param City $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function update(CityRequest $request, City $city)
    {


        $city->update($request);

        return $this->apiResponse($city, 'City updated successfully.', 200);
    }

    /**
     * @param City $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        $city->delete();

        return $this->apiResponse(null, 'City deleted successfully.', 204);
    }
}

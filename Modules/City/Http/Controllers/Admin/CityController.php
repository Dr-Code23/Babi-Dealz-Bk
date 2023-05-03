<?php

namespace Modules\City\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\City\Entities\City;
use Modules\ApiResource\ApiResponse;
use Modules\City\Http\Requests\CityRequest;
use Modules\City\Services\CityService;

class CityController extends Controller
{
    private CityService $cityService;

    public function __construct(CityService $city)
    {
        $this->cityService = $city;
    }
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function index(): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
      return $this->cityService->index();
    }

    /**
     * @param City $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function show(City $city)
    {
        return $this->cityService->show($city);
    }

    /**
     * @param CityRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        return $this->cityService->store($request);
    }

    /**
     * @param CityRequest $request
     * @param City $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function update(CityRequest $request,$city)
    {
        return $this->cityService->update($request,$city);
    }

    /**
     * @param City $city
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
       return $this->cityService->destroy($city);
    }
}

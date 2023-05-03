<?php

namespace Modules\City\Services;

use Modules\ApiResource\ApiResponse;
use Modules\City\Entities\City;
use Modules\City\Entities\Country;

class CityService
{
    use apiResponse;
    private City $cityModel;

    public function __construct(City $city)
    {
        $this->cityModel = $city;
    }


    public function index()
    {
        $cities = $this->cityModel->all();

        return $this->apiResponse($cities, 'success', 200);
    }

    public function show(City $city)
    {
        return $this->apiResponse($city, 'success', 200);
    }


    public function store($request)
    {

        $city = $this->cityModel->create(
            [
            'name'=>$request['name'],
            'country_id'=>$request['country_id']
            ]
        );

        return $this->apiResponse($city, 'City created successfully.', 201);
    }


    public function update($request, $city)
    {
        $city = $this->cityModel->query()->where('id',$city)->first();
        $city->update(
            [
                'name'=>$request['name'],
                'country_id'=>$request['country_id'] ?? $city->country_id

        ]
        );

        return $this->apiResponse($city, 'City updated successfully.', 200);
    }

    public function destroy(City $city)
    {
        $city->delete();

        return $this->apiResponse([], 'City deleted successfully.', 200);
    }
}

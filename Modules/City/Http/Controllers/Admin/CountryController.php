<?php

namespace Modules\City\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\City\Entities\Country;
use Modules\City\Http\Requests\CountryRequest;
use Modules\ApiResource\ApiResponse;
use Modules\City\Services\CountryService;

class CountryController extends Controller
{
    use apiResponse;

    /**
     * @var CountryService
     */
    private CountryService $countryService;

    /**
     * @param CountryService $country
     */
    public function __construct(CountryService $country)
    {
        $this->countryService = $country;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function index()
    {
        return $this->countryService->index();
    }

    public function show(Country $country)
    {
        return $this->countryService->show($country) ;
    }

    public function store(CountryRequest $request)
    {
        return $this->countryService->store($request) ;
    }

    public function update(Request $request, $country)
    {
        return $this->countryService->update($request,$country) ;

    }

    public function destroy(Country $country)
    {
        return $this->countryService->destroy($country) ;

    }
}

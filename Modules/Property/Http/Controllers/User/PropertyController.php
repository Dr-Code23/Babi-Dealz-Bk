<?php

namespace Modules\Property\Http\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ApiResource\ApiResponse;
use Modules\Property\Entities\Apartment;
use Modules\Property\Entities\Hangar;
use Modules\Property\Entities\Land;
use Modules\Property\Entities\Shop;
use Modules\Property\Entities\Villa;
use Modules\Property\Services\ApartmentServices;
use Modules\Property\Services\HangerServices;
use Modules\Property\Services\LandServices;
use Modules\Property\Services\PropertyUserServices;
use Modules\Property\Services\ShopServices;
use Modules\Property\Services\VillaServices;
use Modules\Property\Transformers\ApartmentResource;
use Modules\Property\Transformers\HangarResource;
use Modules\Property\Transformers\LandResource;
use Modules\Property\Transformers\ShopResource;
use Modules\Property\Transformers\VillaResource;

class PropertyController extends Controller
{
    use ApiResponse;
    private PropertyUserServices $propertyuserServices;


    public function __construct(PropertyUserServices $propertyuserServices)
    {
        $this->propertyuserServices =$propertyuserServices;
    }


    public function index()
    {
        $apartments = Apartment::latest()->get();
        $hangars = Hangar::latest()->get();
        $lands = Land::latest()->get();
        $shops = Shop::latest()->get();
        $villas = Villa::latest()->get();

        return $this->apiResponse(
            [
                'apartments'=>ApartmentResource::collection( $apartments),
                'hangars'=>HangarResource::collection( $hangars),
                'lands'=>LandResource::collection( $lands),
                'shops'=>ShopResource::collection( $shops),
                'villas'=>VillaResource::collection( $villas)
        ], 'Successfully retrieved all propertys.', 200);
    }

    public function showApartment($id)
        {
            return   $this->propertyuserServices->getDataByIdApartment($id);
        }
    public function showVilla($id)
        {
            return   $this->propertyuserServices->getDataByIdVilla($id);
        }
    public function showLand($id)
        {
            return   $this->propertyuserServices->getDataByIdLand($id);
        }
    public function showShop($id)
        {
            return   $this->propertyuserServices->getDataByIdShop($id);
        }
    public function showHangar($id)
        {
            return   $this->propertyuserServices->getDataByIdHangar($id);
        }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('property::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('property::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('property::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}

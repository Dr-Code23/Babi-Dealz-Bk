<?php

namespace Modules\Property\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ApiResource\ApiResponse;
use Modules\Property\Services\ApartmentServices;
use Modules\Property\Services\HangerServices;
use Modules\Property\Services\LandServices;
use Modules\Property\Services\PropertyAdminServices;
use Modules\Property\Services\ShopServices;
use Modules\Property\Services\VillaServices;

class PropertyController extends Controller
{
    use ApiResponse;

    private PropertyAdminServices $propertyAdminServices;



    public function __construct( PropertyAdminServices $propertyAdminServices)
    {
        $this->propertyAdminServices =$propertyAdminServices;
    }

    public function indexApartment()
    {
        return   $this->propertyAdminServices->getAllDataApartment();
    }
    public function indexVilla()
    {
        return   $this->propertyAdminServices->getAllDataVilla();
    }
    public function indexLand()
    {
        return   $this->propertyAdminServices->getAllDataLand();
    }
    public function indexHangar()
    {
        return  $this->propertyAdminServices->getAllDataHangar();
    }
    public function indexShop()
    {
        return   $this->propertyAdminServices->getAllDataShop();
    }
    public function showApartment($id)
    {
        return  $this->propertyAdminServices->getDataByIdApartment($id);
    }
    public function showVilla($id)
    {
        return    $this->propertyAdminServices->getDataByIdVilla($id);
    }
    public function showLand($id)
    {
        return   $this->propertyAdminServices->getDataByIdLand($id);
    }
    public function showShop($id)
    {
        return   $this->propertyAdminServices->getDataByIdShop($id);
    }
    public function showHangar($id)
    {
        return   $this->propertyAdminServices->getDataByIdHangar($id);
    }



    public function index()
    {
        return view('property::index');
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

<?php

namespace Modules\Property\Http\Controllers\Admin;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ApiResource\ApiResponse;
use Modules\Property\Services\ApartmentServices;
use Modules\Property\Services\HangerServices;
use Modules\Property\Services\LandServices;
use Modules\Property\Services\ShopServices;
use Modules\Property\Services\VillaServices;

class PropertyController extends Controller
{
    use ApiResponse;
    private ApartmentServices $apartmentServices;
    private HangerServices $hangarServices;
    private LandServices $landServices;
    private ShopServices $shopServices;
    private VillaServices $villaServices;



    public function __construct
    (
        ApartmentServices $apartmentServices,
        HangerServices $hangarServices,
        LandServices $landServices,
        ShopServices $shopServices,
        VillaServices $villaServices
    )
    {
        $this->apartmentServices = $apartmentServices;
        $this->hangarServices = $hangarServices;
        $this->landServices = $landServices;
        $this->shopServices = $shopServices;
        $this->villaServices = $villaServices;

    }

    public function indexApartment()
    {
        return $this->apartmentServices->getAllData();
    }
    public function indexVilla()
    {
        return $this->villaServices->getAllData();
    }
    public function indexLand()
    {
        return $this->landServices->getAllData();
    }
    public function indexHangar()
    {
        return $this->hangarServices->getAllData();
    }
    public function indexShop()
    {
        return $this->shopServices->getAllData();
    }
    public function showApartment($id)
    {
        return $this->apartmentServices->getDataById($id);
    }
    public function showVilla($id)
    {
        return $this->villaServices->getDataById($id);
    }
    public function showLand($id)
    {
        return $this->landServices->getDataById($id);
    }
    public function showShop($id)
    {
        return $this->shopServices->getDataById($id);
    }
    public function showHangar($id)
    {
        return $this->hangarServices->getDataById($id);
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

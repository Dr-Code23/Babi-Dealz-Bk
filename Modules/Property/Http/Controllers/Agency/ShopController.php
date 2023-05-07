<?php

namespace Modules\Property\Http\Controllers\Agency;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Property\Http\Requests\ShopRequest;
use Modules\Property\Http\Requests\UpdateShopRequest;
use Modules\Property\Services\ShopServices;

class ShopController extends Controller
{
    private ShopServices $shopServices;

    public function __construct(ShopServices $shopServices)
    {
        $this->shopServices = $shopServices;
    }
    public function index()
    {
        return $this->shopServices->getAllData();
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
    public function store(ShopRequest $request)
    {
        return $this->shopServices->storeData($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return $this->shopServices->getDataById($id);
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
    public function update(UpdateShopRequest $request, $id)
    {
        return $this->shopServices->updateDataById($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        return $this->shopServices->deleteData($id);
    }
}

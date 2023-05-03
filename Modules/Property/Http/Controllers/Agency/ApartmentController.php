<?php

namespace Modules\Property\Http\Controllers\Agency;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Property\Http\Requests\ApartmentRequest;
use Modules\Property\Services\ApartmentServices;

class ApartmentController extends Controller
{
    private ApartmentServices $apartmentServices;

    public function __construct(ApartmentServices $apartmentServices)
    {
        $this->apartmentServices = $apartmentServices;
    }
    public function index()
    {
        return $this->apartmentServices->getAllData();
    }

    public function create()
    {
        return view('property::create');
    }


    public function store(ApartmentRequest $request)
    {
        return $this->apartmentServices->storeData($request);
    }

    public function show($id)
    {
        return $this->apartmentServices->getDataById($id);
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

    public function update(ApartmentRequest $request, $id)
    {
        return $this->apartmentServices->updateDataById($request,$id);
    }

    public function destroy($id)
    {
        return $this->apartmentServices->deleteData($id);
    }
}

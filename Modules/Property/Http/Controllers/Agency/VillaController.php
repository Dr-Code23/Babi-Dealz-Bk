<?php

namespace Modules\Property\Http\Controllers\Agency;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Property\Http\Requests\UpdateVillaRequest;
use Modules\Property\Http\Requests\VillaRequest;
use Modules\Property\Services\VillaServices;

class VillaController extends Controller
{

    private VillaServices $villaServices;

    public function __construct(VillaServices $villaServices)
    {
        $this->villaServices = $villaServices;
    }
    public function index()
    {
        return $this->villaServices->getAllData();
    }

    public function create()
    {
        return view('property::create');
    }


    public function store(VillaRequest $request)
    {
        return $this->villaServices->storeData($request);
    }

    public function show($id)
    {
        return $this->villaServices->getDataById($id);
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

    public function update(UpdateVillaRequest $request, $id)
    {
        return $this->villaServices->updateDataById($request,$id);
    }

    public function destroy($id)
    {
        return $this->villaServices->deleteData($id);
    }
}

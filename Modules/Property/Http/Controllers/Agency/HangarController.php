<?php

namespace Modules\Property\Http\Controllers\Agency;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Property\Http\Requests\HangarRequest;
use Modules\Property\Http\Requests\UpdateHangarRequest;
use Modules\Property\Services\HangerServices;

class HangarController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    private HangerServices $hangarServices;

    public function __construct(HangerServices $hangarServices)
    {
        $this->hangarServices = $hangarServices;
    }
    public function index()
    {
        return $this->hangarServices->getAllData();
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
    public function store(HangarRequest $request)
    {
        return $this->hangarServices->storeData($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return $this->hangarServices->getDataById($id);
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
    public function update(UpdateHangarRequest $request, $id)
    {
        return $this->hangarServices->updateDataById($request,$id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        return $this->hangarServices->deleteData($id);
    }
}

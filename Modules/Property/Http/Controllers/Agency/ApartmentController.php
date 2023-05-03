<?php

namespace Modules\Property\Http\Controllers\Agency;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Property\Services\ApartmentServices;

class ApartmentController extends Controller
{
    private ApartmentServices $Apertment;

    public function __construct(ApartmentServices $Apertment)
    {
        $this->Apertment = $Apertment;
    }
    public function index()
    {
        return view('property::index');
    }

    public function create()
    {
        return view('property::create');
    }


    public function store(Request $request)
    {
        return $this->Apartment->storeData($request);
    }

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

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}

<?php

namespace Modules\Feature\Http\Controllers\Api\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Feature\Repositories\Interfaces\UserRepositoryInterface;

//use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;

class FeatureController extends Controller
{
    private UserRepositoryInterface $UserRepository;

    public function __construct(UserRepositoryInterface $UserRepository)
    {
        $this->UserRepository = $UserRepository;
    }
    public function index()
    {
//        return view('feature::index');
//        return $this->UserRepository->getAllData();
        return $this->UserRepository->getAllData();
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('feature::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
//        return  $this->UserRepository->storeData($request);
        return $this->UserRepository->storeData($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
//        return view('feature::show');

        return $this->UserRepository->getDataById($id);
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('feature::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        return $this->UserRepository->updateData($id, $request);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        return $this->UserRepository-> deleteData($id);
    }
}

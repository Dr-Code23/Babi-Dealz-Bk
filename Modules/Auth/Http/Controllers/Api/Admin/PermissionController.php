<?php

namespace Modules\Auth\Http\Controllers\Api\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\CreateAboutRequest;
use Modules\FrontEnd\Entities\About;

class PermissionController extends Controller
{

    private $aboutModel;

    public function __construct(About $about)
    {
        $this->aboutModel = $about;
    }

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        $permission = $this->aboutModel->latest()->get();
        return response()->json([
            'success' => true,
            'message' => 'success',
            'permission' => $permission
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return JsonResponse
     */

    public function store(CreateAboutRequest $request)
    {
        $permission = $this->aboutModel->create($request->all());
        return response()->json([
            'success' => true,
            'message' => 'success',
            'permission' => $permission
        ], 200);

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $permission = $this->aboutModel->query()->where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'success',
            'permission' => $permission
        ], 200);

    }


    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $permission = $this->aboutModel->query()->where('id', $id)->first();

        $permission->update($request);
        return response()->json([
            'success' => true,
            'message' => 'success update',
            'permission' => $permission
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $permission = $this->aboutModel->query()->where('id', $id)->first();
        $permission->delete();
        return response()->json([
            'success' => true,
            'message' => 'success delete',
        ], 200);
    }
}

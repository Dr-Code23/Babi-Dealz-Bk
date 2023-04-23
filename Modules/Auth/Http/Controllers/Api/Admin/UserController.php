<?php

namespace Modules\Auth\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Modules\Auth\Http\Requests\CreateRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Http\Requests\UpdateRequest;
use Modules\Auth\Transformers\DealsResource;
use Modules\Auth\Transformers\UserResource;

class UserController extends Controller
{

    private $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store', 'update', 'destroy']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-edit', ['only' => ['update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);

    }


    public function index(Request $request)
    {
        if ($request->q) {
            $data = $this->userModel->where("phone", "like", "%$request->q%")
                ->orwhere("name", "like", "%$request->q%")->orderBy('id', 'DESC')->get();
            return response()->json([
                'success' => true,
                'user' => UserResource::collection($data)
            ], 201);
        }
        $data = $this->userModel
            ->query()
            ->where('type', 'customer')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'user' => UserResource::collection($data)
        ], 201);
    }

    public function allDeals(Request $request)
    {
        if ($request->q) {
            $data = $this->userModel->where("phone", "like", "%$request->q%")
                ->orwhere("name", "like", "%$request->q%")->orderBy('id', 'DESC')->get();
            return response()->json([
                'success' => true,
                'user' => DealsResource::collection($data)
            ], 201);
        }
        $data = $this->userModel
            ->query()
            ->where('type', 'deals')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'user' => UserResource::collection($data)
        ], 201);
    }
    public function allAgency(Request $request)
    {
        if ($request->q) {
            $data = $this->userModel->where("phone", "like", "%$request->q%")
                ->orwhere("name", "like", "%$request->q%")->orderBy('id', 'DESC')->get();
            return response()->json([
                'success' => true,
                'user' => DealsResource::collection($data)
            ], 201);
        }
        $data = $this->userModel
            ->query()
            ->where('type', 'deals')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'user' => UserResource::collection($data)
        ], 201);
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */

    public function activate($id)
    {
        $item = User::find($id);
        if ($item) {
            $item->active = !$item->active;
            $item->save();
            return response()->json(['status' => $item->active, 'msg' => 'updated successfully']);
        }
        return response()->json(['status' => 0, 'msg' => 'invalid id']);
    }

}

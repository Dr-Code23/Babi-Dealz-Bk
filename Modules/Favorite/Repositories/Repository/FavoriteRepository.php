<?php

namespace Modules\Favorite\Repositories\Repository;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\Favorite\Entities\Favorite;
use Modules\Favorite\Repositories\Interfaces\FavoriteRepositoryInterface;
use Modules\Favorite\Transformers\FavoriteResource;
use Modules\Favorite\Transformers\FavoriteShowResource;
use Modules\Service\Entities\Service;

class FavoriteRepository implements FavoriteRepositoryInterface
{
    private $favoriteModel;

    public function __construct(Favorite $favorite)
    {
        $this->favoriteModel = $favorite;
    }

    public function index()
    {

        $Favorite = $this->favoriteModel->where('user_id',Auth::id())->latest()->get();
        return ['statusCode' => 200, 'status' => true,
            'data' => FavoriteResource::collection($Favorite)
        ];

    }

    public function store($data)
    {


    }

    public function show($id)
    {

        $favorite = $this->favoriteModel->find($id);
        return ['statusCode' => 200, 'status' => true,
            'data' => new FavoriteResource($favorite)
        ];
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $favorite = $this->favoriteModel->where(['service_id'=>$id,'user_id'=>Auth::id()])->delete();
        $msg = 'Deleted';
        return response()->json(['statusCode' => 200, 'status' => true, 'message' => $msg]);
    }


}

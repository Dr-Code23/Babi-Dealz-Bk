<?php

namespace Modules\Favorite\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Modules\ApiResource\ApiResponse;
use Modules\Favorite\Entities\Favorite;
use Modules\Favorite\Transformers\FavoriteResource;
use Modules\Property\Entities\Apartment;
use Modules\Property\Entities\Hangar;
use Modules\Property\Entities\Land;
use Modules\Property\Entities\Shop;
use Modules\Property\Entities\Villa;

class FavoriteService
{
     use apiResponse;
    private $favoriteModel;
    private Apartment $apartmentModel;
    private Villa $villaModel;
    private Hangar $hangarModel;
    private Land $landModel;
    private Shop $shopModel;

    public function __construct(Favorite $favorite, Apartment $apartment,Villa $villa,Hangar $hangar,Land $land ,Shop $shop)
    {
        $this->favoriteModel = $favorite;
        $this->apartmentModel = $apartment;
        $this->villaModel = $villa;
        $this->hangarModel = $hangar;
        $this->landModel = $land;
        $this->shopModel = $shop;
    }

    public function index()
    {

        $Favorite = $this->favoriteModel->where('user_id',Auth::id())->latest()->get();
        return $this->apiResponse(
             FavoriteResource::collection($Favorite),
            'success',
            200
        );

    }

    public function favorite($request)
    {
        switch ($request->type) {
            case 'apartment':
                $model = $this->apartmentModel->find($request->modelId);
                break;
            case 'villa':
                $model = $this->villaModel->find($request->modelId);
                break;
            case 'land':
                $model = $this->landModel->find($request->modelId);
                break;
            case 'shop':
                $model = $this->shopModel->find($request->modelId);
                break;
            case 'hanger':
                $model = $this->hangarModel->find($request->modelId);
                break;
            default:
                return $this->apiResponse([], 'Invalid model type.', 400);
        }

        if (!$model) {
            return $this->apiResponse([], 'Model not found.', 404);
        }

        $favorite = $model->favorites()->where('user_id', Auth::id())->first();

        if (!$favorite) {
            $favorite = new Favorite();
            $favorite->user_id = Auth::id();
            $model->favorites()->save($favorite);
        }

        return $this->apiResponse(
            $favorite,
            ucfirst($request->type) . ' has been favorited.',
            200
        );
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function unFavorite($request)
    {
        $userId = Auth::id();



        switch ($request->type) {
            case 'apartment':
                $model = $this->apartmentModel->find($request->modelId);
                break;
            case 'villa':
                $model = $this->villaModel->find($request->modelId);
                break;
            case 'land':
                $model = $this->landModel->find($request->modelId);
                break;
            case 'shop':
                $model = $this->shopModel->find($request->modelId);
                break;
            case 'hanger':
                $model = $this->hangarModel->find($request->modelId);
                break;
            default:
                return $this->apiResponse([], 'Invalid model type.', 400);
        }

        if (!$model) {
            return $this->apiResponse([], 'Model not found.', 404);
        }


        $favorite = $model->favorites()->where('user_id', $userId)->first();

        if (!$favorite) {
            $this->apiResponse([],
                 ' has not been favorited.',
                400
            );
        }

        $favorite->delete();

        return $this->apiResponse([],
             ' has been unfavorited.',200
        );
    }

}

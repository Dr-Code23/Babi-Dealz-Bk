<?php

namespace Modules\Favorite\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Favorite\Services\FavoriteService;

class FavoriteController extends Controller
{
    private $favoriteService;

    public function __construct(FavoriteService $favorite)
    {
        $this->favoriteService = $favorite;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->favoriteService->index();
    }

    public function store(Request $request)
    {
        return $this->favoriteService->favorite($request);
    }

    /**
     * Show the specified resource.
     * @param int $id
     */
    public function show($id)
    {
        return$this->favoriteService->show($id);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     */
    public function unFavorite(Request $request)
    {
        return $this->favoriteService->unFavorite($request);
    }
}

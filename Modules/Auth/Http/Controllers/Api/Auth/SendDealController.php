<?php

namespace Modules\Auth\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\ApiResource\ApiResponse;
use Modules\Auth\Entities\SendDeal;
use Modules\Auth\Events\SendDeals;
use Modules\Auth\Http\Requests\SendDealRequest;
use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;

class SendDealController extends Controller
{
     use ApiResponse;
    private $sendDeal;

    public function __construct(SendDeal $SendDeal)
    {
        $this->sendDeal = $SendDeal;
    }

    public function index()
    {
        $deals = $this->sendDeal->latest()->get();

        return $this->apiResponse($deals,'all',200);
    }

    public function store(SendDealRequest $request)
    {
        $deal = $this->sendDeal->create([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'description' => $request->input('description'),
            'user_id' => Auth::id(),
        ]);
        event(new SendDeals($deal));

        return $this->apiResponse($deal,'send success', 201);
    }

    public function show($id)
    {
        $deal = $this->sendDeal->findOrFail($id);

        return $this->apiResponse($deal,'show',200);
    }


    public function destroy($id)
    {
        $deal = $this->sendDeal->findOrFail($id);
        $deal->delete();

        return $this->apiResponse([],'deleted success', 200);
    }
}

<?php

namespace Modules\Property\Services;

use Modules\ApiResource\ApiResponse;
use Modules\Property\Entities\Apartment;
use Modules\Property\Entities\Hangar;
use Modules\Property\Entities\Land;
use Modules\Property\Entities\Shop;
use Modules\Property\Entities\Villa;
use Modules\Property\Transformers\ApartmentResource;
use Modules\Property\Transformers\HangarResource;
use Modules\Property\Transformers\LandResource;
use Modules\Property\Transformers\ShopResource;
use Modules\Property\Transformers\VillaResource;

class PropertyAdminServices
{
    use ApiResponse;
    private Apartment $apartmentModel;
    private Shop $shopModel;
    private Villa $villaModel;
    private Land $landModel;
    private Hangar $hangarModel;
    public function __construct(Apartment $apartmentModel,Shop $shopModel,Villa $villaModel,Land $landModel,Hangar $hangarModel)
    {
        $this->apartmentModel = $apartmentModel;

        $this->shopModel = $shopModel;

        $this->villaModel = $villaModel;

        $this->landModel = $landModel;

        $this->hangarModel = $hangarModel;
    }

    public function getAllDataApartment()
    {

        $apartment = $this->apartmentModel->get();

        if (!$apartment) {
            return $this->apiResponse([], 'No apartments found.', 404);
        }

        return $this->apiResponse(ApartmentResource::collection($apartment), 'Successfully retrieved all apartments.', 200);
    }

    public function getAllDataShop()
    {

        $shop = $this->shopModel->get();

        if (!$shop) {
            return $this->apiResponse([], 'No shops found.', 404);
        }

        return $this->apiResponse(ShopResource::collection($shop), 'Successfully retrieved all shops.', 200);
    }
    public function getAllDataVilla()
    {

        $villa = $this->villaModel->get();

        if (!$villa) {
            return $this->apiResponse([], 'No villas found.', 404);
        }

        return $this->apiResponse(VillaResource::collection($villa), 'Successfully retrieved all villas.', 200);
    }

    public function getAllDataLand()
    {

        $land = $this->landModel->get();

        if (!$land) {
            return $this->apiResponse([], 'No lands found.', 404);
        }

        return $this->apiResponse(LandResource::collection($land), 'Successfully retrieved all lands.', 200);
    }
    public function getAllDataHangar()
    {

        $hangar = $this->hangarModel->get();

        if (!$hangar) {
            return $this->apiResponse([], 'No hangars found.', 404);
        }

        return $this->apiResponse(HangarResource::collection($hangar), 'Successfully retrieved all hangars.', 200);
    }

    public function getDataByIdHangar($id)
    {
        $hangar = Hangar::find($id);

        if (!$hangar) {
            return $this->apiResponse([], 'hangar not found.', 404);
        }

        return $this->apiResponse($hangar, 'Successfully retrieved hangar.', 200);
    }

    public function getDataByIdLand($id)
    {
        $land = Land::find($id);

        if (!$land) {
            return $this->apiResponse([], 'land not found.', 404);
        }

        return $this->apiResponse($land, 'Successfully retrieved land.', 200);
    }


    public function getDataByIdVilla($id)
    {
        $villa = villa::find($id);

        if (!$villa) {
            return $this->apiResponse([], 'villa not found.', 404);
        }

        return $this->apiResponse(new VillaResource($villa), 'Successfully retrieved villa.', 200);
    }

    public function getDataByIdApartment($id)
    {
        $apartment = Apartment::find($id);

        if (!$apartment) {
            return $this->apiResponse([], 'apartment not found.', 404);
        }

        return $this->apiResponse(new ApartmentResource($apartment), 'Successfully retrieved apartment.', 200);
    }

    public function getDataByIdShop($id)
    {
        $shop = Shop::find($id);

        if (!$shop) {
            return $this->apiResponse([], 'shop not found.', 404);
        }

        return $this->apiResponse($shop, 'Successfully retrieved shop.', 200);
    }


}
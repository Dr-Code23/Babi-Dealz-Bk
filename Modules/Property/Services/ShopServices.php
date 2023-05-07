<?php
namespace  Modules\Property\Services;

use Illuminate\Support\Facades\Auth;
use Modules\ApiResource\ApiResponse;
use Modules\Property\Entities\Shop;
use Modules\Property\Transformers\ShopResource;

class ShopServices{
    use ApiResponse;
    private Shop $shopModel;

    public function __construct(Shop $shopModel)
    {
        $this->shopModel = $shopModel;
    }

    public function storeData($data)
    {
        $shop = $this->shopModel->create([
            'user_id' => Auth::id(),
            'property_type_id' => $data->input('property_type_id'),
            'city_id' => $data->input('city_id'),
            'country_id' => $data->input('country_id'),
            'address' => $data->input('address'),
            'latitude' => $data->input('latitude'),
            'longitude' => $data->input('longitude'),
            'length' => $data->input('length'),
            'width' => $data->input('width'),
            'budget' => $data->input('budget'),
            'is_there_path_room' => $data->input('is_there_path_room'),
            'space_path_room' => $data->input('space_path_room'),
            'description' => $data->input('description')
        ]);

        if ($data->gallery) {
            foreach ($data->gallery as $gallery) {
                $shop->addMedia($gallery)->toMediaCollection('shops');
            }
        }

        $shop->features()->sync($data->feature_id);



        if (!$shop) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to store shop. Please try again later.',500) ;
        }
        $shop->with('media');
        return $this->apiResponse( new ShopResource($shop),' successful you insert shop.',200) ;
    }

    public function getAllData()
    {

        $shop = $this->shopModel->where("user_id",Auth::id())->get();

        if (!$shop) {
            return $this->apiResponse([], 'No shops found.', 404);
        }

        return $this->apiResponse(ShopResource::collection($shop), 'Successfully retrieved all shops.', 200);
    }

    public function getDataById($id)
    {
        $shop = Shop::where("user_id",Auth::id())->find($id);

        if (!$shop) {
            return $this->apiResponse([], 'shop not found.', 404);
        }

        return $this->apiResponse($shop, 'Successfully retrieved shop.', 200);
    }

    public function updateDataById($data,$id)
    {
        $shop = $this->shopModel->findOrFail($id);

        if (!$shop) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to update shop Please try again later.',500) ;
        }

        $shop->update($data->except('gallery'));

        if ($data->gallery) {
            foreach ($data->gallery as $gallery) {
                $shop->addMedia($gallery)->toMediaCollection('shops');
            }
        }

        $shop->features()->sync($data->feature_id);



        return $this->apiResponse(new ShopResource($shop),'shop updated successfully.',200) ;
    }



    public function deleteData($id)
    {
        $shop = $this->shopModel->find($id);


        if (!$shop) {
            return $this->apiResponse([], 'shop not found', 404);
        }

        $shop->delete();

        return $this->apiResponse([], 'shop deleted successfully', 200);
    }


}
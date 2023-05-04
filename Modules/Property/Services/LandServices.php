<?php

namespace  Modules\Property\Services;

use Illuminate\Support\Facades\Auth;
use Modules\ApiResource\ApiResponse;
use Modules\Property\Entities\Apartment;
//use Modules\Property\Entities\Land;
use Modules\Property\Entities\Land;
use Modules\Property\Http\Requests\LandRequest;
use Modules\Property\Transformers\LandResource;
//use Illuminate\Support\Facades\Auth;
//use Modules\ApiResource\ApiResponse;
//use Modules\Property\Entities\Hangar;
//use Modules\Property\Transformers\HangarResource;

class LandServices{

    use ApiResponse;
//    private Land $landModel;
//
//    public function __construct(Land $landModel)
//    {
//        $this->landModel = $landModel;
//    }

    private  $landModel;

    public function __construct(Land $landModel)
    {
        $this->landModel = $landModel;
    }

    public function storeData($data): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $land = $this->landModel->create([
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
            'description' => $data->input('description')
        ]);

        if ($data->gallery) {
            foreach ($data->gallery as $gallery) {
                $land->addMedia($gallery)->toMediaCollection('lands');
            }
        }

        $land->features()->sync($data->feature_id);



        if (!$land) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to store Land. Please try again later.',500) ;
        }
        $land->with('media');
        return $this->apiResponse( new LandResource($land),' successful you insert land.',200) ;
    }

    public function getAllData()
    {

        $land = $this->landModel->with('media')->get();

        if (!$land) {
            return $this->apiResponse([], 'No lands found.', 404);
        }

        return $this->apiResponse(LandResource::collection($land), 'Successfully retrieved all lands.', 200);
    }

    public function getDataById($id)
    {
        $land = Land::with(relations: 'media')->find($id);

        if (!$land) {
            return $this->apiResponse([], 'land not found.', 404);
        }

        return $this->apiResponse($land, 'Successfully retrieved land.', 200);
    }

    public function updateDataById($data,$id)
    {
        $land = $this->landModel->findOrFail($id);

        $updatedData = [
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
            'description' => $data->input('description')
        ];

        $land->update($updatedData);

        if ($data->gallery) {
            foreach ($data->gallery as $gallery) {
                $land->addMedia($gallery)->toMediaCollection('lands');
            }
        }

        $land->features()->sync($data->feature_id);

        if (!$land) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to update land Please try again later.',500) ;
        }

        $land->load('media');

        return $this->apiResponse(new LandResource($land),'Land updated successfully.',200) ;
    }



    public function deleteData($id)
    {
        $land = $this->landModel->find($id);


        if (!$land) {
            return $this->apiResponse([], 'land not found', 404);
        }

        $land->delete();

        return $this->apiResponse([], 'land deleted successfully', 200);
    }


}
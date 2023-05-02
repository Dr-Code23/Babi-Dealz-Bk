<?php

namespace Modules\Property\Services;
use Modules\ApiResource\ApiResponse;
use Modules\Property\Entities\Apartment;
use Modules\Property\Transformers\ApartmentResource;

class  ApartmentServices
{

    use ApiResponse;
    public function storeData(array $data):Apartment
    {
        $apartment = Apartment::create($data);

//        $apartment->roles()->sync($data['roles']);

        if (!$apartment) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to store Apartment. Please try again later.',500) ;
        }
        return $this->apiResponse(new ApartmentResource($apartment),' successful you insert Apertment.',200) ;
    }

//    public function getAllData():Apertment
//    {
//        $apertment = Apertment::all();
//
//        if (!$apertment) {
//            return $this->apiResponse([], 'No features found.', 404);
//        }
//
//        return $this->apiResponse(ApertmentResource::collection($apertment), 'Successfully retrieved all features.', 200);
//    }
//
//    public function getDataById($id):Apartment
//    {
//        $apertment = Apartment::find($id);
//
//        if (!$apertment) {
//            return $this->apiResponse([], 'Feature not found.', 404);
//        }
//
//        return $this->apiResponse(new ApertmentResource($apertment), 'Successfully retrieved feature.', 200);
//    }
//
//    public function updateData($id, $data):Apartment
//    {
//        $apertment = Apertment::find($id);
//
//        if (!$apertment) {
//            return $this->apiResponse([], 'Feature not found.', 404);
//        }
//
//        $updatedData = [
//
////            'title'=>$data->title
//        ];
//
//        $apertment->update($updatedData);
//
//        return $this->apiResponse(new ApartmentResource($apertment), 'Successfully updated feature.', 200);
//    }
//
//
//    public function deleteData($id):Apartment
//    {
//        $apertment = Apertment::find($id);
//
//        if (!$apertment) {
//            return $this->apiResponse([], 'Feature not found', 404);
//        }
//
//        $apertment->delete();
//
//        return $this->apiResponse([], 'Feature deleted successfully', 200);
//    }
//
//




}

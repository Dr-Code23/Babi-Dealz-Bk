<?php

namespace Modules\Property\Services;
use Modules\ApiResource\ApiResponse;
use Modules\Property\Entities\Apartment;
use Modules\Property\Transformers\ApartmentResource;

class  ApartmentServices
{

    use ApiResponse;
    private Apartment $apartmentModel;

    public function __construct(Apartment $apartmentModel)
    {
        $this->apartmentModel = $apartmentModel;
    }

    public function storeData(array $data)
    {
        $apartment = Apartment::create($data);

        if ($data->gallery) {
            foreach ($data->gallery as $gallery) {
                $apartment->addMedia($gallery)->toMediaCollection('apartments');
            }
        }


        if (!$apartment) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to store Apartment. Please try again later.',500) ;
        }
        $apartment->with('media');
        return $this->apiResponse($apartment,' successful you insert Apertment.',200) ;
    }

    public function getAllData()
    {
        $apartment = Apartment::with('media')->get();

        if (!$apartment) {
            return $this->apiResponse([], 'No features found.', 404);
        }

        return $this->apiResponse(ApertmentResource::collection($apartment), 'Successfully retrieved all features.', 200);
    }

    public function getDataById($id)
    {
        $apartment = $this->apartmentModel->find($id);

        if (!$apartment) {
            return $this->apiResponse([], 'Feature not found.', 404);
        }

        return $this->apiResponse($apartment, 'Successfully retrieved feature.', 200);
    }

//    public function updateData($id, $data):Apartment
//    {
//        $apartment = Apartment::find($id);
//
//        if (!$apartment) {
//            return $this->apiResponse([], 'Feature not found.', 404);
//        }
//
//        $updatedData = [
//
////            'title'=>$data->title
//        ];
//
//        $apartment->update($updatedData);
//
//        return $this->apiResponse($apartment, 'Successfully updated feature.', 200);
//    }

    public function deleteData($id)
    {
            $apartment = $this->apartmentModel->find($id);


        if (!$apartment) {
            return $this->apiResponse([], 'Feature not found', 404);
        }

        $apartment->delete();

        return $this->apiResponse([], 'Feature deleted successfully', 200);
    }




}

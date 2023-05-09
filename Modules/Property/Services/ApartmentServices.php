<?php

namespace Modules\Property\Services;
use Illuminate\Support\Facades\Auth;
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

    public function storeData($data): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $apartment = $this->apartmentModel->create([
            'user_id' => Auth::id(),
            'property_type_id' => $data->input('property_type_id'),
            'city_id' => $data->input('city_id'),
            'country_id' => $data->input('country_id'),
            'address' => $data->input('address'),
            'latitude' => $data->input('latitude'),
            'longitude' => $data->input('longitude'),
            'space' => (int)$data->input('space'),
            'budget' => $data->input('budget'),
            'number_of_rooms' => (int)$data->input('number_of_rooms'),
            'number_of_kitchen' => (int)$data->input('number_of_kitchen'),
            'number_of_bathroom' => (int)$data->input('number_of_bathroom'),
            'role_number' => (int)$data->input('role_number'),
            'description' => $data->input('description')
        ]);
        if ($data->gallery) {
            foreach ($data->gallery as $gallery) {
                $apartment->addMedia($gallery)->toMediaCollection('apartments');
            }
        }

        $apartment->features()->sync($data->feature_id);



        if (!$apartment) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to store Apartment. Please try again later.',500) ;
        }
        $apartment->with('media');
        return $this->apiResponse( new ApartmentResource($apartment),' successful you insert Apartment.',200) ;
    }

    public function getAllData()
    {

        $apartment = $this->apartmentModel->where("user_id",Auth::id())->get();

        if (!$apartment) {
            return $this->apiResponse([], 'No apartments found.', 404);
        }

        return $this->apiResponse(ApartmentResource::collection($apartment), 'Successfully retrieved all apartments.', 200);
    }

    public function getDataById($id)
    {
        $apartment = Apartment::where("user_id",Auth::id())->find($id);

        if (!$apartment) {
            return $this->apiResponse([], 'apartment not found.', 404);
        }

        return $this->apiResponse(new ApartmentResource($apartment), 'Successfully retrieved apartment.', 200);
    }

    public function updateDataById($data,$id)
    {
        $apartment = $this->apartmentModel->findOrFail($id);

        $apartment->update($data->except('gallery'));



        if ($data->gallery) {
            $apartment->media()->delete();

            foreach ($data->gallery as $gallery) {
                $apartment->addMedia($gallery)->toMediaCollection('apartments');
            }
        }

        $apartment->features()->sync($data->feature_id);

        if (!$apartment) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to update Apartment. Please try again later.',500) ;
        }

        $apartment->load('media');

        return $this->apiResponse(new ApartmentResource($apartment),'Apartment updated successfully.',200) ;
    }



    public function deleteData($id)
    {
            $apartment = $this->apartmentModel->find($id);


        if (!$apartment) {
            return $this->apiResponse([], 'apartment not found', 404);
        }

        $apartment->delete();

        return $this->apiResponse([], 'apartment deleted successfully', 200);
    }




}

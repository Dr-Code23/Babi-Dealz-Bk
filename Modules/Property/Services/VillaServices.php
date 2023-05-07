<?php

namespace Modules\Property\Services;

use Illuminate\Support\Facades\Auth;
use Modules\ApiResource\ApiResponse;
use Modules\Property\Entities\Villa;
use Modules\Property\Transformers\VillaResource;

class VillaServices
{
    use ApiResponse;
    private Villa $villaModel;

    public function __construct(Villa $villaModel)
    {
        $this->villaModel = $villaModel;
    }

    public function storeData($data): \Illuminate\Foundation\Application|\Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $villa = $this->villaModel->create([
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
            'role_villa' => (int)$data->input('role_villa'),
            'description' => $data->input('description'),
            'is_there_swimming_pool' => $data->input('is_there_swimming_pool')

        ]);
        if ($data->gallery) {
            foreach ($data->gallery as $gallery) {
                $villa->addMedia($gallery)->toMediaCollection('villas');
            }
        }

        $villa->features()->sync($data->feature_id);



        if (!$villa) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to store villa. Please try again later.',500) ;
        }
        $villa->with('media');
        return $this->apiResponse( new VillaResource($villa),' successful you insert villa.',200) ;
    }

    public function getAllData()
    {

        $villa = $this->villaModel->where("user_id",Auth::id())->get();

        if (!$villa) {
            return $this->apiResponse([], 'No villas found.', 404);
        }

        return $this->apiResponse(VillaResource::collection($villa), 'Successfully retrieved all villas.', 200);
    }

    public function getDataById($id)
    {
        $villa = villa::where("user_id",Auth::id())->find($id);

        if (!$villa) {
            return $this->apiResponse([], 'villa not found.', 404);
        }

        return $this->apiResponse(new VillaResource($villa), 'Successfully retrieved villa.', 200);
    }

    public function updateDataById($data,$id)
    {
        $villa = $this->villaModel->findOrFail($id);

        $villa->update($data->except('gallery'));



        if ($data->gallery) {
            $villa->media()->delete();

            foreach ($data->gallery as $gallery) {
                $villa->addMedia($gallery)->toMediaCollection('villas');
            }
        }

        $villa->features()->sync($data->feature_id);

        if (!$villa) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to update villa. Please try again later.',500) ;
        }

        $villa->load('media');

        return $this->apiResponse(new villaResource($villa),'villa updated successfully.',200) ;
    }



    public function deleteData($id)
    {
        $villa = $this->villaModel->find($id);


        if (!$villa) {
            return $this->apiResponse([], 'villa not found', 404);
        }

        $villa->delete();

        return $this->apiResponse([], 'villa deleted successfully', 200);
    }




}
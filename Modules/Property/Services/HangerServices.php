<?php
namespace Modules\Property\Services;

use Illuminate\Support\Facades\Auth;
use Modules\ApiResource\ApiResponse;
use Modules\Property\Entities\Hangar;
use Modules\Property\Transformers\HangarResource;


class HangerServices{
    use ApiResponse;
    private Hangar $hangarModel;

    public function __construct(Hangar $hangarModel)
    {
        $this->hangarModel = $hangarModel;
    }

    public function storeData($data)
    {
        $hangar = $this->hangarModel->create([
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
                $hangar->addMedia($gallery)->toMediaCollection('hangars');
            }
        }

        $hangar->features()->sync($data->feature_id);



        if (!$hangar) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to store Hangar. Please try again later.',500) ;
        }
        $hangar->with('media');
        return $this->apiResponse( new HangarResource($hangar),' successful you insert hanger.',200) ;
    }

    public function getAllData()
    {

        $hangar = $this->hangarModel->where("user_id",Auth::id())->get();

        if (!$hangar) {
            return $this->apiResponse([], 'No hangars found.', 404);
        }

        return $this->apiResponse(HangarResource::collection($hangar), 'Successfully retrieved all hangars.', 200);
    }

    public function getDataById($id)
    {
        $hangar = Hangar::where("user_id",Auth::id())->find($id);
//        $hangar =$this->hangarModel->find($id);

        if (!$hangar) {
            return $this->apiResponse([], 'hangar not found.', 404);
        }

        return $this->apiResponse($hangar, 'Successfully retrieved hangar.', 200);
    }

    public function updateDataById($data,$id)
    {
        $hangar = $this->hangarModel->findOrFail($id);

        if (!$hangar) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to update Hangar Please try again later.',500) ;
        }

        $hangar->update($data->except('gallery'));

        if ($data->gallery) {
            foreach ($data->gallery as $gallery) {
                $hangar->addMedia($gallery)->toMediaCollection('hangars');
            }
        }

        $hangar->features()->sync($data->feature_id);



        return $this->apiResponse(new HangarResource($hangar),'Hangar updated successfully.',200) ;
    }



    public function deleteData($id)
    {
        $hangar = $this->hangarModel->find($id);


        if (!$hangar) {
            return $this->apiResponse([], 'hangar not found', 404);
        }

        $hangar->delete();

        return $this->apiResponse([], 'hangar deleted successfully', 200);
    }


}

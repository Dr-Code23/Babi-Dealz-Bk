<?php
namespace Modules\Feature\Repositories\Repository;
use App\Models\User;
use Modules\ApiResource\ApiResponse;
use Modules\Feature\Entities\Feature;
use Modules\Feature\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Feature\Transformers\FeatureResource;

class UserRepository implements UserRepositoryInterface{

    use ApiResponse;
    private User $userModel;
    private Feature $FeatureModel;

    public function __construct(User $user, Feature $feature)
    {
        $this->userModel = $user;
        $this->FeatureModel = $feature;
    }

    public function storeData($data)
    {
        $feature = $this->FeatureModel->create([

        'title'=>$data->title
        ]);


        if (!$feature) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to store feature. Please try again later.',500) ;
        }
        return $this->apiResponse(new FeatureResource($feature),' successful you insert feature.',200) ;
    }


    public function getAllData()
    {
        $features = $this->FeatureModel->all();

        if (!$features) {
            return $this->apiResponse([], 'No features found.', 404);
        }

        return $this->apiResponse(FeatureResource::collection($features), 'Successfully retrieved all features.', 200);
    }

    public function getDataById($id)
    {
        $feature = $this->FeatureModel->find($id);

        if (!$feature) {
            return $this->apiResponse([], 'Feature not found.', 404);
        }

        return $this->apiResponse(new FeatureResource($feature), 'Successfully retrieved feature.', 200);
    }

    public function updateData($id, $data)
    {
        $feature = $this->FeatureModel->find($id);

        if (!$feature) {
            return $this->apiResponse([], 'Feature not found.', 404);
        }
//
//        $title = [
//            'en' => $data->title_en,
//            'nl' => $data->title_nl
//        ];

        $updatedData = [
//            'title' => [
//                'en' => $data->title_en,
//                'ar' => $data->title_ar,
//                'fr' => $data->title_fr
//            ]
        'title'=>$data->title
        ];

        $feature->update($updatedData);

        return $this->apiResponse(new FeatureResource($feature), 'Successfully updated feature.', 200);
    }


    public function deleteData($id)
    {
        $feature = $this->FeatureModel->find($id);

        if (!$feature) {
            return $this->apiResponse([], 'Feature not found', 404);
        }

        $feature->delete();

        return $this->apiResponse([], 'Feature deleted successfully', 200);
    }


}

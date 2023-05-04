<?php

namespace Modules\Auth\Repositories\Repository;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\ApiResource\ApiResponse;
use Modules\Auth\Entities\Notification;
use Modules\Auth\Repositories\Interfaces\AdminRepositoryInterface;
use Modules\Auth\Traits\pushNotificationTraite;
use Modules\Auth\Traits\VerificationCode;
use Modules\Auth\Transformers\UserResource;

class AdminRepository implements AdminRepositoryInterface
{
    use pushNotificationTraite;
    use VerificationCode,ApiResponse;

    private $userModel;
    private $notificationModel;

    public function __construct(User $user, Notification $notification)
    {
        $this->userModel = $user;
        $this->notificationModel = $notification;
    }

    public function register($data)
    {
        $user = $this->userModel->create([
            'name' => $data->name,
            'address' => $data->address,
            'phone' => $data->phone,
            'password' => hash::make($data->password),
            'type' => 'admin',
        ]);

        // $user->syncRoles(['admin']);

//        Auth::login($user);

        return $this->apiResponse(new UserResource($user),'Registration successful. Please check your phone for verification instructions.',200) ;


    }

    public function Login($data)
    {
        try {
            $user = User::where('phone', $data->input('phone'))->first();
           if($user->type  == 'admin' )
           {
            if (!$user || !Hash::check($data->input('password'), $user->password)) {
                // User does not exist or the password is incorrect
                return $this->apiResponse([], 'Invalid login credentials.', 400);
            }
            $token = $user->createToken('api_token')->plainTextToken;

            return $this->apiResponse(['data'=>new UserResource($user),'token'=>$token ],'admin successfully logged in',200);

        }else
           {
               return $this->apiResponse([], 'Unauthorized access.', 401);

           }
        }
         catch (\Exception $e) {
       // An error occurred while creating the token
          return $this->apiResponse([], 'Could not create token.', 500);
}
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */

    public function profile()
    {

        $user = auth()->user();
        return $this->apiResponse(new UserResource($user),' profile ',200);

    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function updateProfile($data)
    {

        $id = auth()->id();
        $user = $this->userModel->find($id);
        $user->update($data->all());
        if ($data->hasFile('photo')) {
            $user->media()->delete();
            $user->addMediaFromRequest('photo')->toMediaCollection('avatar');
        }
        return $this->apiResponse(new UserResource($user),' updated successfully ',200);

    }



    public function pushNotification($data)
    {
        return $this->Notification($data);
    }




}

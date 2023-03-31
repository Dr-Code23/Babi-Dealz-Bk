<?php

namespace Modules\Auth\Repositories\Repository;

use App\Models\User;
use Cassandra\Exception\ValidationException;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\Auth\Emails\EventMail;
use Modules\Auth\Entities\Notification;
use Modules\Auth\Entities\SendNotification;
use Modules\Auth\Entities\TermsAndConditions;
use Modules\Auth\Events\NewUser;
use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Auth\Transformers\AgencyResource;
use Modules\Auth\Transformers\dealsResource;
use Modules\Auth\Transformers\UserResource;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserRepository implements UserRepositoryInterface
{
    private $userModel;
    private $notificationModel;

    public function __construct(User $user, SendNotification $notification)
    {
        $this->userModel = $user;
        $this->notificationModel = $notification;
    }

    public function register($data)
    {
        $user = $this->userModel->create([
            'name' => $data->name,
            'address' => $data->address,
            'latitude' => $data->latitude,
            'longitude' => $data->latitude,
            'phone' => $data->phone,
            'password' => hash::make($data->password),
            'type' => 'customer',

        ]);
//        $user->assignRole('customer');
//        Auth::login($user);

        return ['statusCode' => 200, 'status' => true,
            'message' => 'customer successfully registered ',
            'data' => new UserResource($user)
        ];

    }
    /**
     * @param $data
     * @return array
     */
    public function dealsRegister($data)
    {
        $user = $this->userModel->create([
            'name' => $data->name,
            'address' => $data->address,
            'phone' => $data->phone,
            'password' => hash::make($data->password),
            'type' => 'deals',

        ]);

        return ['statusCode' => 200, 'status' => true,
            'message' => 'successfully registered',
            'data' => new DealsResource($user)
        ];
    }
    public function agencyRegister($data)
    {
        $user = $this->userModel->create([
            'name' => $data->name,
            'address' => $data->address,
            'agency_owner'=> $data->agency_owner,
            'phone' => $data->phone,
            'password' => hash::make($data->password),
            'type' => 'agency',

        ]);

        if ($data->hasFile('photo')) {
            $user->media()->delete();
            $user->addMediaFromRequest('photo')->toMediaCollection('avatar');
        }

        return ['statusCode' => 200, 'status' => true,
            'message' => 'successfully registered',
            'data' => new AgencyResource($user)
        ];
    }
    /**
     * @param $data
     * @return array|JsonResponse
     */
    public function Login($data)
    {


        try {

        $user = User::Where('phone', $data->input('phone'))->first();

        // Check if the user exists and the password is correct
        if ($user || !Hash::check($data->input('password'), $user->password)) {
                if ($user->type == 'deals') {
                    $token = $user->createToken('api_token')->plainTextToken;

                    return response()->json([
                        'success' => true,
                        'message' => 'deals successfully logged in.',
                        'data' => new DealsResource($user),
                        'token' => $token
                    ]);
                } elseif ($user->type == 'customer')

                {
                    $user->update(['device_token' => $data->device_token]);
                    $token = $user->createToken('api_token')->plainTextToken;

                    return response()->json([
                        'success' => true,
                        'message' => 'customer successfully logged in.',
                        'data' => new UserResource($user),
                        'token' => $token
                    ]);
                }elseif ($user->type == 'agency')

                {
                    $token = $user->createToken('api_token')->plainTextToken;

                    return response()->json([
                        'success' => true,
                        'message' => 'agency successfully logged in.',
                        'data' => new UserResource($user),
                        'token' => $token
                    ]);
                }
                 else{
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized access.'
                ], 401);
                     }

        }  else {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }


    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function forgotPassword($data)
    {
        $user = $this->userModel->where('email', $data->email)->first();
        if ($user) {
            // 1 generate verification code
            $user->reset_verification_code = rand(100000, 999999);
            $user->save();
            // 2 send email
            Mail::to($user->email)->send(new EventMail($user));
            return response()->json(['status' => true, 'message' => 'check your inbox']);

        } else {
            return response()->json(['status' => false, 'message' => 'email not found, try again'], 400);
        }
    }

    public function checkCode($data)
    {
        $user = $this->userModel->where('email', $data->email)->first();
        if ($user) {
            if ($user->reset_verification_code == $data->code) {
                return response()->json(['status' => true, 'message' => 'you will be redirected to set new password']);
            }
            return response()->json(['status' => false, 'message' => 'code is invalid, try again'], 400);

        } else {
            return response()->json(['status' => false, 'message' => 'email not found, try again'], 400);
        }
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function reset($data)
    {
        $user = $this->userModel->where('phone', $data->phone)->first();
        if ($user) {
            $user->password = Hash::make($data->password);
            $user->save();
            return response()->json([$user->password, 'status' => true, 'message' => 'password has been updated']);

        } else {
            return response()->json(['status' => false, 'message' => 'phone not found, try again'], 400);
        }
    }

    /**
     * @return array
     */
    public function profile()
    {
        $id = Auth::id();
        $user = $this->userModel->find($id);
        $termsAndConditions = TermsAndConditions::all();
        if($user->type == 'customer'){
        return [
            'statusCode' => 200,
            'status' => true,
            'data' => new UserResource($user),
            'termsAndConditions' => isset($termsAndConditions) ? $termsAndConditions : [],
        ];
    }elseif ($user->type == 'deals')
        {
            return [
                'statusCode' => 200,
                'status' => true,
                'data' => new DealsResource($user),
                'termsAndConditions' => isset($termsAndConditions) ? $termsAndConditions : [],];
        }else{
            return [
                'statusCode' => 200,
                'status' => true,
                'data' => new AgencyResource($user),
                'termsAndConditions' => isset($termsAndConditions) ? $termsAndConditions : [],];
        }
    }

    /**
     * @param $data
     * @return array
     */
    public function updateProfile($data)
    {
        $id = Auth::id();
        $user = $this->userModel->find($id);
        $user->update($data->all());
        if ($data->hasFile('photo')) {
            $user->media()->delete();
            $user->addMediaFromRequest('photo')->toMediaCollection('avatar');
        }
        if($user->type == 'customer'){
            return [
                'statusCode' => 200,
                'status' => true,
                'message' => 'customer updated successfully ',
                'data' => new UserResource($user),
            ];
        }elseif ($user->type == 'deals')
        {
            return [
                'statusCode' => 200,
                'status' => true,
                'message' => 'deals updated successfully ',
                'data' => new DealsResource($user),];
        }else{
            return [
                'statusCode' => 200,
                'status' => true,
                'message' => 'agency updated successfully ',
                'data' => new AgencyResource($user),];
        }
    }

    /**
     * @param $data
     * @return JsonResponse
     */
    public function changePassword($data)
    {
        $auth = Auth::user();

        // The passwords matches
        if (!Hash::check($data->get('current_password'), $auth->password)) {
            return response()->json(['error', "Current Password is Invalid"]);
        }

        $user = $this->userModel->find($auth->id);
        $user->password = Hash::make($data->new_password);
        $user->save();
        return response()->json(['success', "Password Changed Successfully"]);
    }

    /**
     * @return JsonResponse
     */
    public function deleteAccount()
    {

        $userID = Auth::id();
        try {
            $user = $this->userModel->find($userID);
            $user->delete();
            return response()->json(["messages" => "deleted successfully", "status" => 200]);
        } catch (Exception $ex) {
            return response()->json(["messages" => $ex->getError()->message, "status" => 500]);
        }

    }

    /**
     * @return array
     */
    public function notification()
    {
        $notification = $this->notificationModel
            ->query()
            ->where('user_id', Auth::id())
            ->markAsRead()
            ->get();
        return ['statusCode' => 200, 'status' => true,
            'data' => $notification
        ];

    }

    /**
     * @return array
     */

    public function unreadNotification()
    {
        $notification = $this->notificationModel
            ->query()
            ->where(['user_id' => Auth::id(), 'is_read' => false])
            ->get();
        return ['statusCode' => 200, 'status' => true,
            'data' => $notification
        ];

    }

    /**
     * @param $id
     * @return array
     */
    public function deleteNotification($id)
    {
        $this->notificationModel->where('id', $id);

        return ['statusCode' => 200, 'status' => true,
            'message' => 'delete'
        ];

    }



}

<?php

namespace Modules\Auth\Repositories\Repository;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Modules\ApiResource\ApiResponse;
use Modules\Auth\Emails\EventMail;
use Modules\Auth\Entities\SendNotification;
use Modules\Auth\Entities\TermsAndConditions;
use Modules\Auth\Repositories\Interfaces\UserRepositoryInterface;
use Modules\Auth\Traits\VerificationCode;
use Modules\Auth\Transformers\AgencyResource;
use Modules\Auth\Transformers\dealsResource;
use Modules\Auth\Transformers\UserResource;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserRepository implements UserRepositoryInterface
{
    use VerificationCode,ApiResponse;
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
            'isVerified' => false,

        ]);

     $response = $this->sendVerificationCode($user);
        if (!$response) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to send verification SMS. Please try again later.',500) ;
        }
        return $this->apiResponse(new UserResource($user),'Registration successful. Please check your phone for verification instructions.',200) ;





    }
    /**
     * @param $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function dealsRegister($data)
    {
        $user = $this->userModel->create([
            'name' => $data->name,
            'address' => $data->address,
            'phone' => $data->phone,
            'password' => hash::make($data->password),
            'type' => 'deals',
            'latitude' => $data->latitude,
            'longitude' => $data->latitude,
            'isVerified' => false,

        ]);
        $response = $this->sendVerificationCode($user);
        if (!$response) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to send verification SMS. Please try again later.',500) ;
        }
        return $this->apiResponse(new DealsResource($user),' Deals Registration successful. Please check your phone for verification instructions.',200) ;

    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function agencyRegister($data)
    {
        try {

            DB::beginTransaction();
        $user = $this->userModel->create([
            'name' => $data->name,
            'address' => $data->address,
            'agency_owner'=> $data->agency_owner,
            'phone' => $data->phone,
            'password' => hash::make($data->password),
            'type' => 'agency',
            'latitude' => $data->latitude,
            'longitude' => $data->latitude,
            'isVerified' => false,

        ]);

        if ($data->hasFile('photo')) {
            $user->addMediaFromRequest('photo')->toMediaCollection('avatar');
        }
        $response = $this->sendVerificationCode($user);
            DB::commit();
        if (!$response) {
            // Handle any errors that occur while sending SMS
            return $this->apiResponse([],'Failed to send verification SMS. Please try again later.',500) ;
        }
        return $this->apiResponse(new AgencyResource($user),' Agency Registration successful. Please check your phone for verification instructions.',200) ;

        }catch (\Exception){
            DB::rollBack();
            return $this->apiResponse([],'Failed ' ,400,);


        }
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function verify($data)
    {

        $verification=$this->verifyCode($data);

        if ($verification) {
            $user = tap($this->userModel->where('phone', $data['phone']))->update(['isVerified' => true]);
            // verification successful
            return $this->apiResponse([],'Phone number verified successfully', 200);
        } else {
            // verification failed
            return $this->apiResponse([],'Invalid verification code', 400);

        }

    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function sendVerify($data)
    {
        $user = $this->userModel->where('phone', $data->phone)->first();

        $response = $this->sendVerificationCode($user);
        if (!$response) {
            return $this->apiResponse([],'Failed to send verification SMS. Please try again later', 500);

            // Handle any errors that occur while sending SMS
        }
        return $this->apiResponse([],'send verification code successful', 200);

    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function login($data)
    {
        try {
            $user = User::where('phone', $data->input('phone'))->first();

            if (!$user || !Hash::check($data->input('password'), $user->password)) {
                // User does not exist or the password is incorrect
                return $this->apiResponse([], 'Invalid login credentials.', 400);
            }

            if (!$user->isVerified) {
                // User has not completed the verification process
                return $this->apiResponse([], 'You must complete the verification process before logging in.', 400);
            }

            $user->update(['device_token' => $data->device_token]);

            $token = $user->createToken('api_token')->plainTextToken;

            switch ($user->type) {
                case 'deals':
                    $message = 'Deals successfully logged in.';
                    $data = new DealsResource($user);
                    break;
                case 'customer':
                    $message = $user->type . ' successfully logged in.';
                    $data = new UserResource($user);
                    break;
                case 'agency':
                    $message = $user->type . ' successfully logged in.';
                    $data = new AgencyResource($user);
                    break;
                default:
                    // User type is not recognized
                    return $this->apiResponse([], 'Unauthorized access.', 401);
            }

            return $this->apiResponse($data,$message,200);

        } catch (Exception $e) {
            // An error occurred while creating the token
            return $this->apiResponse([], 'Could not create token.', 500);
        }
    }    /**
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
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
     */
    public function profile()
    {
        $id = Auth::id();
        $user = $this->userModel->find($id);
        $termsAndConditions = TermsAndConditions::all();
        switch ($user->type) {
            case 'customer':
                $data = new UserResource($user);
                break;
            case 'deals':
                $data = new DealsResource($user);
                break;
            default:
                $data = new AgencyResource($user);
                break;
        }

        return $this->apiResponse([$data,$termsAndConditions ?: []],'profile',200);
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Foundation\Application|\Illuminate\Http\Response
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
        switch ($user->type) {
            case 'customer':
                $data = new UserResource($user);
                break;
            case 'deals':
                $data = new DealsResource($user);
                break;
            default:
                $data = new AgencyResource($user);
                break;
        }

        return $this->apiResponse($data,$data->type.' updated successfully ',200);



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

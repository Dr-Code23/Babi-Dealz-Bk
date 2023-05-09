<?php

namespace Modules\Auth\Traits;

use Modules\Auth\Transformers\UserResource;
use Twilio\Rest\Client;
use App\Models\User;

trait VerificationCode
{

    private $userModel;

    public function __construct(User $user)
    {
        $this->userModel = $user;
    }

    public function sendVerificationCode($data)
    {

        $twilio_sid = env("TWILIO_ACCOUNT_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $twilio_verify_sid = env("TWILIO_VERIFY_SID");

        $twilio = new Client($twilio_sid, $token);
        $verification = $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create("+".$data['phone'], "sms");



        return $verification;

    }

    public function VerifyCode($data)
    {

        try{
            $twilio_sid = env("TWILIO_ACCOUNT_SID");
            $token = env("TWILIO_AUTH_TOKEN");
            $twilio_verify_sid = env("TWILIO_VERIFY_SID");

            $twilio = new Client($twilio_sid, $token);

            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                ->verificationChecks
                ->create(["to" => "+".$data['phone'], "code" => $data->verification_code]);

            if ($verification->valid) {
                $user = tap($this->userModel->where('phone', $data['phone']))->update(['isVerified' => true]);
                return $this->apiResponse([], 'Phone number verified successfully', 200);
            } else {
                error_log(print_r($verification, true));
                return $this->apiResponse([], 'Invalid verification code entered!.', 500);
            }
        }catch(\Exception $e){


            return $this->apiResponse([],'Failed to send verification SMS. Please try again later', 500);


        }

    }








}

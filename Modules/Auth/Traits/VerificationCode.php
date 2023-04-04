<?php

namespace Modules\Auth\Traits;

use Modules\Auth\Transformers\UserResource;
use Twilio\Rest\Client;

trait VerificationCode
{



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

        $twilio_sid = env("TWILIO_ACCOUNT_SID");
        $token = env("TWILIO_AUTH_TOKEN");
        $twilio_verify_sid = env("TWILIO_VERIFY_SID");

        $twilio = new Client($twilio_sid, $token);

            $verification = $twilio->verify->v2->services($twilio_verify_sid)
                ->verificationChecks
                ->create(["to" => "+".$data['phone'], "code" => $data->verification_code]);

            return $verification;


    }
}

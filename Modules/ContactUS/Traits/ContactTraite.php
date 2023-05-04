<?php

namespace Modules\ContactUS\Traits;


use App\Models\User;
use Modules\Auth\Entities\SendNotification;


trait contactTraite
{

    public function contactUs($request)
    {
        $message = $this->contactUsModel->create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'mail' => $request['mail'],
            'subject' => $request['subject'],
            'message' => $request['message'],
            'type' => $request['type'],
        ]);

        return $message;

    }

}


<?php

namespace Modules\ContactUS\Services;

use Illuminate\Http\Request;
use Modules\ApiResource\ApiResponse;
use Modules\ContactUS\Entities\ContactUs;
use Modules\ContactUS\Events\Contact_us;
use Modules\ContactUS\Traits\contactTraite;
use Modules\ContactUS\Transformers\ContactResource;

class AgencyContactUsService
{
    use ApiResponse, contactTraite;
    /**
     * @var ContactUs
     */
    protected ContactUs $contactUsModel;

    /**
     * @param ContactUs $contactUs
     */

    public function __construct(ContactUs $contactUs)
    {
        $this->contactUsModel = $contactUs;
    }


    public function agency($request)
    {
        $request['type']='agency';

        $message = $this->contactUs($request);

        event(new Contact_us($message));

        return $this->apiResponse(new ContactResource($message), 'send success',201);


    }
    public function allMessage()
    {
        $messages = $this->contactUsModel->where('type', 'agency')->get();

        return $this->apiResponse(ContactResource::collection($messages), 'send success',201);


    }
}

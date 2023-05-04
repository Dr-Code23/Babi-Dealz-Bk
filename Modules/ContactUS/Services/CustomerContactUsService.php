<?php

namespace Modules\ContactUS\Services;

use Modules\ApiResource\ApiResponse;
use Modules\ContactUS\Entities\ContactUs;
use Modules\ContactUS\Events\Contact_us;
use Modules\ContactUS\Traits\contactTraite;
use Modules\ContactUS\Transformers\ContactResource;

class CustomerContactUsService
{
    use ApiResponse,contactTraite;
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

    public function customer($request)
    {
        $request['type']='customer';

        $message = $this->contactUs($request);

        event(new Contact_us($message));

        return $this->apiResponse(new ContactResource($message), 'send success',200);


    }
    public function allMessage()
    {
        $messages = $this->contactUsModel->where('type', 'customer')->get();

        return $this->apiResponse(ContactResource::collection($messages), 'all customer message',200);


    }
}

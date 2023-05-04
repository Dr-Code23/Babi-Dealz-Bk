<?php

namespace Modules\ContactUS\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Auth\Events\Contact_us;
use Modules\ContactUS\Entities\ContactUs;
use Modules\ContactUS\Services\AgencyContactUsService;
use Modules\ContactUS\Services\CustomerContactUsService;
use Modules\ContactUS\Services\DealsContactUsService;

class ContactUsController extends Controller
{
    private $agencyContactUsService;
    private $dealsContactUsService;
    private $customerContactUsService;
    private ContactUs $contactUsModel;

    public function __construct(ContactUs $contactUs,AgencyContactUsService $agencyService, DealsContactUsService $dealsService, CustomerContactUsService $customerService)
    {
        $this->contactUsModel = $contactUs;
        $this->agencyContactUsService = $agencyService;
        $this->dealsContactUsService = $dealsService;
        $this->customerContactUsService = $customerService;
    }

    /**
     * @var ContactUs
     */

    public function contactAgency(Request $request)
    {

        return $this->agencyContactUsService->agency($request->all());

    }

    // API endpoint for contacting deals team
    public function contactDeals(Request $request)
    {

       return $this->dealsContactUsService->deals($request->all());

    }

    // API endpoint for contacting customer support
    public function contactCustomerSupport(Request $request)
    {

        return $this->customerContactUsService->customer($request->all());

    }
    public function allMessageAgency()
    {

        return $this->agencyContactUsService->allMessage();

    }

    // API endpoint for contacting deals team
    public function allMessageDeals()
    {

        return $this->dealsContactUsService->allMessage();

    }

    // API endpoint for contacting customer support
    public function allMessageCustomer()
    {

      return  $this->customerContactUsService->allMessage();

    }
    /**
     * @param $id
     * @return JsonResponse
     */

    public function show($id)
    {
        $message = $this->contactUsModel->findOrFail($id);

        return response()->json($message);
    }

    /**
     * @param $id
     * @return JsonResponse
     */


    public function destroy($id)
    {
        $message = $this->contactUsModel->findOrFail($id);
        $message->delete();

        return response()->json(null, 204);
    }
}

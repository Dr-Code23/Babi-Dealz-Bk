<?php

namespace Modules\FrontEnd\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Request;
use Modules\Auth\Http\Requests\CreateTermsAndConditionsRequest;
use Modules\Auth\Http\Requests\updateTermsAndConditionsRequest;
use Modules\FrontEnd\Entities\PolicyAndPrivacy;
use Modules\FrontEnd\Entities\TermsAndConditions;

class PolicyAndPrivacyController extends Controller
{

    private PolicyAndPrivacy $policyAndPrivacyModel;

    public function __construct(PolicyAndPrivacy $policyAndPrivacy)
    {
        $this->policyAndPrivacyModel = $policyAndPrivacy;
    }

    public function index()
    {
        $policyAndPrivacy = $this->policyAndPrivacyModel->all();
        return response()->json(['success' => true, $policyAndPrivacy]);
    }

    public function store(Request $request)
    {
        $policyAndPrivacy = new PolicyAndPrivacy([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);

        $policyAndPrivacy->save();

        return response()->json(['success' => true, 'message' => 'Terms and conditions created successfully']);
    }

    public function show($id)
    {
        $policyAndPrivacy = $this->policyAndPrivacyModel->find($id);
        return response()->json(['success' => true, $policyAndPrivacy]);
    }

    public function update(Request $request, $id)
    {
        $policyAndPrivacy = $this->policyAndPrivacyModel->find($id);

        $policyAndPrivacy->title = $request->input('title');
        $policyAndPrivacy->content = $request->input('content');

        $policyAndPrivacy->save();

        return response()->json(['success' => true, 'message' => 'Terms and conditions updated successfully']);
    }

    public function destroy($id)
    {
        $policyAndPrivacy = $this->policyAndPrivacyModel->find($id);
        $policyAndPrivacy->delete();

        return response()->json(['success' => true, 'message' => 'Terms and conditions deleted successfully']);
    }
}

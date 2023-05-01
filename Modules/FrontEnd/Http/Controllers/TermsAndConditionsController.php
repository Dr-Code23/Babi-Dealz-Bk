<?php

namespace Modules\FrontEnd\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\CreateTermsAndConditionsRequest;
use Modules\Auth\Http\Requests\updateTermsAndConditionsRequest;
use Modules\FrontEnd\Entities\TermsAndConditions;

class TermsAndConditionsController extends Controller
{

    protected $termsAndConditionsModel;

    public function __construct(TermsAndConditions $termsAndConditions)
    {
        $this->termsAndConditionsModel = $termsAndConditions;
    }

    public function index()
    {
        $termsAndConditions = $this->termsAndConditionsModel->all();
        return response()->json(['success' => true, $termsAndConditions]);
    }

    public function store(CreateTermsAndConditionsRequest $request)
    {
        $termsAndConditions = new TermsAndConditions([
            'title' => $request->input('title'),
            'content' => $request->input('content')
        ]);

        $termsAndConditions->save();

        return response()->json(['success' => true, 'message' => 'Terms and conditions created successfully']);
    }

    public function show($id)
    {
        $termsAndConditions = $this->termsAndConditionsModel->find($id);
        return response()->json(['success' => true, $termsAndConditions]);
    }

    public function update(updateTermsAndConditionsRequest $request, $id)
    {
        $termsAndConditions = $this->termsAndConditionsModel->find($id);

        $termsAndConditions->title = $request->input('title');
        $termsAndConditions->content = $request->input('content');

        $termsAndConditions->save();

        return response()->json(['success' => true, 'message' => 'Terms and conditions updated successfully']);
    }

    public function destroy($id)
    {
        $termsAndConditions = $this->termsAndConditionsModel->find($id);
        $termsAndConditions->delete();

        return response()->json(['success' => true, 'message' => 'Terms and conditions deleted successfully']);
    }
}

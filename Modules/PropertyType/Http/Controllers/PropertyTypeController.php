<?php

namespace Modules\PropertyType\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\ApiResource\ApiResponse;
use Modules\PropertyType\Entities\PropertyType;

class PropertyTypeController extends Controller
{
    use ApiResponse;
    private PropertyType $propertyType;

    public function __construct(PropertyType $propertyType)
    {
        $this->propertyType = $propertyType;
    }

    public function index()
    {
        $propertyTypes = $this->propertyType->get();

        return $this->apiResponse($propertyTypes);
    }
}

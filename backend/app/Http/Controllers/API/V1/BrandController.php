<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\JsonResponse;

class BrandController extends Controller
{
    public function index(): JsonResponse
    {
        $brands = Brand::select('id', 'name', 'slug')->get();

        return $this->success($brands, 'Brands retrieved successfully.');
    }
}

<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $brands = Category::select('id', 'name', 'image')->get();

        return $this->success($brands, 'Categories retrieved successfully.');
    }
}

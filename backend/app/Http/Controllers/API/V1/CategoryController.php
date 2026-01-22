<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::select('id', 'name', 'slug', 'image')
        ->with(['brands:id,name,slug'])
        ->get();

    return $this->success($categories, 'Categories with brands loaded');
    }

    public function show(string $slug): JsonResponse
    {
        $category = Category::where('slug', $slug)->first();

        if (! $category) {
            return $this->error('Category not found.', 404);
        }

        return $this->success($category, 'Category retrieved successfully.');
    }
}

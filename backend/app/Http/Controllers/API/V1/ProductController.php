<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\ProductHelper;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSlider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::with('brand', 'category', 'sliders', 'details', 'variations')->productFilter($request)->paginate(20);

        $products->getCollection()->transform(function ($product) {
            return ProductHelper::format($product);
        });

        return $this->success($products, 'Products retrieved successfully.');
    }

    public function featuredProducts(): JsonResponse
    {
        $products = Product::with('brand', 'category', 'sliders', 'details')
            ->where('remarks', 'featured')
            ->get();

        $products = $products->map(fn ($p) => ProductHelper::format($p));

        return $this->success($products, 'All featured products.');
    }

    public function show(string $slug): JsonResponse
    {
        $product = Product::with([
            'brand', 'category', 'sliders', 'details', 'variations',
        ])->where('slug', $slug)->first();

        if (! $product) {
            return $this->error('Product not found.', 404);
        }

        $formatted = ProductHelper::format($product);

        return $this->success($formatted, 'Product retrieved successfully.');
    }

    public function productSliders(): JsonResponse
    {
        $sliders = ProductSlider::with('product')->get();

        return $this->success($sliders, 'Product sliders retrieved successfully.');
    }
}

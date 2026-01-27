<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\ProductHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductSlider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $products = Product::with('brand', 'category', 'sliders', 'details', 'variations', 'reviews')->productFilter($request)->paginate(20);

        $products->getCollection()->transform(function ($product) {
            return ProductHelper::format($product);
        });

        return $this->success($products, 'Products retrieved successfully.');
    }

    public function featuredProducts(): JsonResponse
    {
        try {
            $products = Product::with('brand', 'category', 'sliders', 'details', 'variations', 'reviews')
            ->where('remarks', 'featured')
            ->get();

        $products = $products->map(fn ($p) => ProductHelper::format($p));

        return $this->success($products, 'All featured products.');
        } catch (\Exception $e) {
            Log::error('Error fetching featured products: ' . $e->getMessage());
            return $this->error('Failed to retrieve featured products.', 500);
        }
    }

    public function relatedProducts($id)
    {
        $product = Product::findOrFail($id);

        $products = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->select('id', 'title', 'slug', 'price', 'image', 'star')
            ->get()
            ->map(function ($p) {
                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'slug' => $p->slug,
                    'price' => $p->price,
                    'image' => $p->image,
                    'star' => (float) ($p->star ?? 0),
                    'review_count' => $p->reviews->count(),
                ];
            });

        return $this->success($products, 'Related products');
    }

    public function show(string $slug): JsonResponse
    {
        $product = Product::with([
            'brand', 'category', 'sliders', 'details', 'variations', 'reviews'
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
    public function search(Request $request): JsonResponse
    {
        $q = trim($request->get('q'));

        if (! $q) {
            return $this->success([
                'items' => [],
                'total' => 0,
            ], 'Empty search query.');
        }

        $query = Product::query()
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%");
            });

        $total = $query->count();

        $products = $query
            ->with(['brand', 'category'])
            ->limit(10)
            ->get()
            ->map(fn ($p) => ProductHelper::format($p));

        return $this->success([
            'items' => $products,
            'total' => $total,
        ], 'Search results.');
    }
    public function searchPaginate(Request $request): JsonResponse
    {
        $q = trim($request->get('q'));

        if (! $q) {
            $products = Product::with(['brand', 'category', 'sliders'])
                ->paginate(20);

            $products->getCollection()->transform(
                fn ($p) => ProductHelper::format($p)
            );

            return $this->success($products, 'All products');
        }

        $products = Product::with(['brand', 'category', 'sliders'])
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%");
            })
            ->paginate(20);

        $products->getCollection()->transform(
            fn ($p) => ProductHelper::format($p)
        );

        return $this->success($products, 'Search products.');
    }

    public function productsByCategory($slug)
    {
        $products = Product::whereHas('category', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })
        ->with(['brand', 'category', 'sliders', 'details', 'variations', 'reviews'])
        ->paginate(9);

        return $this->success($products, 'Products retrieved successfully.');
    }

    public function productsByBrand($slug)
    {
        $products = Product::whereHas('brand', function ($q) use ($slug) {
            $q->where('slug', $slug);
        })
        ->with(['brand', 'category', 'sliders', 'details', 'variations', 'reviews'])
        ->paginate(9);

        return $this->success($products, 'Products retrieved successfully.');
    }
}

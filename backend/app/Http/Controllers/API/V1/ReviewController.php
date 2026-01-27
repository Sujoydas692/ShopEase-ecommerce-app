<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required',
        ]);

        $product = Product::findOrFail($productId);

        Review::create([
            'product_id' => $product->id,
            'name' => $request->name,
            'email' => $request->email,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        $avgRating = $product->reviews()->avg('rating');

        $product->update([
            'star' => round($avgRating, 1),
        ]);
        return $this->success($product->star, 'Review added successfully');
    }

    public function index($productId)
    {
        $review = Review::where('product_id', $productId)
            ->latest()
            ->get();
        return $this->success($review, 'Review retrieved successfully.');
    }
}

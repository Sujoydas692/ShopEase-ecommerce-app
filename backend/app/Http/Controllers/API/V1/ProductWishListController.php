<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\WishListRequest;
use App\Models\ProductWishList;

class ProductWishListController extends Controller
{
    public function UserWishList()
    {
        $wishList = ProductWishList::with('product')->whereUserId(auth()->id())->get();

        return $this->success($wishList, 'Wishlist retrieved successfully.');
    }

    public function addWishList(WishListRequest $request)
    {
        $user = auth()->user();
        if (ProductWishList::where('user_id', $user->id)->where('product_id', $request->product_id)->exists()) {
            return $this->error('Product already in wishlist.', 400);
        }
        ProductWishList::create([
            'user_id' => $user->id,
            'product_id' => $request->product_id,
        ]);

        return $this->success(null, 'Product added to wishlist.');
    }

    public function removeProductFromWishList(WishListRequest $request)
    {
        $user = auth()->user();
        $productWishList = ProductWishList::where('user_id', $user->id)->where('product_id', $request->product_id)->first();
        if (! $productWishList) {
            return $this->error('Product not in your wishlist.', 400);
        }
        $productWishList->delete();

        return $this->success(null, 'Product remove from your wishlist.');
    }
}

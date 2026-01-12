<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AddCartRequest;
use App\Http\Requests\API\V1\RemoveCartRequest;
use App\Http\Requests\API\V1\UpdateCartRequest;
use App\Models\Cart;
use App\Models\Product;

class ShoppingCartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')->where('user_id', auth()->id())->get();

        return $this->success($carts, 'Carts retrieved successfully.');
    }

    public function addToCart(AddCartRequest $request)
    {
        $user = auth()->user();
        $product = Product::with('variations')->findOrFail($request->product_id);

        $hasVariations = $product->variations->count() > 0;

        $variation = null;
        $availableStock = 0;

        if ($hasVariations) {
            if (! $request->filled('size') || ! $request->filled('color')) {
                return $this->error('Size and color are required.', 400);
            }

            $variation = $product->variations
                ->where('size', $request->size)
                ->where('color', $request->color)
                ->first();

            if (! $variation) {
                return $this->error('Selected variation not available.', 400);
            }

            $availableStock = $variation->stock;
        } else {
            $availableStock = $product->stock;
        }

        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('size', $hasVariations ? $request->size : null)
            ->where('color', $hasVariations ? $request->color : null)
            ->first();

        $newQty = $request->qty + ($cart->qty ?? 0);

        if ($newQty > $availableStock) {
            return $this->error('Requested quantity exceeds available stock.', 400);
        }

        $price = $product->discount && $product->discount > 0
            ? $product->discount_price
            : $product->price;

        if ($cart) {
            $cart->update(['qty' => $newQty]);
            return $this->success(null, 'Cart updated successfully.');
        }

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'qty' => $request->qty,
            'price' => $price,
            'size' => $hasVariations ? $request->size : null,
            'color' => $hasVariations ? $request->color : null,
        ]);

        return $this->success(null, 'Product added to cart.');
    }

    public function updateCart(UpdateCartRequest $request)
    {
        $cart = Cart::where('id', $request->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $product = Product::with('variations')->findOrFail($cart->product_id);

        if ($cart->size || $cart->color) {
            $variation = $product->variations
                ->where('size', $cart->size)
                ->where('color', $cart->color)
                ->first();

            if (! $variation || $request->qty > $variation->stock) {
                return $this->error('Requested quantity exceeds available stock.', 400);
            }
        } else {
            if ($request->qty > $product->stock) {
                return $this->error('Requested quantity exceeds available stock.', 400);
            }
        }

        $cart->update(['qty' => $request->qty]);

        return $this->success($cart, 'Cart quantity updated successfully.');
    }

    public function removeToCart(RemoveCartRequest $request)
    {
        $user = auth()->user();
        if (! $cart = Cart::whereId($request->cart_id)->whereUserId($user->id)->first()) {
            return $this->error('Product not in your cart.', 400);
        }

        $cart->delete();

        return $this->success(null, 'Product removed from cart.');
    }

    public function flashCart()
    {
        Cart::whereUserId(auth()->id())->delete();

        return $this->success(null, 'Cart cleared.');
    }
}

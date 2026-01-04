<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\AddCartRequest;
use App\Http\Requests\API\V1\RemoveCartRequest;
use App\Http\Requests\API\V1\UpdateCartRequest;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductDetails;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

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

        $availableSizes  = $product->variations->pluck('size')->filter()->unique()->values();
        $availableColors = $product->variations->pluck('color')->filter()->unique()->values();

        if ($availableSizes->isNotEmpty()) {
            if (!$request->filled('size')) {
                return $this->error('Size is required', 400);
            }
            if (!$availableSizes->contains($request->size)) {
                return $this->error('Size is not available.', 400);
            }
        }

        if ($availableColors->isNotEmpty()) {
            if (!$request->filled('color')) {
                return $this->error('Color is required', 400);
            }
            if (!$availableColors->contains($request->color)) {
                return $this->error('Color is not available.', 400);
            }
        }

        $availableStock = $product->stock;

        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('color', $request->color)
            ->where('size', $request->size)
            ->first();

        if ($cart) {
            $newQty = $cart->qty + $request->qty;

            if ($newQty > $availableStock) {
                return $this->error('You cannot add more than available stock.', 400);
            }

            $cart->qty = $newQty;
            $cart->save();

            return $this->success(null, 'Cart updated successfully.');
        }

        if ($request->qty > $availableStock) {
            return $this->error('Requested quantity exceeds available stock.', 400);
        }

        if ($product->discount && $product->discount > 0) {
            $price = $product->discount_price;
        } else {
            $price = $product->price;
        }

        Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'qty' => $request->qty,
            'price' => $price,
            'color' => $availableColors->isNotEmpty() ? $request->color : null,
            'size' => $availableSizes->isNotEmpty() ? $request->size : null,
        ]);

        return $this->success(null, 'Product added to cart.');
    }

    public function updateCart(UpdateCartRequest $request)
    {
        $cart = Cart::where('id', $request->id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $product = Product::findOrFail($cart->product_id);

        if ($request->qty > $product->stock) {
            return $this->error('Requested quantity exceeds available stock.', 400);
        }

        $cart->qty = $request->qty;
        $cart->save();

        return $this->success($cart, 'Cart quantity updated successfully.');
    }

    public function removeToCart(RemoveCartRequest $request)
    {
        $user = auth()->user();
        if (!$cart = Cart::whereId($request->cart_id)->whereUserId($user->id)->first()) {
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

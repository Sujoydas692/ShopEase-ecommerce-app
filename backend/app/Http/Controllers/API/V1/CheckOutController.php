<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\ShippingHelper;
use App\Helpers\SslCommerz;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\CheckOutRequest;
use App\Models\Cart;
use App\Models\CustomerProfile;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use App\Models\ProductVariation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckOutController extends Controller
{
    public function checkout(CheckOutRequest $request)
    {
        try {
            $user = auth()->user();

            $userCart = Cart::whereUserId($user->id)->get();
            if ($userCart->isEmpty()) {
                return $this->error('Cart is empty.', 400);
            }

            DB::beginTransaction();

            $profileData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'district' => $request->district,
                'upazila' => $request->upazila,
                'postal_code' => $request->postal_code,
                'address' => $request->address,
            ];

            $customerProfile = CustomerProfile::updateOrCreate(
                ['user_id' => $user->id],
                $profileData
            );

            $customerData = json_encode($customerProfile->only([
                'first_name', 'last_name', 'email', 'phone',
                'district', 'upazila', 'postal_code', 'address',
            ]));

            $total = 0;
            foreach ($userCart as $cart) {
                $total += $cart->price * $cart->qty;
            }
            $shipping_charge = ShippingHelper::getShippingCharge(
                $request->district_id,
                $request->upazila_id
            );
            $payable = $total + $shipping_charge;

            $invoiceNo = '#'.random_int(100000, 999999);

            $invoice = Invoice::create([
                'user_id' => $user->id,
                'invoice_no' => $invoiceNo,
                'total' => $total,
                'shipping' => $shipping_charge,
                'vat' => null,
                'payable' => $payable,
                'cus_details' => $customerData,
                'ship_details' => $customerData,
            ]);

            foreach ($userCart as $cart) {
                InvoiceProduct::create([
                    'invoice_id' => $invoice->id,
                    'product_id' => $cart->product_id,
                    'quantity' => $cart->qty,
                    'unit_price' => $cart->price,
                    'total_price' => $cart->price * $cart->qty,
                    'size' => $cart->size,
                    'color' => $cart->color,
                ]);

                if ($cart->size) {

                    $variationQuery = ProductVariation::where('product_id', $cart->product_id)
                        ->where('size', $cart->size);

                    if ($cart->color) {
                        $variationQuery->where('color', $cart->color);
                    } else {
                        $variationQuery->whereNull('color');
                    }

                    $variation = $variationQuery->lockForUpdate()->first();

                    if (! $variation) {
                        throw new \Exception('Selected product variation no longer exists.');
                    }

                    if ($variation->stock < $cart->qty) {
                        throw new \Exception(
                            "Only {$variation->stock} item(s) left for this product."
                        );
                    }

                    $variation->decrement('stock', $cart->qty);

                } else {

                    $product = Product::lockForUpdate()->find($cart->product_id);

                    if (! $product) {
                        throw new \Exception('Product not found');
                    }

                    if ($product->stock < $cart->qty) {
                        throw new \Exception(
                            "Only {$product->stock} item(s) left for this product."
                        );
                    }

                    $product->decrement('stock', $cart->qty);
                }
            }

            Cart::whereUserId($user->id)->delete();

            DB::commit();

            // $sslResponse = SslCommerz::initPayment($request, $invoice);

            return $this->success(null, 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order Place Error: '.$e->getMessage());

            return $this->error($e->getMessage(), 500);
        }
    }

    public function getProfile()
    {
        try {
            $user = auth()->user();

            $profile = CustomerProfile::where('user_id', $user->id)->first();

            if (! $profile) {
                return $this->success(null, 'No profile found.');
            }

            return $this->success($profile, 'Profile loaded successfully.');
        } catch (\Exception $e) {
            return $this->error('Failed to load profile.', 500);
        }
    }
}

<?php

use App\Helpers\ShippingHelper;
use App\Http\Controllers\API\V1\Auth\AuthController;
use App\Http\Controllers\API\V1\BrandController;
use App\Http\Controllers\API\V1\CategoryController;
use App\Http\Controllers\API\V1\CheckOutController;
use App\Http\Controllers\API\V1\LocationController;
use App\Http\Controllers\API\V1\OrderController;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\ProductWishListController;
use App\Http\Controllers\Api\V1\ReviewController;
use App\Http\Controllers\API\V1\ShoppingCartController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1'], function () {

    Route::post('login/otp/send', [AuthController::class, 'loginOtpSend']);
    Route::post('login', [AuthController::class, 'login']);

    Route::get('brands', [BrandController::class, 'index']);
    Route::get('/brand/{slug}', [BrandController::class, 'show']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::get('/category/{slug}', [CategoryController::class, 'show']);

    Route::get('products', [ProductController::class, 'index']);
    Route::get('/product/{slug}', [ProductController::class, 'show']);
    Route::get('products/featured', [ProductController::class, 'featuredProducts']);
    Route::get('/products/{id}/related', [ProductController::class, 'relatedProducts']);
    Route::get('products/sliders', [ProductController::class, 'productSliders']);
    Route::get('/products/search', [ProductController::class, 'search']);
    Route::get('/products/search-paginate', [ProductController::class, 'searchPaginate']);
    Route::get('/products/category/{slug}', [ProductController::class, 'productsByCategory']);
    Route::get('/products/brand/{slug}', [ProductController::class, 'productsByBrand']);

    Route::get('/products/{id}/reviews', [ReviewController::class, 'index']);
    Route::post('/products/{id}/reviews', [ReviewController::class, 'store']);

    Route::get('/districts', [LocationController::class, 'district']);
    Route::get('/upazilas/{district_id}', [LocationController::class, 'upazila']);


    Route::group(['middleware' => 'auth:sanctum'], function () {
        Route::get('wish-list', [ProductWishListController::class, 'UserWishList']);
        Route::post('add/wish-list', [ProductWishListController::class, 'addWishList']);
        Route::post('remove/wish-list', [ProductWishListController::class, 'removeProductFromWishList']);

        Route::get('carts', [ShoppingCartController::class, 'index']);
        Route::post('add/cart', [ShoppingCartController::class, 'addToCart']);
        Route::post('update/cart', [ShoppingCartController::class, 'updateCart']);
        Route::post('remove/cart', [ShoppingCartController::class, 'removeToCart']);
        Route::get('clear/cart', [ShoppingCartController::class, 'flashCart']);

        Route::post('/checkout', [CheckOutController::class, 'checkout']);
        Route::get('/customer-profile', [CheckOutController::class, 'getProfile']);

        Route::get('/order', [OrderController::class, 'index']);

        Route::get('/shipping-charge/{districtId}/{upazilaId?}', function ($districtId, $upazilaId = null) {
        $charge = ShippingHelper::getShippingCharge($districtId, $upazilaId);
        return response()->json(['charge' => $charge]);
    });
    });

    Route::get('success', function () {
        return response()->json(['message' => 'Success'], 200);
    });

    Route::get('fail', function () {
        return response()->json(['message' => 'Failed'], 200);
    });

    Route::get('cancel', function () {
        return response()->json(['message' => 'Canceled'], 200);
    });

    Route::get('ipn', function () {
        return response()->json(['message' => 'ipn'], 200);
    });
});

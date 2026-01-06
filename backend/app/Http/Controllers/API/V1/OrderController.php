<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Invoice;

class OrderController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $orders = Invoice::where('user_id', $user->id)
            ->with('products')
            ->orderBy('id', 'DESC')
            ->get();

        return $this->success($orders, 'Order retrieved successfully.');
    }
}

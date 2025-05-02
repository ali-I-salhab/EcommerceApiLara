<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function store(Request $request)
{
    $request->validate([
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
    ]);

    $user = auth()->user;
    $total = 0;

    foreach ($request->items as $item) {
        $product = \App\Models\Product::findOrFail($item['product_id']);
        $total += $product->price * $item['quantity'];
    }

    $order = \App\Models\Order::create([
        'user_id' => $user->id,
        'total' => $total,
    ]);

    foreach ($request->items as $item) {
        $product = \App\Models\Product::findOrFail($item['product_id']);
        $order->items()->create([
            'product_id' => $product->id,
            'quantity' => $item['quantity'],
            'price' => $product->price,
        ]);
    }

    return response()->json(['message' => 'Order created successfully', 'order_id' => $order->id]);
}

}

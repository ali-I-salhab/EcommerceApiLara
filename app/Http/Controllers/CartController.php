<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;

use Illuminate\Support\Facades\Auth;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    // Add item to cart
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'integer|min:1'
        ]);

        $cart = Cart::updateOrCreate(
            ['user_id' => auth()->id, 'product_id' => $request->product_id],
            ['quantity' => DB::raw('quantity + ' . ($request->quantity ?? 1))]
        );

        return response()->json(['message' => 'Product added to cart', 'cart' => $cart]);
    }

    // View cart
    public function viewCart()
    {
        $cartItems = Cart::with('product')->where('user_id', auth()->id)->get();

        return response()->json($cartItems);
    }

    // Remove item
    public function removeItem($product_id)
    {
        Cart::where('user_id', auth()->id)->where('product_id', $product_id)->delete();

        return response()->json(['message' => 'Item removed from cart']);
    }

    // Clear cart
    public function clearCart()
    {
        Cart::where('user_id', auth()->id)->delete();

        return response()->json(['message' => 'Cart cleared']);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    function getCart(Request $request)
    {
        $request->validate([
            'userId' => 'required|integer|exists:users,id',
        ]);

        $cartItems = Cart::where('user_id', $request->userId)
            ->leftJoin('products', 'products.id', '=', 'cart.product_id')
            ->get()
            ->toArray();

        return response()->json([
            'cartItems' => $cartItems
        ]);
    }
}

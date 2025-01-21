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
            ->select('cart.id as id', 'cart.product_id', 'cart.quantity', 'p.image_small', 'p.name', 'p.price')
            ->join('products as p', 'cart.product_id', '=', 'p.id')
            ->get()
            ->toArray();

        return response()->json([
            'cartItems' => $cartItems
        ]);
    }

    function deleteCartItem(Request $request)
    {
        $request->validate([
            'cartItemId' => 'required|integer',
        ]);

        $status = Cart::where('id', $request->cartItemId)->delete();

        return response()->json([
            'status' => $status
        ]);
    }
}

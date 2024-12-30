<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Cart;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\ProductLikes;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    function getProducts(): JsonResponse
    {
        $userId = $request->userId ?? 0;

        $products = Product::where('is_active', 1)
            ->with('product_likes')
            ->get()
            ->map(function ($product) use ($userId) {
                $product->liked = isset($product->product_likes[0]['user_id']);
                return $product;
            })
            ->toArray();

        return response()->json($products);
    }

    function getProductsByPrice(Request $request): JsonResponse
    {
        if ($request->filter['from'] === '' && $request->filter['to'] === '')
            return $this->getProducts();

        $products = Product::where('is_active', 1)
            ->whereBetween('price', [$request->filter['from'], $request->filter['to']])
            ->get()
            ->toArray();

        return response()->json($products);
    }

    function getCategories(): JsonResponse
    {
        $categories = ProductCategory::where('is_active', 1)
            ->withCount('products')
            ->get()
            ->toArray();

        return response()->json($categories);
    }

    function getBrands(): JsonResponse
    {
        $brands = Brand::where('is_active', 1)->get()->toArray();

        return response()->json($brands);
    }

    function addToCart(Request $request)
    {
        $request->validate([
            'productId' => 'required|integer|exists:products,id',
            'userId' => 'required|integer|exists:users,id',
        ]);

        $cartItem = Cart::where('user_id', $request->userId)
            ->where('product_id', $request->productId)
            ->first();

        if($cartItem){
            $cartItem->quantity += 1;
            $cartItem->save();
        }else{
            $cartItem = Cart::create([
                'user_id' => $request->userId,
                'product_id' => $request->productId,
                'quantity' => 1,
            ]);
            $cartItem->save();
        }

        $items = Cart::where('user_id', $request->userId)->get()->toArray();

        return response()->json([
            'cartItemsCount' => count($items)
        ]);
    }

    function likeProduct(Request $request): JsonResponse
    {
        $request->validate([
            'productId' => 'required|integer|exists:products,id',
            'userId' => 'required|integer|exists:users,id',
        ]);

        $productLike = ProductLikes::where('product_id', $request->productId)
            ->where('user_id', $request->userId)->first();

        if (!$productLike) {
            $productLike = ProductLikes::create([
                'user_id' => $request->userId,
                'product_id' => $request->productId
            ]);
            $productLike->save();
            $message = 'liked';
        } else {
            $productLike->delete();
            $message = 'unliked';
        }

        return response()->json([
            'message' => $message
        ]);
    }
}

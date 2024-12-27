<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    function getProducts(): JsonResponse
    {
        $products = Product::where('is_active', 1)->get()->toArray();

        return response()->json($products);
    }

    function getProductsByPrice(Request $request): JsonResponse
    {
        if($request->filter['from'] === '' && $request->filter['to'] === '')
            return $this->getProducts();

        $products = Product::where('is_active', 1)
            ->whereBetween('price', [$request->filter['from'], $request->filter['to']])
            ->get()
            ->toArray();

        return response()->json($products);
    }

    function getCategories(): JsonResponse
    {
        $categories = Category::where('is_active', 1)
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
}

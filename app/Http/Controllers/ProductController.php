<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    function get(): JsonResponse
    {
        $products = Product::where('is_active', 1)->get()->toArray();

        return response()->json($products);
    }
}

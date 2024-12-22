<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    function get()
    {
        return response()->json([
            [
                'name' => 'Jewelry Store',
                'price' => 20,
                'discount' => 10,
            ]
        ]);
    }
}

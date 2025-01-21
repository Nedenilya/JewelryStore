<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    function getCollectionName(Request $request){
        $request->validate([
            'collectionId' => 'required|integer',
        ]);

        $collections = DB::table('collections')
            ->select('name')
            ->where('id', $request->collectionId)
            ->first()
            ->name;

        return response()->json($collections);
    }
}

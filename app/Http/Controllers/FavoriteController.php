<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('product')->get();
        return view('favorites', compact('favorites'));
    }

    public function toggle(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->product_id;

        $favorite = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        }

        Favorite::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);

        return response()->json(['status' => 'added']);
    }

    public function check(Request $request)
    {
        $userId = Auth::id();
        $productId = $request->product_id;

        $favorite = Favorite::where('user_id', $userId)
            ->where('product_id', $productId)
            ->exists();

        return response()->json(['isFavorite' => $favorite]);
    }
}

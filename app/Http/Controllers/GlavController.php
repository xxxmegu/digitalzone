<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GlavController extends Controller
{
    public function index() 
    { 
        $newProducts = DB::table('products')
            ->select('id', 'img', 'title', 'price')
            ->orderBy('created_at', 'desc') 
            ->take(3) 
            ->get(); 
    
        $popularProductIds = [1, 19, 25]; 
    
        $popularProducts = DB::table('products')
            ->select('id', 'img', 'title', 'price')
            ->whereIn('id', $popularProductIds) 
            ->get(); 
    
        return view('welcome', [
            'newProducts' => $newProducts,
            'popularProducts' => $popularProducts
        ]); 
    }
}

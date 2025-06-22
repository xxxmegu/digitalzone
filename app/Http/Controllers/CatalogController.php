<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogController extends Controller
{
    public function getProducts(Request $request) 
    {
        $query = DB::table('products')
            ->where('qty', '>', 0)
            ->join(
                'categories',
                'categories.id',
                '=',
                'products.product_type'
            )
            ->leftJoin(
                'subcategories',
                'subcategories.id',
                '=',
                'products.subcategory_id'
            )
            ->select(
                'products.id',
                'products.title',
                'products.price',
                'products.qty',
                'products.img',
                'products.country',
                'products.color',
                'products.description',
                'categories.product_type',
                'products.subcategory_id',
                'subcategories.name as subcategory_name'
            );

        if ($request->filled('category')) {
            $query->where('categories.product_type', '=', $request->category);
        }

        if ($request->filled('subcategory')) {
            $query->where('subcategories.name', '=', $request->subcategory);
        }

        if ($request->filled('country')) {
            $query->where('products.country', '=', $request->country);
        }

        if ($request->filled('price_from')) {
            $query->where('products.price', '>=', (float)$request->price_from);
        }
        if ($request->filled('price_to')) {
            $query->where('products.price', '<=', (float)$request->price_to);
        }

        if ($request->has('sort_by')) {
            $query->orderBy($request->sort_by);
        }
        if ($request->has('sort_by_desc')) {
            $query->orderByDesc($request->sort_by_desc);
        }

        $products = $query->get();

        $categories = DB::table('categories')
            ->select('categories.*')
            ->get();

        $subcategories = DB::table('subcategories')
            ->select('subcategories.*', 'categories.product_type')
            ->join('categories', 'categories.id', '=', 'subcategories.category_id')
            ->get();

        $countries = DB::table('products')
            ->where('country', '!=', '')
            ->whereNotNull('country')
            ->distinct()
            ->pluck('country');

        return view('catalog', [
            'products' => $products,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'countries' => $countries,
            'params' => collect($request->query())
        ]);
    }
}

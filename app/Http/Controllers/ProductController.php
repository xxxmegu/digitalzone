<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $product = DB::table('products')
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
                'subcategories.name as subcategory_name'
            )
            ->where('products.id', $id)
            ->first();
            
        if (is_null($product)) {
            return abort(404);
        }

        $totalInCarts = DB::table('cart')
            ->where('pid', $id)
            ->sum('qty');

        $totalInOrders = DB::table('orders')
            ->where('pid', $id)
            ->where('status', '!=', 'Отменён')
            ->sum('qty');
        
        $product->available_qty = $product->qty - ($totalInCarts + $totalInOrders);
        
        return view('product', ['product' => $product]);
    }

    public function getProducts(Request $request)
    {
        $query = DB::table('products')
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
                'products.id as id',
                'products.*',
                'categories.product_type',
                'subcategories.name as subcategory_name'
            );

        if ($request->has('category')) {
            $query->where('categories.product_type', $request->category);
        }

        if ($request->has('subcategory')) {
            $query->where('subcategories.name', $request->subcategory);
        }

        if ($request->has('country') && $request->country !== '') {
            $query->where('products.country', $request->country);
        }

        if ($request->has('price_from') && $request->price_from !== '') {
            $query->where('products.price', '>=', $request->price_from);
        }
        if ($request->has('price_to') && $request->price_to !== '') {
            $query->where('products.price', '<=', $request->price_to);
        }

        $products = $query->get();

        $categories = DB::table('categories')
            ->select('categories.*')
            ->get();

        $subcategories = DB::table('subcategories')
            ->select('subcategories.*', 'categories.product_type')
            ->join('categories', 'categories.id', '=', 'subcategories.category_id')
            ->get();

        return view('products', [
            'products' => $products,
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
    }

    public function getProductById(Request $request)
    {
        $id = $request->id;
        $categories = DB::table('categories')->get();
        $subcategories = DB::table('subcategories')
            ->select('subcategories.*', 'categories.product_type')
            ->join('categories', 'categories.id', '=', 'subcategories.category_id')
            ->get();
        $product = DB::table('products')
            ->join('categories', 'categories.id', '=', 'products.product_type')
            ->leftJoin('subcategories', 'subcategories.id', '=', 'products.subcategory_id')
            ->select(
                'products.id as id',
                'products.*',
                'categories.product_type as product_type',
                'subcategories.id as subcategory_id'
            )
            ->where('products.id', $id)
            ->first();

        if (!is_null($product)) {
            return view('admin.product-edit', [
                'categories' => $categories,
                'subcategories' => $subcategories,
                'product' => $product
            ]);
        } else {
            return abort(404);
        }
    }

    public function editProduct(Request $request)
    {
        $product = DB::table('products')->where('id', $request->id);
        $product->update([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'qty' => $request->input('qty'),
            'price' => $request->input('price'),
            'product_type' => $request->input('category'),
            'img' => $request->input('img'),
            'country' => $request->input('country'),
            'color' => $request->input('color'),
            'updated_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
        return redirect()->route('admin.products');
    }

    public function createProductView()
    {
        $categories = DB::table('categories')->get();
        $subcategories = DB::table('subcategories')
            ->select('subcategories.*', 'categories.product_type', 'subcategories.category_id')
            ->join('categories', 'categories.id', '=', 'subcategories.category_id')
            ->get();
        return view('admin.product-create', [
            'categories' => $categories,
            'subcategories' => $subcategories
        ]);
    }

    public function createProduct(Request $request)
    {
        DB::table('products')->insert([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'qty' => $request->input('qty'),
            'price' => $request->input('price'),
            'product_type' => $request->input('category'),
            'subcategory_id' => $request->input('subcategory'),
            'img' => $request->input('img'),
            'country' => $request->input('country'),
            'color' => $request->input('color'),
            'created_at' => DB::raw('CURRENT_TIMESTAMP')
        ]);
        return redirect()->route('admin.products');
    }

    public function deleteProduct(Request $request)
    {
        $product = DB::table('products')->where('id', $request->id);
        $product->delete();
        return redirect()->route('admin.products');
    }
}

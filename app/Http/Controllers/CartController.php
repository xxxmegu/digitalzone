<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = DB::table('cart')
            ->where('uid', $request->user()->id)
            ->join('products', 'cart.pid', '=', 'products.id')
            ->join('categories', 'products.product_type', '=', 'categories.id')
            ->select(
                'cart.id',
                'cart.pid',
                'cart.qty',
                'products.title',
                'products.price',
                'products.qty as limit',
                'products.country',
                'products.color',
                'categories.product_type'
            )
            ->get();
            
        $goodCart = [];
        foreach ($cartItems as $item) {
            array_push(
                $goodCart,
                (object)[
                    'id' => $item->id,
                    'pid' => $item->pid,
                    'title' => $item->title,
                    'price' => $item->price,
                    'qty' => $item->qty,
                    'limit' => $item->limit,
                    'country' => $item->country,
                    'color' => $item->color,
                    'product_type' => $item->product_type
                ]
            );
        }
        
        session(['cart' => $goodCart]);
        return view('cart', ['cart' => $goodCart]);
    }

    public function addToCart(Request $request)
    {
        $product = DB::table('products')
            ->join('categories', 'products.product_type', '=', 'categories.id')
            ->select(
                'products.id',
                'products.title',
                'products.price',
                'products.qty',
                'products.country',
                'products.color',
                'categories.product_type'
            )
            ->where('products.id', $request->id)
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Товар не найден'], 404);
        }

        if ($product->qty <= 0) {
            return response()->json(['message' => 'Товар отсутствует на складе'], 400);
        }

        $cartItem = DB::table('cart')
            ->join('products', 'cart.pid', '=', 'products.id')
            ->where('cart.uid', $request->user()->id)
            ->where('cart.pid', $request->id)
            ->where('products.title', $product->title)
            ->where('products.price', $product->price)
            ->where('products.country', $product->country)
            ->where('products.color', $product->color)
            ->select('cart.*')
            ->first();

        if ($cartItem) {
            if ($cartItem->qty >= $product->qty) {
                return response()->json(['message' => 'Недостаточно товара на складе'], 400);
            }
            
            DB::table('cart')
                ->where('id', $cartItem->id)
                ->update(['qty' => $cartItem->qty + 1]);
        } else {
            DB::table('cart')->insert([
                'uid' => $request->user()->id,
                'pid' => $request->id,
                'qty' => 1
            ]);
        }

        $this->updateCartSession($request);
        return response()->json(['message' => 'Товар добавлен в корзину']);
    }

    public function changeQty(Request $request)
    {
        $cartItem = DB::table('cart')
            ->where('uid', $request->user()->id)
            ->where('id', $request->id)
            ->first();
        
        if (!$cartItem) {
            return response()->json(['message' => 'Товар не найден в корзине'], 404);
        }

        $product = DB::table('products')
            ->join('categories', 'products.product_type', '=', 'categories.id')
            ->select(
                'products.id',
                'products.title',
                'products.price',
                'products.qty',
                'products.country',
                'products.color',
                'categories.product_type'
            )
            ->where('products.id', $cartItem->pid)
            ->first();

        if (!$product) {
            return response()->json(['message' => 'Товар не найден'], 404);
        }

        if ($request->param == "incr") {
            if ($cartItem->qty >= $product->qty) {
                return response()->json(['message' => 'Недостаточно товара на складе'], 400);
            }
            
            DB::table('cart')
                ->where('id', $cartItem->id)
                ->update(['qty' => $cartItem->qty + 1]);
        }
        else if ($request->param == "decr") {
            if ($cartItem->qty > 1) {
                DB::table('cart')
                    ->where('id', $cartItem->id)
                    ->update(['qty' => $cartItem->qty - 1]);
            } else {
                DB::table('cart')->where('id', $cartItem->id)->delete();
            }
        }

        $this->updateCartSession($request);
        return response()->json(['message' => 'Количество обновлено']);
    }

    private function updateCartSession(Request $request)
    {
        $cartItems = DB::table('cart')
            ->where('uid', $request->user()->id)
            ->join('products', 'cart.pid', '=', 'products.id')
            ->join('categories', 'products.product_type', '=', 'categories.id')
            ->select(
                'cart.id',
                'cart.pid',
                'cart.qty',
                'products.title',
                'products.price',
                'products.qty as limit',
                'products.country',
                'products.color',
                'categories.product_type'
            )
            ->get();
            
        $goodCart = [];
        foreach ($cartItems as $item) {
            array_push(
                $goodCart,
                (object)[
                    'id' => $item->id,
                    'pid' => $item->pid,
                    'title' => $item->title,
                    'price' => $item->price,
                    'qty' => $item->qty,
                    'limit' => $item->limit,
                    'country' => $item->country,
                    'color' => $item->color,
                    'product_type' => $item->product_type
                ]
            );
        }
        
        session(['cart' => $goodCart]);
    }
}

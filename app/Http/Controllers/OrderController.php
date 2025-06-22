<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OrderCreated;
use App\Mail\OrderConfirmed;
use App\Mail\OrderCanceled;

class OrderController extends Controller
{
    public function index(Request $request) 
    { 
        $cartTable = DB::table('cart')->where('uid', $request->user()->id)->get(); 
        $goodCart = []; 
        $totalPrice = 0; 

        foreach ($cartTable as $cartItem) { 
            $product = DB::table('products')->select('title', 'price', 'qty')->where('id', $cartItem->pid)->first(); 

            if ($product) {
                $itemTotal = $product->price * $cartItem->qty; 
                $totalPrice += $itemTotal; 

                array_push( 
                    $goodCart, 
                    (object)[ 
                        'id' => $cartItem->id, 
                        'title' => $product->title, 
                        'price' => $product->price, 
                        'qty' => $cartItem->qty, 
                        'limit' => $product->qty 
                    ] 
                ); 
            }
        } 

        return view('createOrder', ['cart' => $goodCart, 'totalPrice' => $totalPrice]); 
    } 

    public function createOrder(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'payment_method' => 'required|in:card,cash',
            'delivery_method' => 'required|in:pickup,delivery',
            'delivery_address' => 'required_if:delivery_method,delivery'
        ], [
            'password.required' => 'Пожалуйста, введите пароль для подтверждения заказа',
            'payment_method.required' => 'Пожалуйста, выберите способ оплаты',
            'payment_method.in' => 'Выбран недопустимый способ оплаты',
            'delivery_method.required' => 'Пожалуйста, выберите способ получения',
            'delivery_method.in' => 'Выбран недопустимый способ получения',
            'delivery_address.required_if' => 'Пожалуйста, укажите адрес доставки'
        ]);

        if ($request->delivery_method === 'delivery' && empty($request->user()->phone)) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['phone' => 'Пожалуйста, заполните номер телефона на странице профиля']);
        }

        if (!Hash::check($request->password, $request->user()->password)) {
            return redirect()->back()
                ->withInput($request->except('password'))
                ->withErrors(['password' => 'Неверный пароль. Пожалуйста, проверьте правильность ввода и попробуйте снова.']);
        }

        $orderTable = DB::table('orders');
        $userCartTable = DB::table('cart')->where('uid', $request->user()->id)->get();

        if ($userCartTable->isEmpty()) {
            return redirect()->back()->withErrors(['cart' => 'Ваша корзина пуста']);
        }

        $orderNumber = Str::random(8);
        $checkOrderNumber = $orderTable->where('number', $orderNumber)->get()->groupBy(['number', 'uid'])->all();
        $orderNumber = $checkOrderNumber > 0 ? Str::random(8) : $orderNumber;

        $products = [];
        foreach ($userCartTable as $cartItem) {
            $product = DB::table('products')->where('id', $cartItem->pid)->first();
            
            if ($product->qty < $cartItem->qty) {
                return redirect()->back()->withErrors(['cart' => 'Недостаточное количество товара ' . $product->title]);
            }

            $products[] = (object)[
                'name' => $product->title,
                'qty' => $cartItem->qty
            ];

            $orderTable->insert([
                'uid' => $cartItem->uid,
                'pid' => $cartItem->pid,
                'qty' => $cartItem->qty,
                'number' => $orderNumber,
                'status' => 'Новый',
                'payment_method' => $request->payment_method,
                'delivery_method' => $request->delivery_method,
                'delivery_address' => $request->delivery_method === 'delivery' ? $request->delivery_address : null,
                'created_at' => now()
            ]);

            DB::table('products')
                ->where('id', $cartItem->pid)
                ->decrement('qty', $cartItem->qty);
        }
        
        $paymentMethod = $request->payment_method === 'card' ? 'По карте' : 'Наличными';
        $deliveryMethod = $request->delivery_method === 'pickup' ? 'Самовывоз' : 'Доставка';
        
        $order = (object)[
            'number' => $orderNumber,
            'status' => 'Новый',
            'payment_method' => $paymentMethod,
            'delivery_method' => $deliveryMethod,
            'delivery_address' => $request->delivery_method === 'delivery' ? $request->delivery_address : null,
            'phone' => $request->user()->phone
        ];

        Mail::to($request->user()->email)->send(new OrderCreated($order, $products));
        
        DB::table('cart')->where('uid', $request->user()->id)->delete();
        
        return redirect()->route('user')->with('success', 'Заказ успешно оформлен');
    }

    public function getOrders(Request $request)
    {
        $goodOrders = [];
        $filter = $request->query('filter');
        if ($filter == 'new') {
            $ordersTable = DB::table('orders')->where('status', 'Новый');
        } elseif ($filter == 'confirmed') {
            $ordersTable = DB::table('orders')->where('status', 'Подтвержден');
        } elseif ($filter == 'canceled') {
            $ordersTable = DB::table('orders')->where('status', 'Отменен');
        } else {
            $ordersTable = DB::table('orders');
        }
        $ordersTable = $ordersTable->get()->groupBy(['number']);

        foreach ($ordersTable as $order) {
            $openedOrder = $order->all();
            $userName = DB::table('users')->where('id', $openedOrder[0]->uid)->select('name', 'surname', 'patronymic')->first();
            $date = $openedOrder[0]->created_at;
            $orderNumber = $openedOrder[0]->number;
            $orderStatus = $openedOrder[0]->status;
            $paymentMethod = $openedOrder[0]->payment_method;
            $deliveryMethod = $openedOrder[0]->delivery_method;
            $deliveryAddress = $openedOrder[0]->delivery_address;

            $totalPrice = 0;
            $totalQty = 0;
            $products = [];

            foreach ($openedOrder as $orderItem) {
                $product = DB::table('products')->where('id', $orderItem->pid)->first();
                $totalPrice += $product->price * $orderItem->qty;
                $totalQty += $orderItem->qty;

                array_push(
                    $products,
                    (object) [
                        'title' => $product->title,
                        'price' => $product->price,
                        'qty' => $orderItem->qty,
                    ]
                );
            }

            array_push(
                $goodOrders,
                (object) [
                    'name' => $userName->surname . ' ' . $userName->name . ' ' . $userName->patronymic,
                    'number' => $orderNumber,
                    'products' => $products,
                    'date' => $date,
                    'totalPrice' => $totalPrice,
                    'totalQty' => $totalQty,
                    'status' => $orderStatus,
                    'payment_method' => $paymentMethod,
                    'delivery_method' => $deliveryMethod,
                    'delivery_address' => $deliveryAddress
                ]
            );
        }
        return view('admin.orders', ['orders' => $goodOrders]);
    }

    public function editOrderStatus(Request $request)
    {
        $action = $request->action;
        $orderNumber = $request->number;
        $order = DB::table('orders')->where('number', $orderNumber);
        $orderData = $order->first();

        $orderItems = DB::table('orders')->where('number', $orderNumber)->get();
        $products = [];
        $totalPrice = 0;

        foreach ($orderItems as $item) {
            $product = DB::table('products')->where('id', $item->pid)->first();
            $itemTotal = $product->price * $item->qty;
            $totalPrice += $itemTotal;

            $products[] = (object)[
                'title' => $product->title,
                'qty' => $item->qty,
                'price' => $product->price
            ];

            if ($action == 'cancel') {
                DB::table('products')
                    ->where('id', $item->pid)
                    ->increment('qty', $item->qty);
            }
        }

        $user = DB::table('users')->where('id', $orderData->uid)->first();

        $paymentMethod = $orderData->payment_method === 'card' ? 'По карте' : 'Наличными';
        $deliveryMethod = $orderData->delivery_method === 'pickup' ? 'Самовывоз' : 'Доставка';

        $orderInfo = (object)[
            'number' => $orderNumber,
            'payment_method' => $paymentMethod,
            'delivery_method' => $deliveryMethod,
            'delivery_address' => $orderData->delivery_address,
            'phone' => $user->phone
        ];

        if ($action == 'confirm') {
            $order->update(['status' => 'Подтвержден']);
            Mail::to($user->email)->send(new OrderConfirmed($orderInfo, $products, $totalPrice));
        } elseif ($action == 'cancel') {
            $order->update(['status' => 'Отменен']);
            Mail::to($user->email)->send(new OrderCanceled($orderInfo, $products, $totalPrice));
        } else {
            return abort(404);
        }
        return redirect()->route('admin.orders');
    }

    public function deleteOrder(Request $request)
    {
        $order = DB::table('orders')->where('uid', $request->user()->id)->where('number', $request->number);
        $status = $order->get()[0]->status;

        if (!is_null($order) && $status == 'Новый') {
            $orderItems = DB::table('orders')->where('number', $request->number)->get();
            foreach ($orderItems as $item) {
                DB::table('products')
                    ->where('id', $item->pid)
                    ->increment('qty', $item->qty);
            }
            $order->delete();
            return redirect()->route('user');
        } else {
            return abort(404);
        }
    }
}

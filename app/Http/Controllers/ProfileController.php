<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $goodOrders = [];
        $ordersTable = DB::table('orders')->where('uid', $user->id)->get()->groupBy(['number']);

        foreach ($ordersTable as $order) {
            $openedOrder = $order->all();
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

        usort($goodOrders, function($a, $b) {
            return strtotime($b->date) - strtotime($a->date);
        });

        return view('profile.index', [
            'orders' => $goodOrders,
            'user' => $user
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'current_password.required' => 'Пожалуйста, введите текущий пароль',
            'current_password.current_password' => 'Текущий пароль введён неверно',
            'password.required' => 'Пожалуйста, введите новый пароль',
            'password.confirmed' => 'Пароли не совпадают',
            'password.min' => 'Пароль должен быть не менее 8 символов',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return Redirect::route('user')->with('status', 'password-updated');
    }

    public function showChangePasswordForm(): View
    {
        return view('profile.change-password');
    }

    public function updatePhone(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'unique:users,phone,' . Auth::id(), 'regex:/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/'],
        ], [
            'phone.required' => 'Поле Телефон обязательно для заполнения',
            'phone.unique' => 'Такой номер телефона уже существует',
            'phone.regex' => 'Введите корректный номер телефона в формате +7 (999) 999-99-99'
        ]);

        Auth::user()->update([
            'phone' => $request->phone
        ]);

        return redirect()->back()->with('success', 'Номер телефона успешно обновлен');
    }
}

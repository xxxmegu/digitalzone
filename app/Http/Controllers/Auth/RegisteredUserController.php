<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'patronymic' => ['required', 'string', 'max:255'],
            'login' => 'required|string|regex:/^[-a-zA-Z0-9_.]*$/|min:6|max:32',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'regex:/^\+7 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rules_confirmation' => ['required', 'accepted'],
        ], [
            'name.required' => 'Поле Имя обязательно для заполнения',
            'surname.required' => 'Поле Фамилия обязательно для заполнения',
            'patronymic.required' => 'Поле Отчество обязательно для заполнения',
            'login.required' => 'Поле Логин обязательно для заполнения',
            'login.regex' => 'Логин может содержать только латинские буквы, цифры, тире и точку',
            'email.required' => 'Поле Email обязательно для заполнения',
            'email.email' => 'Введите корректный email адрес',
            'email.unique' => 'Такой email уже существует',
            'phone.required' => 'Поле Телефон обязательно для заполнения',
            'phone.regex' => 'Введите номер в формате +7 (999) 999-99-99',
            'phone.unique' => 'Такой номер телефона уже зарегистрирован',
            'password.required' => 'Поле Пароль обязательно для заполнения',
            'password.confirmed' => 'Пароли не совпадают',
            'rules_confirmation.required' => 'Необходимо согласиться с правилами регистрации',
            'rules_confirmation.accepted' => 'Необходимо согласиться с правилами регистрации'
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'patronymic' => $request->patronymic,
            'login' => $request->login,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
}

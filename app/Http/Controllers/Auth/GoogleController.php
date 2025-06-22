<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Mail\GoogleAuthMail;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        try {
            Log::info('Starting Google redirect');
            Log::info('Google OAuth configuration:', [
                'client_id' => config('services.google.client_id'),
                'redirect' => config('services.google.redirect')
            ]);
            return Socialite::driver('google')->redirect();
        } catch (Exception $e) {
            Log::error('Google Redirect Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('login')->with('error', 'Ошибка при перенаправлении на Google');
        }
    }

    public function handleGoogleCallback()
    {
        try {
            Log::info('Starting Google callback');
            $user = Socialite::driver('google')->user();
            Log::info('Google user data:', ['email' => $user->email, 'id' => $user->id]);
            
            $finduser = User::where('google_id', $user->id)->first();
            
            if ($finduser) {
                Log::info('Found existing user:', ['user_id' => $finduser->id]);
                Auth::login($finduser);
                return redirect()->route('glav');
            } else {
                Log::info('Creating new user with data:', [
                    'name' => $user->name,
                    'email' => $user->email,
                    'google_id' => $user->id
                ]);
                
                // Разделяем полное имя на имя и фамилию
                $nameParts = explode(' ', $user->name);
                $firstName = $nameParts[0] ?? 'Unknown';
                $lastName = $nameParts[1] ?? 'Unknown';
                
                // Генерируем случайный пароль
                $randomPassword = Str::random(12);
                
                $newUser = User::create([
                    'name' => $firstName,
                    'surname' => $lastName,
                    'patronymic' => '',
                    'email' => $user->email,
                    'google_id' => $user->id,
                    'password' => Hash::make($randomPassword),
                    'login' => explode('@', $user->email)[0]
                ]);

                // Отправляем письмо с данными для входа
                try {
                    Mail::to($user->email)->send(new GoogleAuthMail(
                        $firstName,
                        explode('@', $user->email)[0],
                        $randomPassword,
                        $user->email
                    ));
                    Log::info('Auth email sent successfully to: ' . $user->email);
                } catch (Exception $e) {
                    Log::error('Failed to send auth email: ' . $e->getMessage());
                }

                Auth::login($newUser);
                return redirect()->route('glav');
            }
        } catch (Exception $e) {
            Log::error('Google Auth Error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return redirect()->route('login')->with('error', 'Произошла ошибка при авторизации через Google');
        }
    }
} 
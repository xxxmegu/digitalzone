<x-guest-layout>
    <!-- Session Status -->
    <section class="login">
        <div class="login-content">
            @if(session('status'))
                <div class="login-success-message">
                    {{ session('status') == 'Your password has been reset.' ? 'Пароль успешно сброшен. Теперь вы можете войти.' : session('status') }}
                </div>
            @endif
            <form class="login__form" method="POST" action="{{ route('login') }}">
                <h1 class="login__title">Вход</h1>
                @csrf

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Email Address -->
                <div class="log__input">
                    <x-text-input placeholder="Логин" id="login" class="block mt-1 w-full" type="text" name="login" :value="old('email')" required autofocus autocomplete="username" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-text-input placeholder="Пароль" id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    <x-input-error :messages="$errors->get('login')" class="mt-2" />
                </div>

                <div class="bt-log">
                    <button class="button__login mt-4">
                        {{ __('Войти') }}
                    </button>
                </div>

                <div class="flex text-center mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" id="zabil" href="{{ route('password.request') }}">
                            {{ __('Забыли свой пароль?') }}
                        </a>
                    @endif
                </div>

                <div class="social-login mt-4">
                    <span class="social-login__text">Или войдите через</span>
                    <a href="{{ url('auth/google') }}" class="google-btn" title="Войти через Google">
                        <img src="{{ Vite::asset('resources/media/images/google.svg') }}" alt="Google">
                    </a>
                </div>
            </form>
        </div>
    </section>
</x-guest-layout>

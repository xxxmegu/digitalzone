<x-guest-layout>
    <div class="d-flex justify-content-center align-items-center mt-5" style="min-height: 100vh;">
        <div class="register-content">
            <form class="register__form" method="POST" action="{{ route('register') }}">
                <h1 class="register__title">Регистрация</h1>
                @csrf

                <!-- Name -->
                <div>
                    <x-text-input placeholder="Имя" id="name" class="block mt-3 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Surname -->
                <div>
                    <x-text-input placeholder="Фамилия" id="surname" class="block mt-4 w-full" type="text" name="surname" :value="old('surname')" required autofocus autocomplete="surname" />
                    <x-input-error :messages="$errors->get('surname')" class="mt-2" />
                </div>

                <!-- Patronymic -->
                <div>
                    <x-text-input placeholder="Отчетсво" id="patronymic" class="block mt-4 w-full" type="text" name="patronymic" :value="old('patronymic')" required autofocus autocomplete="patronymic" />
                    <x-input-error :messages="$errors->get('patronymic')" class="mt-2" />
                </div>

                <!-- Login -->
                <div>
                    <x-text-input placeholder="Логин" id="login" class="block mt-4 w-full" type="text" name="login" :value="old('login')" required autofocus autocomplete="login" />
                    <x-input-error :messages="$errors->get('login')" class="mt-2" />
                </div>

                <!-- Email Address -->
                <div class="mt-4">
                    <x-text-input placeholder="Email" id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Phone -->
                <div>
                    <x-text-input placeholder="Телефон" id="phone" class="block mt-4 w-full" type="text" name="phone" :value="old('phone')" required autofocus />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-text-input placeholder="Пароль" id="password" class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-text-input placeholder="Подтвердите пароль" id="password_confirmation" class="block mt-1 w-full"
                        type="password"
                        name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="sogl mt-4">
                    <x-input-label for="rules_confirmation" :value="__('Согласие с правилами регистрации:')" />
                    <x-text-input id="rules_confirmation" class="block w-full" type="checkbox" name="rules_confirmation" required />
                </div>

                <div class="mt-4">
                    <div class="bt-block">
                        <button class="button__register">
                            {{ __('Регистрация') }}
                        </button>
                    </div>
                </div>

                <div class="social-login mt-4">
                    <span class="social-login__text">Или войдите через</span>
                    <a href="{{ url('auth/google') }}" class="google-btn" title="Войти через Google">
                        <img src="{{ Vite::asset('resources/media/images/google.svg') }}" alt="Google">
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>

@push('scripts')
<script src="https://unpkg.com/imask"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var phoneInput = document.getElementById('phone');
        if (phoneInput) {
            var maskOptions = {
                mask: '+7 (000) 000-00-00'
            };
            var mask = IMask(phoneInput, maskOptions);
        }
    });
</script>
@endpush

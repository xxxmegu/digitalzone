<x-guest-layout>
    <link rel="stylesheet" href="/resources/css/reset-password.css">
    <section class="reset-password">
        <div class="reset-password__content">
            <form method="POST" action="{{ route('password.store') }}" class="reset-password__form">
                @csrf
                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                <!-- Email Address -->
                <div>
                    <h4 class="reset-password__title">Email:</h4>
                    <x-text-input id="email" class="reset-password__input" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="reset-password__error" />
                </div>
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Пароль:')" />
                    <x-text-input id="password" class="reset-password__input" type="password" name="password" required autocomplete="new-password" />
                </div>
                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Подтвердите пароль:')" />
                    <x-text-input id="password_confirmation" class="reset-password__input" type="password" name="password_confirmation" required autocomplete="new-password" />
                </div>
                @if ($errors->has('password'))
                    @foreach ($errors->get('password') as $message)
                        @if ($message == 'The password field confirmation does not match.')
                            <div class="reset-password__error">
                                Пароли не совпадают.
                            </div>
                        @elseif ($message == 'The password field must be at least 8 characters.')
                            <div class="reset-password__error">
                                Пароль должен быть не менее 8 символов.
                            </div>
                        @else
                            <div class="reset-password__error">
                                {{ $message }}
                            </div>
                        @endif
                    @endforeach
                @endif
                <div class="flex items-center justify-end mt-4">
                    <button class="btn__sbros">
                        {{ __('Сбросить пароль') }}
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-guest-layout>

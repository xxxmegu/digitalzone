<x-guest-layout>
    <link rel="stylesheet" href="/resources/css/forgot-password.css">
    <section class="forgot-password">
        <div class="forgot-password__content">
            @if (session('status'))
                <div class="forgot-password__success">
                    {{ __('Ссылка для сброса пароля отправлена на вашу электронную почту.') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}" class="forgot-password__form">
                @csrf
                <!-- Email Address -->
                <div class="vostan">
                    <h4 class="forgot-password__title">Email:</h4>
                    <x-text-input id="email" class="forgot-password__input" type="email" name="email" :value="old('email')" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="forgot-password__error" />
                </div>
                <div class="flex items-center justify-end mt-4">
                    <button class="btn__sbros">
                        {{ __('Ссылка для сброса пароля') }}
                    </button>
                </div>
            </form>
            <div class="forgot-password__desc">
                {{ __('Забыли свой пароль? Без проблем. Просто сообщите нам свой адрес электронной почты, и мы вышлем вам по электронной почте ссылку для сброса пароля, которая позволит вам выбрать новый.') }}
            </div>
        </div>
    </section>
</x-guest-layout>

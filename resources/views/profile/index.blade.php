@extends('layouts.app')
@section('content')
<div class="user">
    <div class="user-info mb-4">
        <div class="user-info__header">
            <h2 class="user-info__title">Информация о пользователе</h2>
            <div class="user-info__buttons">
                <a href="{{ route('password.change') }}" class="btn btn-primary">Сменить пароль</a>
                <form method="POST" action="{{ route('logout') }}" class="user-logout">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Выйти
                    </button>
                </form>
            </div>
        </div>
        <div class="user-info__content">
            <div class="user-info__item">
                <span class="user-info__label">ФИО:</span>
                <span class="user-info__value">{{ $user->surname }} {{ $user->name }} {{ $user->patronymic }}</span>
            </div>
            <div class="user-info__item">
                <span class="user-info__label">Логин:</span>
                <span class="user-info__value">{{ $user->login }}</span>
            </div>
            <div class="user-info__item">
                <span class="user-info__label">Email:</span>
                <span class="user-info__value">{{ $user->email }}</span>
            </div>
            @if($user->phone)
                <div class="user-info__item">
                    <span class="user-info__label">Телефон:</span>
                    <span class="user-info__value">{{ $user->phone }}</span>
                </div>
            @else
                <div class="user-info__item">
                    <span class="user-info__label">Телефон:</span>
                    <span class="user-info__value text-muted">Не указан</span>
                </div>
                <div class="phone-update-form">
                    <form method="POST" action="{{ route('profile.update-phone') }}">
                        @csrf
                        <div class="form-group phone-input-group">
                            <input type="text" 
                                   name="phone" 
                                   id="phone" 
                                   class="form-control phone-input @error('phone') is-invalid @enderror" 
                                   placeholder="Введите номер телефона" 
                                   value="{{ old('phone') }}" 
                                   required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-add-phone">
                            <i class="bi bi-telephone-plus"></i>
                            Добавить телефон
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <div class="orders-block">
        <h2 class="orders-block__title">История заказов</h2>
        @if (count($orders))
            <div class="orders-list">
                @foreach ($orders as $order)
                    <div class="order-card">
                        <div class="order-card__header">
                            <div class="order-card__info">
                                <div class="order-number">Заказ №{{ $order->number }}</div>
                                <div class="order-status">{{ $order->status }}</div>
                            </div>
                            @if ($order->status == 'Новый')
                                <form action="/order-delete/{{ $order->number }}" method="POST">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" class="order-delete">Отменить заказ</button>
                                </form>
                            @endif
                        </div>

                        <div class="order-card__content">
                            <div class="order-products">
                                <h3 class="order-products__title">Товары в заказе:</h3>
                                <div class="order-products__list">
                                    @foreach ($order->products as $product)
                                        <div class="order-product">
                                            <span class="order-product__name">{{ $product->title }} × {{ $product->qty }}</span>
                                            <span class="order-product__price">{{ $product->price * $product->qty }} ₽</span>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="order-products__total">
                                    Всего товаров: {{ $order->totalQty }} шт.
                                </div>
                            </div>
                            <div class="order-details">
                                <div class="order-details__item">
                                    <span class="order-details__label">Способ оплаты:</span>
                                    <span class="order-details__value">
                                        @if($order->payment_method === 'card')
                                            Оплата картой
                                        @else
                                            Оплата наличными
                                        @endif
                                    </span>
                                </div>
                                <div class="order-details__item">
                                    <span class="order-details__label">Способ получения:</span>
                                    <span class="order-details__value">
                                        @if($order->delivery_method === 'pickup')
                                            Самовывоз
                                        @else
                                            Доставка
                                        @endif
                                    </span>
                                </div>
                                @if($order->delivery_method === 'delivery' && $order->delivery_address)
                                    <div class="order-details__item">
                                        <span class="order-details__label">Адрес доставки:</span>
                                        <span class="order-details__value">{{ $order->delivery_address }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="order-card__total">
                                Итого к оплате: <span>{{ $order->totalPrice }} ₽</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="orders-empty">
                <p>У вас пока нет заказов</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="https://unpkg.com/imask"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let phoneInput = document.getElementById('phone');
        if (phoneInput) {
            let maskOptions = {
                mask: '+7 (000) 000-00-00'
            };
            let mask = IMask(phoneInput, maskOptions);
        }
    });
</script>
@endpush

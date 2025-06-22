@extends('layouts.app')
@section('content')
<div class="container">
    <div class="order-form">
        <h1 class="order-title">Оформление заказа</h1>
        <div class="order-summary">
            <div class="total-amount">
                <span>К ОПЛАТЕ:</span>
                <span class="amount">{{ number_format($totalPrice, 0, '.', ' ') }} ₽</span>
            </div>

            <form action="{{ route('create-order') }}" method="POST" class="order-details">
                @csrf
                <div class="payment-section">
                    <h3>Способ оплаты</h3>
                    <div class="payment-options">
                        <div class="payment-option">
                            <input type="radio" id="card" name="payment_method" value="card" checked>
                            <label for="card">
                                <i class="bi bi-credit-card"></i>
                                Оплата картой
                            </label>
                        </div>
                        <div class="payment-option">
                            <input type="radio" id="cash" name="payment_method" value="cash">
                            <label for="cash">
                                <i class="bi bi-cash"></i>
                                Оплата наличными
                            </label>
                        </div>
                    </div>
                </div>

                <div class="delivery-section">
                    <h3>Способ получения</h3>
                    <div class="delivery-options">
                        <div class="delivery-option">
                            <input type="radio" id="pickup" name="delivery_method" value="pickup" checked>
                            <label for="pickup">
                                <i class="bi bi-shop"></i>
                                Самовывоз
                            </label>
                        </div>
                        <div class="delivery-option">
                            <input type="radio" id="delivery" name="delivery_method" value="delivery">
                            <label for="delivery">
                                <i class="bi bi-truck"></i>
                                Доставка
                            </label>
                        </div>
                    </div>
                    @error('phone')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                    
                    <div id="delivery-address-container" style="display: none;">
                        <div class="form-group">
                            <label for="delivery_address">Адрес доставки</label>
                            <input type="text" id="delivery_address" name="delivery_address" class="form-control" placeholder="Введите адрес доставки">
                        </div>
                    </div>
                </div>

                <div class="password-section">
                    <div class="form-group">
                        <input type="password" 
                               name="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Введите пароль для подтверждения" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="submit-order">СФОРМИРОВАТЬ ЗАКАЗ</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliveryMethod = document.querySelectorAll('input[name="delivery_method"]');
    const addressContainer = document.getElementById('delivery-address-container');
    const addressInput = document.getElementById('delivery_address');

    deliveryMethod.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === 'delivery') {
                addressContainer.style.display = 'block';
                addressInput.required = true;
            } else {
                addressContainer.style.display = 'none';
                addressInput.required = false;
                addressInput.value = '';
            }
        });
    });
});
</script>
@endpush
@endsection

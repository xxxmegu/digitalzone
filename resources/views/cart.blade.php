@extends('layouts.app')

@push('head')
    @vite(['resources/css/cart.css'])
@endpush

@section('body-class', 'cart-page')

@section('content')
<section class="korz">  
    <div class="container">
        <div class="row row-korz">  
            <div class="korzina">  
                <div class="korz__tabl">  
                    @if (count($cart) > 0)  
                        <div class="cart-header">
                            <h2 class="cart-title">Ваша корзина</h2>
                            <div class="cart-summary">
                                <span>{{ count($cart) }} {{ count($cart) == 1 ? 'товар' : 'товаров' }}</span>
                            </div>
                        </div>
                        <table class="styled-table"> 
                            <thead>
                                <tr>
                                    <th>НАЗВАНИЕ</th>
                                    <th>КОЛИЧЕСТВО</th>
                                    <th>ЦЕНА</th>
                                    <th>ИТОГО</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($cart as $item)  
                                <tr class="cart__raw">
                                    <td>
                                        <div class="product-info">
                                            <span class="product-name">{{ $item->title }}</span>
                                        </div>
                                    </td> 
                                    <td> 
                                        <div class="kolich">  
                                            <button class="minus" id="decrease" cartid="{{ $item->id }}">
                                                <span>-</span>
                                            </button>  
                                            <p class="korz__dann">{{ $item->qty }}</p>  
                                            <button class="plus {{ $item->qty == $item->limit ? 'disabled' : '' }}" 
                                                    id="increase" 
                                                    cartid="{{ $item->id }}">
                                                <span>+</span>
                                            </button>  
                                        </div>
                                    </td>
                                    <td>
                                        <div class="price-info">
                                            <span class="price">{{ number_format($item->price, 0, '.', ' ') }} ₽</span>
                                        </div>
                                    </td> 
                                    <td>
                                        <div class="total-info">
                                            <span class="total">{{ number_format($item->price * $item->qty, 0, '.', ' ') }} ₽</span>
                                        </div>
                                    </td> 
                                </tr>
                                @php $total += $item->price * $item->qty; @endphp
                                @endforeach
                            </tbody>
                        </table>
                        {{-- Мобильная версия корзины --}}
                        <div class="cart-mobile-list">
                            @php $total = 0; @endphp
                            @foreach ($cart as $item)
                                <div class="cart-mobile-item">
                                    <div class="cart-mobile-title">{{ $item->title }}</div>
                                    <div class="cart-mobile-row">
                                        <div class="cart-mobile-label">Кол-во:</div>
                                        <div class="cart-mobile-qty">
                                            <button class="minus" id="decrease" cartid="{{ $item->id }}"><span>-</span></button>
                                            <span class="cart-mobile-qty-value">{{ $item->qty }}</span>
                                            <button class="plus {{ $item->qty == $item->limit ? 'disabled' : '' }}" id="increase" cartid="{{ $item->id }}"><span>+</span></button>
                                        </div>
                                    </div>
                                    <div class="cart-mobile-row">
                                        <div class="cart-mobile-label">Цена:</div>
                                        <div class="cart-mobile-value">{{ number_format($item->price, 0, '.', ' ') }} ₽</div>
                                    </div>
                                    <div class="cart-mobile-row">
                                        <div class="cart-mobile-label">Итого:</div>
                                        <div class="cart-mobile-value">{{ number_format($item->price * $item->qty, 0, '.', ' ') }} ₽</div>
                                    </div>
                                </div>
                                @php $total += $item->price * $item->qty; @endphp
                            @endforeach
                        </div>
                        <div class="cart-footer">
                            <div class="cart-total">
                                <span class="total-label">Итого:</span>
                                <span class="total-value">{{ number_format($total, 0, '.', ' ') }} ₽</span>
                            </div>
                            <div class="korz__bt">  
                                <a href="{{ route('create-order') }}" class="korz__zak">
                                    <span>Оформить заказ</span>
                                </a>  
                            </div>
                        </div>
                    @else  
                        <div class="cart-empty">
                            <h3 class="cart__table--empty">Корзина пуста</h3>
                            <p class="cart-empty-message">Добавьте товары в корзину, чтобы оформить заказ</p>
                        </div>
                    @endif  
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    document.querySelectorAll('.plus, .minus').forEach(btn => {
        btn.addEventListener('click', function() {
            const pid = this.getAttribute('cartid');
            if (this.classList.contains('plus')) {
                fetch(`/changeqty/incr/${pid}`)
                    .finally(() => window.location.reload());
            } else if (this.classList.contains('minus')) {
                fetch(`/changeqty/decr/${pid}`)
                    .finally(() => window.location.reload());
            }
        });
    });
</script>
@endpush

@extends('layouts.app')
@section('content')

        <section class="product">
            <div class="product__wrapper">
                <div class="product__gallery">
                    <div class="product__image">
                        <img src="{{ Vite::asset('resources/media/images/') . $product->img }}" alt="{{ $product->title }}">
                    </div>
                </div>
                <div class="product__info">
                    <h1 class="product__title">{{ $product->title }}</h1>
                    <div class="product__price">{{ $product->price }} ₽</div>
                    
                    <div class="product__description">
                        <h3>Описание</h3>
                        <p>{{ $product->description ?? 'Описание товара пока не добавлено' }}</p>
                    </div>

                    <div class="product__specs">
                        <h3>Характеристики</h3>
                        <div class="specs__grid">
                            <div class="specs__item">
                                <span class="specs__label">Категория</span>
                                <span class="specs__value">{{ $product->product_type }}</span>
                            </div>
                            <div class="specs__item">
                                <span class="specs__label">Страна производства</span>
                                <span class="specs__value">{{ $product->country }}</span>
                            </div>
                            <div class="specs__item">
                                <span class="specs__label">Цвет</span>
                                <span class="specs__value">{{ $product->color }}</span>
                            </div>
                            <div class="specs__item">
                                <span class="specs__label">В наличии</span>
                                <span class="specs__value">
                                    @if($product->qty <= 0)
                                        Нет в наличии
                                    @else
                                        {{ $product->qty }} шт.
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    @auth
                        <div class="product__actions">
                            <div class="actions-container">
                                <div class="buttons-container">
                                    @if($product->qty > 0)
                                        <button class="add-to-cart">
                                            <i class="bi bi-cart-plus"></i>
                                            <span>Добавить в корзину</span>
                                        </button>
                                    @else
                                        <div class="out-of-stock-btn">
                                            <i class="bi bi-x-octagon"></i>
                                            <span>Нет в наличии</span>
                                        </div>
                                    @endif
                                    
                                    <button class="toggle-favorite" onclick="toggleFavorite({{ $product->id }}, this)">
                                        <i class="bi bi-heart"></i>
                                        <span>В избранное</span>
                                    </button>
                                </div>

                                <div class="toast error" style="display: none;">
                                    <i class="bi bi-exclamation-circle"></i>
                                    <span>Нет в наличии</span>
                                </div>

                                <div class="toast success" style="display: none;">
                                    <i class="bi bi-check-circle"></i>
                                    <span>Товар добавлен в корзину</span>
                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </section>
   

<script>
document.addEventListener('DOMContentLoaded', function() {
    const pid = {{ $product->id }};
    const button = document.querySelector('.add-to-cart');
    const successToast = document.querySelector('.toast.success');
    const errorToast = document.querySelector('.toast.error');

    function showToast(toast) {
        toast.style.display = 'flex';
        setTimeout(() => {
            hideToast(toast);
        }, 3000);
    }

    function hideToast(toast) {
        toast.style.display = 'none';
    }

    if (button) {
        button.addEventListener('click', () => {
            fetch(`/add-to-cart/${pid}`)
                .then(response => {
                    if (response.status > 300) {
                        showToast(errorToast);
                    } else {
                        showToast(successToast);
                        fetch('/cart/count')
                            .then(res => res.json())
                            .then(data => {
                                document.querySelectorAll('.cart-counter').forEach(counter => {
                                    counter.textContent = data.count;
                                });
                            });
                    }
                })
                .catch(error => {
                    console.error('Ошибка:', error);
                    showToast(errorToast);
                });
        });
    }

    fetch('/favorites/check', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: pid
        })
    })
    .then(response => response.json())
    .then(data => {
        const favoriteBtn = document.querySelector('.toggle-favorite');
        if (data.isFavorite) {
            favoriteBtn.classList.add('active');
            favoriteBtn.querySelector('i').classList.remove('bi-heart');
            favoriteBtn.querySelector('i').classList.add('bi-heart-fill');
            favoriteBtn.querySelector('span').textContent = 'В избранном';
        }
    });

});

function toggleFavorite(productId, button) {
    fetch('/favorites/toggle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'added') {
            button.classList.add('active');
            button.querySelector('i').classList.remove('bi-heart');
            button.querySelector('i').classList.add('bi-heart-fill');
            button.querySelector('span').textContent = 'В избранном';
        } else {
            button.classList.remove('active');
            button.querySelector('i').classList.remove('bi-heart-fill');
            button.querySelector('i').classList.add('bi-heart');
            button.querySelector('span').textContent = 'В избранное';
        }
    });
}

</script>
@endsection

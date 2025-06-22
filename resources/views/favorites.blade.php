@extends('layouts.app')

@push('head')
    @vite(['resources/css/favorites.css'])
@endpush

@section('content')
<section class="izbranoe">
    <div class="container">
        <div class="favorites-wrapper">
            <h1 class="favorites__title">Избранные товары</h1>
            <div id="favorites-container">
                @if($favorites->count() > 0)
                    <div class="favorites-grid">
                        @foreach($favorites as $favorite)
                            <div class="favorites__item">
                                <div class="favorites__image">
                                    <img src="{{ Vite::asset('resources/media/images/') . $favorite->product->img }}" alt="{{ $favorite->product->title }}" class="img-fluid">
                                    @if($favorite->product->qty <= 0)
                                        <div class="favorites__outofstock">Нет в наличии</div>
                                    @endif
                                </div>
                                <div class="favorites__info">
                                    <h3 class="favorites__name">
                                        <a href="{{ route('product', $favorite->product->id) }}">{{ $favorite->product->title }}</a>
                                    </h3>
                                    <p class="favorites__price">{{ number_format($favorite->product->price, 0, '.', ' ') }} ₽</p>
                                    <button class="favorites__remove d-flex align-items-center justify-content-center gap-2" 
                                            onclick="toggleFavorite({{ $favorite->product->id }}, this)"
                                            data-product-id="{{ $favorite->product->id }}">
                                        <i class="bi bi-heart-fill"></i>
                                        <span>Удалить из избранного</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="favorites__empty">
                        У вас пока нет избранных товаров
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
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
        if (data.status === 'removed') {
            const item = button.closest('.favorites__item');
            item.remove();
            
            const remainingItems = document.querySelectorAll('.favorites__item');
            if (remainingItems.length === 0) {
                const favoritesContainer = document.getElementById('favorites-container');
                favoritesContainer.innerHTML = `
                    <div class="favorites__empty">
                        У вас пока нет избранных товаров
                    </div>
                `;
            }
        }
    });
}
</script>
@endpush
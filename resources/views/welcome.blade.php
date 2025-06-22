@extends('layouts.app')

@push('head')
    @vite(['resources/css/welcome.css'])
@endpush

@section('content')
<section class="hero-section">
    <div class="hero-container">
        <div class="hero-text">
            <h1 class="hero-title">Добро пожаловать<br>в <span>DigitalZone</span></h1>
            <p class="hero-subtitle">Откройте для себя мир высококачественных компьютерных девайсов и аксессуаров.</p>
            <div class="hero-features">
                <div class="feature-item">
                    <i class="fa-solid fa-truck-fast"></i>
                    <span>Быстрая доставка</span>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-shield-halved"></i>
                    <span>Гарантия качества</span>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-credit-card"></i>
                    <span>Удобная оплата</span>
                </div>
                <div class="feature-item">
                    <i class="fa-solid fa-headset"></i>
                    <span>Поддержка 24/7</span>
                </div>
            </div>
            <div class="hero-buttons">
                <a href="{{ route('catalog') }}" class="hero-button primary-button">
                    <span>Перейти в каталог</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="{{ route('about') }}" class="hero-button secondary-button">О нас</a>
            </div>
        </div>
    </div>
</section>

<section class="features-section">
    <div class="hero-container">
        <h2 class="section-title">Почему выбирают нас</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-check"></i>
                </div>
                <h3 class="feature-title">Качество</h3>
                <p class="feature-text">Только проверенные бренды и надежные поставщики</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <h3 class="feature-title">Доставка</h3>
                <p class="feature-text">Быстрая доставка по всей России</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <h3 class="feature-title">Поддержка</h3>
                <p class="feature-text">Профессиональная консультация и помощь в выборе</p>
            </div>
        </div>
    </div>
</section>

<section class="novinki"> 
    <h1 class="nov__title">Новинки</h1> 
    <div class="nov__content"> 
        <div class="catalog__list"> 
            @if (count($newProducts) > 0) 
            @foreach ($newProducts as $product) 
            <a href="/product/{{ $product->id }}" class="catalog__item"> 
                <img src="{{ Vite::asset('resources/media/images/') . $product->img }}" alt="{{ $product->img }}" class="catalog__item-img" width="400px"> 
                <div class="catalog__item-info"> 
                    <div class="catalog__item-title mt-2">{{ $product->title }}</div> 
                    <div class="catalog__item-price mb-2">{{ $product->price }} ₽</div> 
                </div> 
            </a> 
            @endforeach 
            @else 
            <h3>Ничего не найдено</h3> 
            @endif 
        </div> 
    </div> 
</section>

<section class="popular"> 
    <h1 class="pop__title">Популярные товары</h1> 
    <div class="pop__content"> 
        <div class="catalog__list"> 
            @if (count($popularProducts) > 0) 
            @foreach ($popularProducts as $product) 
            <a href="/product/{{ $product->id }}" class="catalog__item"> 
                <img src="{{ Vite::asset('resources/media/images/') . $product->img }}" alt="{{ $product->img }}" class="catalog__item-img" width="400px"> 
                <div class="catalog__item-info"> 
                    <div class="catalog__item-title mt-2">{{ $product->title }}</div> 
                    <div class="catalog__item-price mb-2">{{ $product->price }} ₽</div> 
                </div> 
            </a> 
            @endforeach 
            @else 
            <h3>Ничего не найдено</h3> 
            @endif 
        </div> 
    </div> 
</section>

<section class="kateg">  
    <h1 class="kateg__title">Категории</h1>  
    <div class="categ__content">  
        <div class="row-categ">
            <a class="categ__link" href="{{ route('catalog', ['filter' => '1']) }}">  
                <div class="categ__card">  
                    <div class="categ__card-inner">
                        <img src="{{ Vite::asset('resources/media/images/mouse.svg') }}" alt="Мыши">  
                        <p class="categ__text">Мыши</p>
                    </div>  
                </div>  
            </a>  
            <a class="categ__link" href="{{ route('catalog', ['filter' => '2']) }}">  
                <div class="categ__card">  
                    <div class="categ__card-inner">
                        <img src="{{ Vite::asset('resources/media/images/keyboard.svg') }}" alt="Клавиатуры">  
                        <p class="categ__text">Клавиатуры</p>
                    </div>  
                </div>  
            </a>  
            <a class="categ__link" href="{{ route('catalog', ['filter' => '3']) }}">  
                <div class="categ__card">  
                    <div class="categ__card-inner">
                        <img src="{{ Vite::asset('resources/media/images/headphones.svg') }}" alt="Наушники">  
                        <p class="categ__text">Наушники</p>
                    </div>  
                </div>  
            </a>  
        </div>
        <div class="row-categ">
            <a class="categ__link" href="{{ route('catalog', ['filter' => '4']) }}">  
                <div class="categ__card">  
                    <div class="categ__card-inner">
                        <img src="{{ Vite::asset('resources/media/images/microphone.svg') }}" alt="Микрофоны">  
                        <p class="categ__text">Микрофоны</p>
                    </div>  
                </div>  
            </a>  
            <a class="categ__link" href="{{ route('catalog', ['filter' => '5']) }}">  
                <div class="categ__card">  
                    <div class="categ__card-inner">
                        <img src="{{ Vite::asset('resources/media/images/gamepad.svg') }}" alt="Геймпады">  
                        <p class="categ__text">Геймпады</p>
                    </div>  
                </div>  
            </a>  
        </div>
    </div>  
</section>
@endsection

@extends('layouts.app')
@section('content')
<section class="about-section">
    <div class="about-container">
        <div class="about-header">
            <div class="about-content">
                <h1 class="gradient-title">О нас</h1>
                <p class="about-text">
                    <span class="highlight">DigitalZone</span> — ваш надежный онлайн-центр для покупки самых современных компьютерных девайсов и аксессуаров! Мы предлагаем широкий ассортимент продукции, включая геймпады, периферийные устройства и многое другое. В <span class="highlight">DigitalZone</span> мы стремимся предоставить нашим клиентам только лучшие товары от ведущих мировых брендов.
                </p>
            </div>
            <div class="about-image">
                <div class="image-wrapper">
                    <img src="{{ Vite::asset('resources/media/images/aboutBann.png') }}" alt="DigitalZone">
                    <div class="image-overlay"></div>
                </div>
            </div>
        </div>

        <section class="about-features">
            <h2 class="about-features__title">В нашем магазине вы найдете:</h2>
            <div class="about-features__grid">
                <div class="about-features__card">
                    <div class="about-features__icon">
                        <i class="fa-solid fa-tower-broadcast"></i>
                    </div>
                    <h3 class="about-features__card-title">Оборудование для стриминга</h3>
                    <p class="about-features__text">Девайсы для тех, кто хочет делиться своими игровыми моментами с миром.</p>
                </div>
                <div class="about-features__card">
                    <div class="about-features__icon">
                        <i class="fa-solid fa-keyboard"></i>
                    </div>
                    <h3 class="about-features__card-title">Аксессуары</h3>
                    <p class="about-features__text">Мыши, клавиатуры и многое другое — все, что нужно для комфортной игры и работы.</p>
                </div>
            </div>
        </section>

        <div class="advantages-section">
            <h2 class="gradient-title">Почему выбирают DigitalZone?</h2>
            <div class="advantages-grid">
                <div class="advantage-card">
                    <div class="advantage-icon">
                        <img src="{{ Vite::asset('resources/media/images/quality.svg') }}" alt="Качество">
                    </div>
                    <h3 class="advantage-title">Качество и надежность</h3>
                </div>
                <div class="advantage-card">
                    <div class="advantage-icon">
                        <img src="{{ Vite::asset('resources/media/images/dollar-symbol.svg') }}" alt="Цены">
                    </div>
                    <h3 class="advantage-title">Конкурентные цены</h3>
                </div>
                <div class="advantage-card">
                    <div class="advantage-icon">
                        <img src="{{ Vite::asset('resources/media/images/support.svg') }}" alt="Поддержка">
                    </div>
                    <h3 class="advantage-title">Быстрая поддержка</h3>
                </div>
                <div class="advantage-card">
                    <div class="advantage-icon">
                        <img src="{{ Vite::asset('resources/media/images/fast-delivery.svg') }}" alt="Доставка">
                    </div>
                    <h3 class="advantage-title">Удобная доставка</h3>
                </div>
            </div>
        </div>

        <div class="reviews-section">
            <h2 class="gradient-title">Более 10000 тыс. отзывов</h2>
            <div class="reviews-slider">
                <div id="reviewsCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="reviews-grid">
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="review-avatar">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <h3 class="review-name">Иван С.</h3>
                                    </div>
                                    <p class="review-text">Купил игровую мышь в DigitalZone, и это было отличное решение! Удобная форма, высокая чувствительность и стильный дизайн.</p>
                                </div>
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="review-avatar">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <h3 class="review-name">Алексей П.</h3>
                                    </div>
                                    <p class="review-text">Приобрел наушники в DigitalZone, и не пожалел ни разу! Отличное качество звука, удобные амбушюры и стильный внешний вид.</p>
                                </div>
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="review-avatar">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <h3 class="review-name">Светлана Р.</h3>
                                    </div>
                                    <p class="review-text">Клавиатура, которую купила в вашем магазине, просто шикарная! Механические клавиши и подсветка делают игру намного приятнее.</p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="reviews-grid">
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="review-avatar">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <h3 class="review-name">Михаил К.</h3>
                                    </div>
                                    <p class="review-text">Отличные наушники! Купил беспроводные игровые наушники, звук просто потрясающий! Теперь полностью погружаюсь в игровой процесс!</p>
                                </div>
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="review-avatar">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <h3 class="review-name">Анна В.</h3>
                                    </div>
                                    <p class="review-text">Заказывала микрофон для записи подкастов, очень довольна качеством звука! Четкий, чистый, без помех. Спасибо за быструю доставку!</p>
                                </div>
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="review-avatar">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <h3 class="review-name">Дмитрий Н.</h3>
                                    </div>
                                    <p class="review-text">Мышь - просто огонь! Купил беспроводную игровую мышь с регулируемым DPI, теперь все мои движения четкие и плавные! Спасибо!</p>
                                </div>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <div class="reviews-grid">
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="review-avatar">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <h3 class="review-name">Ольга М.</h3>
                                    </div>
                                    <p class="review-text">Брала микрофон для стримов, звук чистый и качественный. Рекомендую всем начинающим стримерам!</p>
                                </div>
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="review-avatar">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <h3 class="review-name">Артём Л.</h3>
                                    </div>
                                    <p class="review-text">Геймпад работает отлично, никаких задержек. Идеально подходит для любых игр, особенно файтингов.</p>
                                </div>
                                <div class="review-card">
                                    <div class="review-header">
                                        <div class="review-avatar">
                                            <i class="fa-solid fa-user"></i>
                                        </div>
                                        <h3 class="review-name">Елена Т.</h3>
                                    </div>
                                    <p class="review-text">Очень довольна покупкой механической клавиатуры. Переключатели именно такие, как я хотела!</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
</body>

</html>

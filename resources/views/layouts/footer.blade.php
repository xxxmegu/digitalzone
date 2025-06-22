<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="footer__content col-md-12">
                <div class="foot__one">
                    <div class="foot__kop">
                        <img src="{{ Vite::asset('resources/media/images/logos.svg')}}" alt="">
                        <h1 class="foot__copyright">© DigitalZone 2025</h1>
                    </div>
                    <div class="foot__ssil">
                        <h1 class="foot__zag">DigitalZone</h1>
                        <a class="nav-link {{ Request::is('glav') ? 'active' : '' }}" href="{{ route('glav') }}">
                            <i class="bi bi-house"></i>
                            <span>Главная</span>
                        </a>
                        <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ route('about') }}">
                            <i class="bi bi-info-circle"></i>
                            <span>О нас</span>
                        </a>
                        <a class="nav-link {{ Request::is('where') ? 'active' : '' }}" href="{{ route('where') }}">
                            <i class="bi bi-geo-alt"></i>
                            <span>Где нас найти?</span>
                        </a>
                    </div> 
                    <div class="foot__ssil">
                        <h1 class="foot__zag">Покупателю</h1>
                        <a class="nav-link {{ Request::is('catalog') ? 'active' : '' }}" href="{{ route('catalog') }}">
                            <i class="bi bi-grid"></i>
                            <span>Каталог</span>
                        </a>
                        @guest
                        <a class="nav-link {{ Request::is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i>
                            <span>Вход</span>
                        </a>
                        <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i>
                            <span>Регистрация</span>
                        </a>
                        @endguest
                       @auth
                       <a class="nav-link {{ Request::is('user') ? 'active' : '' }}" href="{{ route('user') }}">
                            <i class="bi bi-person"></i>
                            <span>Профиль</span>
                       </a>
                       <a class="nav-link {{ Request::is('cart') ? 'active' : '' }}" href="{{ route('cart') }}">
                            <i class="bi bi-cart"></i>
                            <span>Корзина</span>
                       </a>
                       @endauth
                    </div> 
                </div>
                <div class="foot__two">
                    <h1 class="foot__kont">Контакты</h1>
                    <div class="social">
                        <a href="https://vk.com" target="_blank"><img src="{{ Vite::asset('resources/media/images/vk.svg') }}" alt="VK" style="width:40px;height:40px;"></a>
                        <a href="https://t.me" target="_blank"><img src="{{ Vite::asset('resources/media/images/telegram.svg') }}" alt="Telegram" style="width:40px;height:40px;"></a>
                        <a href="https://dzen.ru" target="_blank"><img src="{{ Vite::asset('resources/media/images/dzen.svg') }}" alt="Dzen" style="width:40px;height:40px;"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

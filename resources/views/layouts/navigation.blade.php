<nav class="navbar navbar-expand-lg" data-bs-theme="dark">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="{{ Vite::asset('resources/media/images/logos.svg')}}" width="70" alt=""></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2s mb-lg-0">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('/', 'glav') ? 'active' : '' }}" href="{{ route('glav') }}">
              <i class="bi bi-house"></i>
              <span>Главная</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ route('about') }}">
              <i class="bi bi-info-circle"></i>
              <span>О нас</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('catalog') ? 'active' : '' }}" href="{{ route('catalog') }}">
              <i class="bi bi-grid"></i>
              <span>Каталог</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('where') ? 'active' : '' }}" href="{{ route('where') }}">
              <i class="bi bi-geo-alt"></i>
              <span>Где нас найти?</span>
            </a>
          </li>
        </ul>
        @guest
        <div class="user-nav">   
         <a class="nav-link {{ Request::is('register') ? 'active' : '' }}" href="{{ route('register') }}">
             <i class="bi bi-person-plus"></i>
             <span>Регистрация</span>
         </a> 
         <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="{{ route('login') }}">
             <i class="bi bi-box-arrow-in-right"></i>
             <span>Вход</span>
         </a>  
     </div>
     @endguest
     @auth
     <div class="user-nav">
         <a class="nav-link {{ Request::is('user') ? 'active' : '' }}" href="{{ route('user') }}">
             <i class="bi bi-person"></i>
         </a>
         <a class="nav-link {{ Request::is('favorites') ? 'active' : '' }}" href="{{ route('favorites') }}">
             <i class="bi bi-heart"></i>
         </a>
         <a class="nav-link {{ Request::is('cart') ? 'active' : '' }}" href="{{ route('cart') }}">
             <i class="bi bi-cart"></i>
             <span class="cart-counter">
                 @auth
                     {{ \Illuminate\Support\Facades\DB::table('cart')->where('uid', Auth::id())->count() }}
                 @else
                     {{ session()->has('cart') ? count(session('cart')) : 0 }}
                 @endauth
             </span>
         </a>
     </div>
 @endauth
      </div>
    </div>
  </nav>
  <div class="offcanvas offcanvas-top h-100 d-lg-none" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasTopLabel">
            <img src="{{ Vite::asset('resources/media/images/logoDigital.svg')}}" width="80" alt="Logo">
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav w-100">
            <li class="nav-item w-100">
                <a class="nav-link {{ Request::is('/', 'glav') ? 'active' : '' }}" href="{{ route('glav') }}">
                    <i class="bi bi-house"></i>
                    <span>Главная</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ route('about') }}">
                    <i class="bi bi-info-circle"></i>
                    <span>О нас</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a class="nav-link {{ Request::is('catalog') ? 'active' : '' }}" href="{{ route('catalog') }}">
                    <i class="bi bi-grid"></i>
                    <span>Каталог</span>
                </a>
            </li>
            <li class="nav-item w-100">
                <a class="nav-link {{ Request::is('where') ? 'active' : '' }}" href="{{ route('where') }}">
                    <i class="bi bi-geo-alt"></i>
                    <span>Где нас найти?</span>
                </a>
            </li>
        </ul>
        @guest
            <div class="navbar-nav mt-4 w-100">   
                <a class="nav-link {{ Request::is('register') ? 'active' : '' }}" href="{{ route('register') }}">
                    <i class="bi bi-person-plus"></i>
                    <span>Регистрация</span>
                </a>
                <a class="nav-link {{ Request::is('login') ? 'active' : '' }}" href="{{ route('login') }}">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Вход</span>
                </a>
            </div>
        @endguest
        @auth
            <div class="navbar-nav mt-4 w-100">
                <a class="nav-link {{ Request::is('user') ? 'active' : '' }}" href="{{ route('user') }}">
                    <i class="bi bi-person"></i>
                    <span>Профиль</span>
                </a>
                <a class="nav-link {{ Request::is('favorites') ? 'active' : '' }}" href="{{ route('favorites') }}">
                    <i class="bi bi-heart"></i>
                    <span>Избранное</span>
                </a>
                <a class="nav-link {{ Request::is('cart') ? 'active' : '' }}" href="{{ route('cart') }}">
                    <i class="bi bi-cart"></i>
                    <span class="cart-counter">
                        @auth
                            {{ \Illuminate\Support\Facades\DB::table('cart')->where('uid', Auth::id())->count() }}
                        @else
                            {{ session()->has('cart') ? count(session('cart')) : 0 }}
                        @endauth
                    </span>
                </a>
            </div>
        @endauth
    </div>
  </div>



@auth
    @if (Auth::user()->is_admin === 1)
    <nav class="navbar navbar-expand-lg admin-navbar">
        <div class="container">
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar"
                aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="adminNavbar">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a href="/product-create" class="nav-link {{ Request::is('product-create') ? 'active' : '' }}">
                            <i class="bi bi-plus-circle"></i>Создать товар
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/products" class="nav-link {{ Request::is('products') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i>Управление товарами
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/category-create" class="nav-link {{ Request::is('category-create') ? 'active' : '' }}">
                            <i class="bi bi-folder-plus"></i>Создать категорию
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/categories" class="nav-link {{ Request::is('categories') ? 'active' : '' }}">
                            <i class="bi bi-folder"></i>Управление категориями
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="/orders" class="nav-link {{ Request::is('orders') ? 'active' : '' }}">
                            <i class="bi bi-cart-check"></i>Управление заказами
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    @endif
@endauth



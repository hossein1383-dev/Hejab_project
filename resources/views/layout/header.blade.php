<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> @yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    {{-- <script defer src="{{ asset('js/alpine.js') }}"></script> --}}


    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    @yield('link')

</head>

<body>
    <div class="{{ request()->is('/') ? '' : 'sub_page' }}">
        <div class="hero_area">

            @if (request()->is('/'))
                <div class="bg-box">
                    <img src="{{ asset('/images/hijab2.bg.jpg') }}" alt="">
                </div>
            @endif

            <!-- header section strats -->
            <header class="hh-header fixed-top bg-white">
                <div class="container">
                    <nav class="navbar navbar-light py-3 my-navbar">

                        <!-- Sidebar Toggler (Right) -->
                        <div class="d-flex justify-content-end">
                            <button class="menu-toggle" type="button" data-bs-toggle="offcanvas"
                                data-bs-target="#sidebar" aria-controls="sidebar">
                                <i class="bi bi-list"></i>
                            </button>
                        </div>


                        <!-- Logo (Center) -->
                        <a class="navbar-brand mx-auto fw-bold mt-2" href="{{ route('index') }}">
                            MORVARID HEJAB
                        </a>

                        <!-- Icons (Left) -->
                        <div class="d-flex align-items-center gap-1">

                            <!-- سبد خرید با استایل مدرن -->
                            <a href="{{ route('cart_index') }}" class="cart-icon">
                                <i class="bi bi-cart-fill"></i>

                                <span id="cart-count" class="cart-badge">
                                    {{ collect(session('cart', []))->sum('qty') }}
                                </span>
                            </a>
                            @auth
                                <a href="{{ route('index_profile') }}"
                                    class="btn btn-outline-dark btn-sm rounded-pill px-3 login-btn">
                                    پروفایل
                                </a>
                            @endauth

                            @guest
                                <a href="{{ route('login_form') }}"
                                    class="btn btn-outline-dark btn-sm rounded-pill px-3 login-btn">
                                    ورود
                                </a>
                            @endguest
                            <!-- دکمه ورود حرفه‌ای -->
                        </div>

                    </nav>
                </div>
            </header>

            <!-- Spacer for fixed header -->
            <div style="height: 80px;"></div>

            <!-- Offcanvas Sidebar -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="sidebarLabel">منو</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="بستن"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                                href="{{ route('index') }}">خانه</a>
                        </li>
                        <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('product_menu') }}">محصولات</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                                href="{{ route('about') }}">درباره ما</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('contact*') ? 'active' : '' }}"
                                href="{{ route('contact_index') }}">تماس</a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- end header section -->
            @if (request()->is('/'))
                @include('home.slider')
            @endif
        </div>
    </div>

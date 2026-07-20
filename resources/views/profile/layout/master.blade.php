<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @yield('link')
    @yield('script')

</head>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>

<body>
    @include('partials.sweetalert')
    @section('title', 'Profile Page')
    <!-- فاصله برای هدر fixed -->
    <section class="profile_section layout_padding">
        <div class="container">
            <div class="row">
                @yield('main')
            </div>
        </div>
    </section>
    <!-- HEADER -->
    <!-- header section strats -->
    <header class="hh-header fixed-top bg-white">
        <div class="container">
            <nav class="navbar navbar-light py-3 my-navbar">

                <!-- Sidebar Toggler (Right) -->
                <div class="d-flex justify-content-end">
                    <button class="menu-toggle" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar"
                        aria-controls="sidebar">
                        <i class="bi bi-list"></i>
                    </button>
                </div>


                <!-- Logo (Center) -->
                <a class="navbar-brand mx-auto fw-bold mt-2" href="{{ route('index') }}">
                    MORVARID HEJAB
                </a>

                <!-- Icons (Left) -->
                <div class="d-flex align-items-center">

                    <!-- سبد خرید با استایل مدرن -->
                    <a href="{{ route('cart_index') }}" class="cart-icon">
                        <i class="bi bi-cart-fill"></i>

                        <span id="cart-count" class="cart-badge">
                            {{ collect(session('cart', []))->sum('qty') }}
                        </span>
                    </a>
                    @auth
                        <a href="{{ route('index') }}" class="cart-icon">
                            <i class="bi bi-house-fill"></i>
                        </a>
                    @endauth

                    @guest
                        <a href="{{ route('login_form') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3 login-btn">
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
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="بستن"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('index_profile') }}">
                        اطلاعات کاربر
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('addresses') }}">
                        آدرس‌ها
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile_orders') }}">
                        سفارشات
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('profile_transactions') }}">
                        تراکنش‌ها
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}">
                        خروج
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <style>
        /* جلوگیری از افتادن محتوا زیر هدر */
        body {
            padding-top: 80px;
        }

        .sidebar-links a {
            color: #212121;
            text-decoration: none;
            transition: .3s;
        }

        .sidebar-links a:hover {
            color: #050033;
        }

        .sidebar-links a:visited,
        .sidebar-links a:active {
            color: #212121;
        }

        .my-icon {
            padding: 0;
        }

        @media(max-width:768px) {

            body {
                padding-top: 90px;
            }
        }
    </style>
</body>

</html>

<!DOCTYPE html>
<html lang="en" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> @yield('title')</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.rtl.min.css"
        integrity="sha384-+qdLaIRZfNu4cVPK/PxJJEy0B0f3Ugv8i482AKY7gwXwhaCroABd086ybrVKTa0q" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('link')
    @yield('script')

</head>


<body>
    @include('partials.sweetalert')
    @section('title', 'Profile Page')


    <section class="profile_section layout_padding">
        <div class="container">
            <div class="row">

                @yield('main')
            </div>
        </div>
    </section>
    <header class="hh-header fixed-top bg-white shadow-sm">
        <div class="container">
            <nav class="navbar navbar-light py-3 position-relative">

                <!-- دکمه منو موبایل -->
                <div x-data="{ openSidebar: false }">

                    <button @click="openSidebar = true"
                        class="d-lg-none d-flex justify-content-center align-items-center pt-1"
                        style="
                        width:40px;
                        height:40px;
                        border-radius:50%;
                        background:#050033;
                        border:none;
                        color:#fff;
                        font-size:20px;
                    ">
                        ☰
                    </button>

                    <!-- بک گراند تار -->
                    <div x-show="openSidebar" x-transition.opacity @click="openSidebar = false"
                        class="position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50" style="z-index:1050;">
                    </div>

                    <!-- سایدبار موبایل -->
                    <div x-show="openSidebar" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
                        x-transition:leave-end="translate-x-full" class="position-fixed bg-white shadow"
                        style="
                        top:0;
                        right:0;
                        width:250px;
                        height:100vh;
                        z-index:1100;
                        overflow-y:auto;
                    ">

                        <div class="p-3 border-bottom d-flex justify-content-between">
                            <strong>حساب کاربری</strong>
                            <span @click="openSidebar = false" style="cursor:pointer">✕</span>
                        </div>

                        <ul class="list-group list-group-flush sidebar-links">
                            <li class="list-group-item"><a href="#">اطلاعات کاربر</a></li>
                            <li class="list-group-item"><a href="{{ route('addresses') }}">آدرس‌ها</a></li>
                            <li class="list-group-item"><a href="#">سفارشات</a></li>
                            <li class="list-group-item"><a href="#">تراکنش‌ها</a></li>
                            {{-- <li class="list-group-item"><a href="#">علاقه‌مندی‌ها</a></li> --}}
                            <li class="list-group-item"><a href="{{ route('logout') }}">خروج</a></li>
                        </ul>

                    </div>
                </div>

                <!-- لوگو -->
                <a class="navbar-brand mx-auto fw-bold me-2 ms-1 mt-2" href="{{ route('index') }}">
                    MORVARID HIJAB
                </a>

                <!-- آیکن‌ها -->
                <div class="d-flex align-items-center gap-1">

                    <a href="{{ route('cart_index') }}" class="cart-icon text-dark position-relative">
                        <i class="bi bi-cart-fill fs-5"></i>
                        <span id="cart-count" class="cart-badge">
                            {{ collect(session('cart', []))->sum('qty') }}
                        </span>
                    </a>

                    @auth
                        <a href="{{ route('index') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                            صفحه اصلی
                        </a>
                    @endauth

                    @guest
                        <a href="{{ route('login_form') }}" class="btn btn-outline-dark btn-sm rounded-pill px-3">
                            ورود
                        </a>
                    @endguest

                </div>

            </nav>
        </div>
    </header>

    <style>
        /* لینک‌های داخل سایدبار موبایل */
        .sidebar-links a {
            color: #212121;
            /* رنگ ثابت مشکی-تیره */
            text-decoration: none;
            transition: color 0.3s;
        }

        /* رنگ هنگام hover */
        .sidebar-links a:hover {
            color: #050033;
            /* رنگ برند شما مثلاً سرمه‌ای */
        }

        /* جلوگیری از تغییر رنگ پس از کلیک */
        .sidebar-links a:visited,
        .sidebar-links a:active {
            color: #212121;
        }

        .my-icon {
            padding: px
        }
    </style>


    <div style="height:80px"></div>
</body>

</html>

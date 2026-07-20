    <div class="container py-5">
        {{-- راه حل شماره ۱: استفاده از row-cols-3 (پیشنهاد من) --}}
        <div class="row row-cols-3 g-3"> {{-- g-3 برای فاصله‌ی بین باکس‌ها --}}

            {{-- باکس شماره ۱ --}}
            <div class="col">
                <a href="{{ route('chador') }}" class="text-decoration-none d-block h-100">
                    <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm hover-effect">
                        <img src="{{ asset('/images/chador_vactor.jpg') }}" class="card-img-top img-fluid" alt="وکتور چادر"
                            style="object-fit: cover; height: 200px; width: 100%;">

                        {{-- در صورت نیاز می‌توانید زیر تصویر توضیح کوتاهی هم اضافه کنید --}}
                        <div class="card-footer text-center bg-transparent border-0 small">چادر</div>
                    </div>
                </a>
            </div>
            {{-- باکس شماره ۲ --}}
            <div class="col">
                <a href="{{ route('aba') }}" class="text-decoration-none d-block h-100">
                    <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm hover-effect">
                        <img src="{{ asset('/images/rosary_vactor.jpg') }}" class="card-img-top img-fluid"
                            alt="وکتور چادر" style="object-fit: cover; height: 200px; width: 100%;">
                        <div class="card-footer text-center bg-transparent border-0 small">روسری</div>
                    </div>
                </a>
            </div>
            {{-- باکس شماره ۳ --}}
            <div class="col">
                <a href="{{ route('rosary') }}" class="text-decoration-none d-block h-100">
                    <div class="card h-100 border-0 rounded-4 overflow-hidden shadow-sm hover-effect">
                        <img src="{{ asset('/images/aba_vactor.jpg') }}" class="card-img-top img-fluid" alt="وکتور چادر"
                            style="object-fit: cover; height: 200px; width: 100%;">
                        <div class="card-footer text-center bg-transparent border-0 small">عبا</div>
                    </div>

                </a>
            </div>
        </div>
    </div>

    {{-- افکت هاور (اختیاری) --}}
    <style>
        .hover-effect {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background: #ffffff;
        }

        .hover-effect:hover {
            transform: scale(1.02);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.10) !important;
        }

        a {
            color: inherit;
        }

        /* در گوشی‌های خیلی باریک (مثلاً ۳۲۰px) اگر نوشته‌ها اذیت کردند، اندازه‌ی فونت را کم کنیم */
        @media (max-width: 400px) {
            .card-body i {
                font-size: 2.2rem !important;
            }

            .card-title {
                font-size: 0.7rem !important;
            }

            .small {
                font-size: 0.6rem !important;
            }
        }
    </style>

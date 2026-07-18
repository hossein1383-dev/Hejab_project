@include('layout.header')

@yield('content')

@include('layout.footer')
@include('partials.sweetalert')

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {

        // بررسی اینکه آیا قبلاً در این جلسه (مرورگر) خوش‌آمدگویی نمایش داده شده؟
        if (sessionStorage.getItem('welcome_shown')) {
            return; // اگر نمایش داده شده، هیچ کاری نکن
        }

        // ۱. نمایش مودال خوش‌آمدگویی با SweetAlert2
        Swal.fire({
            title: '✨ به سایت ما خوش آمدید!',
            text: 'از حضور گرم شما سپاسگزاریم. لحظات خوشی را برای شما آرزومندیم.',
            icon: 'success',
            iconColor: '#ff6b6b',
            confirmButtonText: '🚀 شروع کنید',
            confirmButtonColor: '#6c5ce7',
            backdrop: 'rgba(0,0,0,0.6)',
            background: 'linear-gradient(135deg, #fdfcfb 0%, #e2d1c3 100%)',
            showClass: {
                popup: 'animate__animated animate__fadeInDown' // در صورت استفاده از Animate.css
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            },
            customClass: {
                popup: 'welcome-modal',
                title: 'welcome-title',
                confirmButton: 'welcome-btn'
            },
            // تایپ‌رایتر برای متن (با استفاده از تابع سفارشی در didOpen)
            didOpen: () => {
                const textEl = document.querySelector('.swal2-html-container');
                if (textEl) {
                    // متن را خالی می‌کنیم و با تایپ‌رایتر نمایش می‌دهیم
                    const fullText = textEl.innerText;
                    textEl.innerText = '';
                    let index = 0;
                    const typeInterval = setInterval(() => {
                        if (index < fullText.length) {
                            textEl.innerText += fullText.charAt(index);
                            index++;
                        } else {
                            clearInterval(typeInterval);
                        }
                    }, 30);
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // ۲. بعد از کلیک روی دکمه، انفجار کانفتی!
                confetti({
                    particleCount: 150,
                    spread: 70,
                    origin: {
                        y: 0.6
                    },
                    colors: ['#ff6b6b', '#feca57', '#48dbfb', '#ff9ff3', '#54a0ff']
                });

                // یک کانفتی دیگر با تاخیر
                setTimeout(() => {
                    confetti({
                        particleCount: 100,
                        spread: 100,
                        origin: {
                            y: 0.5,
                            x: 0.3
                        },
                        colors: ['#ff9f43', '#00d2d3', '#ee5a24', '#f368e0']
                    });
                }, 200);

                // همچنین می‌توانید افکت‌های صوتی یا تغییرات دیگر اضافه کنید
            }
        });

        // ثبت در sessionStorage تا دیگر نمایش داده نشود
        sessionStorage.setItem('welcome_shown', 'true');

    });
</script>

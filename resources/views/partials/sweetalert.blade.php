<style>
    @media (max-width: 768px) {
        .colored-toast.swal2-toast {
            width: 90% !important;
            margin-bottom: 20px !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const isMobile = window.innerWidth <= 768;

        const Toast = Swal.mixin({
            toast: true,
            position: isMobile ? 'bottom' : 'top-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
                icon: 'swal2-icon-custom' // کلاس اضافی برای آیکون
            },
            showConfirmButton: false,
            timer: 3500, // اندکی بیشتر برای لذت بردن از انیمیشن
            timerProgressBar: true,
            background: 'transparent', // پس‌زمینه شفاف (گرادیان در کلاس popup)
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            },
            // تنظیم انیمیشن‌های ورود و خروج
            showClass: {
                popup: 'swal2-show'
            },
            hideClass: {
                popup: 'swal2-hide'
            }
        });

        // تابع کمکی برای نمایش پیام با آیکون زیبا (اختیاری)
        function showToast(icon, title) {
            Toast.fire({
                icon: icon,
                title: title,
                // می‌توانید آیکون سفارشی با ایموجی یا SVG اضافه کنید:
                // iconHtml: '🎉'   // فقط برای حالت‌های خاص
            });
        }

        // پیام‌های Session لاراول
        @if (session('success'))
            showToast('success', @json(session('success')));
        @endif

        @if (session('error'))
            showToast('error', @json(session('error')));
        @endif

        @if (session('warning'))
            showToast('warning', @json(session('warning')));
        @endif

        @if (session('info'))
            showToast('info', @json(session('info')));
        @endif

        // Ajax افزودن به سبد خرید (بدون تغییر در منطق اصلی)
        document.addEventListener('click', function(e) {
            let btn = e.target.closest('.add-to-cart');
            if (!btn) return;
            e.preventDefault();

            fetch("{{ route('increment') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "X-Requested-With": "XMLHttpRequest"
                    },
                    body: JSON.stringify({
                        product_id: btn.dataset.productId,
                        qty: 1
                    })
                })
                .then(response => response.json())
                .then(data => {
                    showToast(data.success ? 'success' : 'error', data.message);
                    if (data.success) {
                        const cartCount = document.getElementById('cart-count');
                        if (cartCount && data.cart_count !== undefined) {
                            cartCount.innerText = data.cart_count;
                        }
                    }
                })
                .catch(error => {
                    console.error(error);
                    showToast('error', 'خطا در ارتباط با سرور');
                });
        });

    });
</script>

<style>
    /* استایل پایه برای Toast با ظاهری مدرن */
    .colored-toast.swal2-toast {
        border-radius: 16px !important;
        padding: 12px 20px !important;
        font-family: 'Vazir', 'Tahoma', sans-serif !important;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15), 0 6px 12px rgba(0, 0, 0, 0.05) !important;
        backdrop-filter: blur(8px) !important;
        -webkit-backdrop-filter: blur(8px) !important;
        border: 1px solid rgba(255, 255, 255, 0.2) !important;
        transition: transform 0.3s ease, opacity 0.3s ease !important;
    }

    /* انیمیشن ورود و خروج */
    .colored-toast.swal2-toast.swal2-show {
        animation: slideInRight 0.5s cubic-bezier(0.25, 0.46, 0.45, 0.94) both !important;
    }

    .colored-toast.swal2-toast.swal2-hide {
        animation: slideOutRight 0.4s cubic-bezier(0.55, 0.085, 0.68, 0.53) both !important;
    }

    @keyframes slideInRight {
        0% {
            transform: translateX(120%) scale(0.9);
            opacity: 0;
        }

        100% {
            transform: translateX(0) scale(1);
            opacity: 1;
        }
    }

    @keyframes slideOutRight {
        0% {
            transform: translateX(0) scale(1);
            opacity: 1;
        }

        100% {
            transform: translateX(120%) scale(0.9);
            opacity: 0;
        }
    }

    /* رنگ‌بندی اختصاصی برای هر نوع پیام */
    .colored-toast.swal2-toast.swal2-icon-success {
        background: linear-gradient(135deg, #00b09b, #96c93d) !important;
        color: #fff !important;
    }

    .colored-toast.swal2-toast.swal2-icon-error {
        background: linear-gradient(135deg, #f093fb, #f5576c) !important;
        color: #fff !important;
    }

    .colored-toast.swal2-toast.swal2-icon-warning {
        background: linear-gradient(135deg, #f6d365, #fda085) !important;
        color: #fff !important;
    }

    .colored-toast.swal2-toast.swal2-icon-info {
        background: linear-gradient(135deg, #4facfe, #00f2fe) !important;
        color: #fff !important;
    }

    /* تنظیمات آیکون‌ها (رنگ سفید و سایه‌دار) */
    .colored-toast.swal2-toast .swal2-icon {
        border-color: rgba(255, 255, 255, 0.6) !important;
        color: #fff !important;
    }

    .colored-toast.swal2-toast .swal2-icon-content {
        color: #fff !important;
    }

    /* استایل متن عنوان */
    .colored-toast.swal2-toast .swal2-title {
        font-weight: 600 !important;
        font-size: 1rem !important;
        letter-spacing: 0.3px !important;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1) !important;
        padding: 0 8px !important;
    }

    /* نوار پیشرفت (timerProgressBar) */
    .colored-toast.swal2-toast .swal2-timer-progress-bar {
        background: rgba(255, 255, 255, 0.5) !important;
        height: 3px !important;
    }

    /* تنظیمات ریسپانسیو برای موبایل */
    @media (max-width: 768px) {
        .colored-toast.swal2-toast {
            width: 92% !important;
            margin: 0 auto 20px !important;
            border-radius: 20px !important;
            padding: 14px 18px !important;
            font-size: 0.9rem !important;
        }

        .colored-toast.swal2-toast .swal2-title {
            font-size: 0.95rem !important;
        }
    }
</style>

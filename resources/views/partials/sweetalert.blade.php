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
                popup: 'colored-toast'
            },
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        // پیام‌های Session لاراول
        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: @json(session('success'))
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: @json(session('error'))
            });
        @endif

        @if (session('warning'))
            Toast.fire({
                icon: 'warning',
                title: @json(session('warning'))
            });
        @endif

        @if (session('info'))
            Toast.fire({
                icon: 'info',
                title: @json(session('info'))
            });
        @endif

        // Ajax افزودن به سبد خرید
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

                    Toast.fire({
                        icon: data.success ? 'success' : 'error',
                        title: data.message
                    });

                    if (data.success) {

                        const cartCount = document.getElementById('cart-count');

                        if (cartCount && data.cart_count !== undefined) {
                            cartCount.innerText = data.cart_count;
                        }

                    }

                })
                .catch(error => {

                    console.error(error);

                    Toast.fire({
                        icon: 'error',
                        title: 'خطا در ارتباط با سرور'
                    });

                });

        });

    });
</script>

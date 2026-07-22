@extends('layout.master')
@section('title', 'Cart Page')

@section('content')
    <div id="cart-container">
        @if ($cart == null || count($cart) == 0)
            <div class="cart-empty">
                <div class="text-center">
                    <div>
                        <i class="bi bi-basket-fill" style="font-size:80px"></i>
                    </div>
                    <h4 class="text-bold">سبد خرید شما خالی است</h4>
                    <a href="{{ route('index') }}" class="btn btn-outline-dark mt-3">
                        مشاهده محصولات
                    </a>
                </div>
            </div>
        @else
            <section class="single_page_section layout_padding">
                <div x-data="{ address_id: null }" class="container">
                    <div class="row">
                        <div class="col-12">

                            <!-- جدول در دسکتاپ / کارت در موبایل -->
                            <div class="d-none d-md-block mt-2">
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>محصول</th>
                                                <th>نام</th>
                                                <th>سایز</th>
                                                <th>قیمت</th>
                                                <th>تعداد</th>
                                                <th>قیمت کل</th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($cart as $key => $item)
                                                @php
                                                    $productId = $item['productId'];
                                                    $size = $item['size'] ?? null;
                                                    $hasSize = $item['has_size'] ?? false;
                                                    $price = $item['is_sale'] ? $item['sale_price'] : $item['price'];
                                                @endphp

                                                <tr class="cart-item" data-product-id="{{ $productId }}"
                                                    data-size="{{ $size }}">

                                                    <td width="120">
                                                        <img src="{{ imageUrl($item['primary_image']) }}"
                                                            class="img-fluid rounded" width="90">
                                                    </td>

                                                    <td>
                                                        <strong>{{ $item['name'] }}</strong>
                                                    </td>

                                                    <td>
                                                        @if ($hasSize && !empty($size))
                                                            {{ $size }}
                                                        @else
                                                            -
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($item['is_sale'])
                                                            <div class="text-danger small mb-1">
                                                                {{ salePercent($item['price'], $item['sale_price']) }}٪
                                                                تخفیف
                                                            </div>

                                                            <del class="text-muted">
                                                                {{ number_format($item['price']) }}
                                                            </del>

                                                            <br>

                                                            <strong>
                                                                {{ number_format($item['sale_price']) }} تومان
                                                            </strong>
                                                        @else
                                                            <strong>
                                                                {{ number_format($item['price']) }} تومان
                                                            </strong>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        <div class="input-counter">
                                                            <a href="#" class="plus-btn"
                                                                data-product-id="{{ $productId }}"
                                                                data-size="{{ $size }}">
                                                                +
                                                            </a>

                                                            <div class="input-number">
                                                                {{ $item['qty'] }}
                                                            </div>

                                                            <a href="#" class="minus-btn"
                                                                data-product-id="{{ $productId }}"
                                                                data-size="{{ $size }}">
                                                                -
                                                            </a>
                                                        </div>
                                                    </td>

                                                    <td>
                                                        <strong class="item-total-price">
                                                            {{ number_format($item['qty'] * $price) }}
                                                        </strong>
                                                        تومان
                                                    </td>

                                                    <td class="text-center">
                                                        <a href="#" class="remove-item"
                                                            data-product-id="{{ $productId }}"
                                                            data-size="{{ $size }}">
                                                            <i class="bi bi-x text-danger fs-4"></i>
                                                        </a>
                                                    </td>

                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>

                            <!-- نسخه کارت برای موبایل -->
                            <div class="d-md-none">
                                @foreach ($cart as $key => $item)
                                    @php
                                        $productId = $item['productId'];
                                        $size = $item['size'] ?? null;
                                        $hasSize = $item['has_size'] ?? false;
                                        $price = $item['is_sale'] ? $item['sale_price'] : $item['price'];
                                    @endphp
                                    <div class="card mb-3 p-3 shadow-sm cart-item" data-product-id="{{ $productId }}"
                                        data-size="{{ $size }}">

                                        <div class="d-flex gap-3">
                                            <img src="{{ imageUrl($item['primary_image']) }}" class="rounded"
                                                width="90">
                                            <div>
                                                <div class="fw-bold mb-2">{{ $item['name'] }}</div>
                                                @if (!empty($size))
                                                    <div class="fw-bold mb-2">سایز: {{ $size }}</div>
                                                @endif
                                                @php $price = $item['is_sale'] ? $item['sale_price'] : $item['price']; @endphp

                                                @if ($item['is_sale'])
                                                    <div class="text-danger small">
                                                        {{ salePercent($item['price'], $item['sale_price']) }}% تخفیف
                                                    </div>
                                                    <div class="small">
                                                        <del>{{ number_format($item['price']) }}</del>
                                                        <span class="fw-bold">{{ number_format($item['sale_price']) }}
                                                            تومان</span>
                                                    </div>
                                                @else
                                                    <div class="small fw-bold">
                                                        {{ number_format($item['price']) }} تومان
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <hr>

                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="input-counter">
                                                <a href="#" class="plus-btn" data-product-id="{{ $productId }}"
                                                    data-size="{{ $size }}">+</a>

                                                <div class="input-number">{{ $item['qty'] }}</div>

                                                <a href="#" class="minus-btn" data-product-id="{{ $productId }}"
                                                    data-size="{{ $size }}">-</a>
                                            </div>

                                            <div class="fw-bold">
                                                <span class="item-total-price">
                                                    {{ number_format($item['qty'] * $price) }}
                                                </span>
                                                <span>تومان</span>
                                            </div>
                                            <a href="#" class="remove-item" data-product-id="{{ $productId }}"
                                                data-size="{{ $size }}">
                                                <i class="bi bi-x text-danger fw-bold fs-4 cursor-pointer"></i>
                                            </a>
                                        </div>

                                    </div>
                                @endforeach
                            </div>

                            <a class="btn btn-danger w-100 mb-4" href="{{ route('cart_clear') }}">پاک کردن سبد خرید</a>

                        </div>
                    </div>

                    <hr>

                    <!-- بخش آدرس و کد تخفیف -->
                    <div class="row gy-3 mt-3">

                        <div class="col-12 col-md-8 col-lg-6">
                            <div
                                class="d-flex flex-column flex-md-row-reverse align-items-stretch align-items-md-center gap-3">

                                <div class="w-100 w-md-auto">
                                    <a href="{{ route('addresses_create') }}" class="btn btn-primary w-100 text-nowrap">
                                        افزودن آدرس
                                    </a>
                                </div>

                                <div class="flex-grow-1">
                                    @if (isset($addresses) && $addresses->isNotEmpty())
                                        <select class="form-select w-100" x-model="address_id">
                                            <option value="">انتخاب آدرس</option>
                                            @foreach ($addresses as $address)
                                                <option value="{{ $address->id }}">
                                                    {{ Str::words($address->address, 3, '...') }}
                                                </option>
                                            @endforeach
                                        </select>

                                        <div class="form-text text-danger mt-1 small">
                                            @error('address_id')
                                                {{ $message }}
                                            @enderror
                                        </div>
                                    @else
                                        <button class="btn btn-outline-secondary w-100" disabled>
                                            آدرسی ثبت نشده است
                                        </button>
                                    @endif
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- جمع بندی -->
                    <div class="row justify-content-center mt-5">
                        <div class="col-12 col-md-6">
                            <div class="card shadow-sm">
                                <div class="card-body p-4">

                                    <h5 class="fw-bold text-center mb-3">مجموع سبد خرید</h5>

                                    <ul class="list-group mt-3">
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>مجموع قیمت: </span>
                                            <span id="cart-total">
                                                {{ number_format($totals['total_price'] ?? 0) }} تومان
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between">
                                            <span>تخفیف: <span class="text-danger" id="discount-percent">
                                                </span></span>
                                            <span class="text-danger" id="cart-discount-amount">
                                                {{ number_format($totals['total_discount'] ?? 0) }} تومان
                                            </span>
                                        </li>
                                        <li class="list-group-item d-flex justify-content-between fw-bold">
                                            <span>قیمت پرداختی:</span>
                                            <span id="cart-final">
                                                {{ number_format($totals['final_price'] ?? 0) }} تومان
                                            </span>
                                        </li>
                                    </ul>

                                    <form action="{{ route('payment_send') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="address_id" :value="address_id">
                                        <input type="hidden" name="size" value="{{ $size }}">
                                        <button type="submit" class="btn btn-primary w-100 mt-4">پرداخت</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        @endif
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // تابع کمکی برای به‌روزرسانی جمع کل
            function updateTotals(data) {
                const cartTotal = document.getElementById('cart-total');
                if (cartTotal) {
                    cartTotal.textContent = Number(data.total_price).toLocaleString('fa-IR') + ' تومان';
                }
                const discountAmount = document.getElementById('cart-discount-amount');
                if (discountAmount) {
                    discountAmount.textContent = Number(data.total_discount).toLocaleString('fa-IR') + ' تومان';
                }
                const finalPrice = document.getElementById('cart-final');
                if (finalPrice) {
                    finalPrice.textContent = Number(data.final_price).toLocaleString('fa-IR') + ' تومان';
                }
                // به‌روزرسانی تعداد در Badge (اگر در لایه‌بندی وجود دارد)
                document.querySelectorAll('.cart-badge').forEach(el => {
                    el.textContent = data.cart_count;
                });
            }

            // ---- افزایش ----
            document.querySelectorAll('.plus-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    const size = this.dataset.size || null; // ممکن است null باشد
                    fetch("{{ route('increment') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "X-Requested-With": "XMLHttpRequest"
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                size: size
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (!data.success) {
                                Toast.fire({
                                    icon: 'error',
                                    title: data.message
                                });
                                return;
                            }
                            // به‌روزرسانی سطر جاری
                            const row = this.closest('.cart-item');
                            row.querySelector('.input-number').textContent = data.qty;
                            const itemPrice = row.querySelector('.item-total-price');
                            if (itemPrice) {
                                itemPrice.textContent = Number(data.item_total).toLocaleString(
                                    'fa-IR');
                            }
                            // به‌روزرسانی جمع کل
                            updateTotals(data);
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Toast.fire({
                                icon: 'error',
                                title: 'خطا در ارتباط با سرور'
                            });
                        });
                });
            });

            // ---- کاهش ----
            document.querySelectorAll('.minus-btn').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;
                    const size = this.dataset.size || null;
                    fetch("{{ route('decrement') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "X-Requested-With": "XMLHttpRequest"
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                size: size
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (!data.success) {
                                Toast.fire({
                                    icon: 'error',
                                    title: data.message
                                });
                                return;
                            }

                            const row = this.closest('.cart-item');
                            if (data.removed) {
                                // حذف سطر از DOM
                                row.remove();
                                // اگر سبد خرید خالی شد، صفحه را ریلود کنید
                                if (data.cart_count === 0) {
                                    location.reload();
                                    return;
                                }
                            } else {
                                // به‌روزرسانی تعداد و قیمت سطر
                                row.querySelector('.input-number').textContent = data.qty;
                                const itemPrice = row.querySelector('.item-total-price');
                                if (itemPrice) {
                                    itemPrice.textContent = Number(data.item_total)
                                        .toLocaleString('fa-IR');
                                }
                            }
                            // به‌روزرسانی جمع کل
                            updateTotals(data);
                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Toast.fire({
                                icon: 'error',
                                title: 'خطا در ارتباط با سرور'
                            });
                        });
                });
            });
            // ---- حذف آیتم ----
            document.querySelectorAll('.remove-item').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();

                    const productId = this.dataset.productId;
                    const size = this.dataset.size || null;

                    fetch("{{ route('cart_remove') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "X-Requested-With": "XMLHttpRequest"
                            },
                            body: JSON.stringify({
                                product_id: productId,
                                size: size
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            console.log(data);
                            if (!data.success) {
                                Toast.fire({
                                    icon: 'error',
                                    title: data.message
                                });
                                return;
                            }


                            const row = this.closest('.cart-item');
                            if (data.removed) {
                                // حذف سطر از DOM
                                row.remove();
                                // اگر سبد خرید خالی شد، صفحه را ریلود کنید
                                if (data.cart_count === 0) {
                                    location.reload();
                                    return;
                                }
                            } else {
                                // به‌روزرسانی تعداد و قیمت سطر
                                row.querySelector('.input-number').textContent = data.qty;
                                const itemPrice = row.querySelector('.item-total-price');
                                if (itemPrice) {
                                    itemPrice.textContent = Number(data.item_total)
                                        .toLocaleString('fa-IR');
                                }
                            }

                            // بروزرسانی مجموع
                            updateTotals(data);

                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });

                            // اگر سبد خالی شد
                            if (data.cart_count == 0) {

                                document.getElementById('cart-container').innerHTML = `
        <div class="cart-empty">
            <div class="text-center">
                <div>
                    <i class="bi bi-basket-fill" style="font-size:80px"></i>
                </div>

                <h4 class="text-bold">سبد خرید شما خالی است</h4>

                <a href="{{ route('index') }}" class="btn btn-outline-dark mt-3">
                    مشاهده محصولات
                </a>
            </div>
        </div>
    `;

                                return;
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
        });
    </script>
@endsection

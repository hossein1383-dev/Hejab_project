@extends('layout.master')
@section('title', 'Cart Page')

@section('content')
    @if ($cart == null)
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
                        <div class="d-none d-md-block">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>محصول</th>
                                            <th>نام</th>
                                            <th>قیمت</th>
                                            <th>تعداد</th>
                                            <th>قیمت کل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($cart as $key => $item)
                                            <tr class="cart-item" data-product-id="{{ $key }}">
                                                <td>
                                                    <img class="rounded img-fluid"
                                                        src="{{ imageUrl($item['primary_image']) }}" width="90" />
                                                </td>

                                                <td class="fw-bold">{{ $item['name'] }}</td>

                                                <td>
                                                    @if ($item['is_sale'])
                                                        <div>
                                                            <del>{{ number_format($item['price']) }}</del>
                                                            {{ number_format($item['sale_price']) }} تومان
                                                        </div>
                                                        <div class="text-danger">
                                                            {{ salePercent($item['price'], $item['sale_price']) }}%
                                                        </div>
                                                    @else
                                                        {{ number_format($item['price']) }} تومان
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="input-counter">
                                                        <a href="#" class="plus-btn"
                                                            data-product-id="{{ $key }}">+</a>

                                                        <div class="input-number">{{ $item['qty'] }}</div>

                                                        <a href="#" class="minus-btn"
                                                            data-product-id="{{ $key }}">-</a>
                                                    </div>
                                                </td>

                                                <td>
                                                    @php $price = $item['is_sale'] ? $item['sale_price'] : $item['price']; @endphp
                                                    <span class="item-total-price">
                                                        {{ number_format($item['qty'] * $price) }}
                                                    </span>
                                                    <span class="ms-1">تومان</span>
                                                </td>


                                                <td>
                                                    <a href="{{ route('cart_remove', ['product_id' => $key]) }}">
                                                        <i class="bi bi-x text-danger fw-bold fs-4 cursor-pointer"></i>
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
                                <div class="card mb-3 p-3 shadow-sm cart-item" data-product-id="{{ $key }}">

                                    <div class="d-flex gap-3">
                                        <img src="{{ imageUrl($item['primary_image']) }}" class="rounded" width="90">
                                        <div>
                                            <div class="fw-bold mb-2">{{ $item['name'] }}</div>

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
                                        <div class="input-counter" data-product-id="{{ $key }}">
                                            <a href="#" class="plus-btn" data-product-id="{{ $key }}">+</a>

                                            <div class="input-number">{{ $item['qty'] }}</div>

                                            <a href="#" class="minus-btn" data-product-id="{{ $key }}">-</a>
                                        </div>

                                        <div class="fw-bold">
                                            <span class="item-total-price">
                                                {{ number_format($item['qty'] * $price) }}
                                            </span>
                                            <span>تومان</span>
                                        </div>

                                        <a href="{{ route('cart_remove', ['product_id' => $key]) }}">
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

                    {{-- <div class="col-12 col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="کد تخفیف" />
                        <button class="btn btn-primary">اعمال</button>
                    </div>
                </div> --}}
                    <div class="col-12 col-md-8 col-lg-6">
                        <!-- flex-row-reverse در تبلت و دسکتاپ دکمه را می‌برد سمت چپ (در RTL) -->
                        <div class="d-flex flex-column flex-md-row-reverse align-items-stretch align-items-md-center gap-3">

                            <!-- دکمه ایجاد آدرس (سمت چپ در لپ‌تاپ و تبلت) -->
                            <div class="w-100 w-md-auto">
                                <a href="{{ route('addresses_create') }}" class="btn btn-primary w-100 text-nowrap">
                                    ایجاد آدرس
                                </a>
                            </div>

                            <!-- انتخاب آدرس (سمت راست در لپ‌تاپ و تبلت) -->
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

                                    {{-- نمایش ارور --}}
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
                                            {{-- {{ number_format($totalPrice) }} تومان --}}
                                        </span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span>تخفیف: <span class="text-danger">10%</span></span>
                                        <span class="text-danger">53,500 تومان</span>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between fw-bold">
                                        <span>قیمت پرداختی:</span>
                                        <span>481,500 تومان</span>
                                    </li>
                                </ul>

                                <form action="{{ route('payment_send') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="address_id" :value="address_id">
                                    <button type="submit" class="btn btn-primary w-100 mt-4">پرداخت</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            document.querySelectorAll('.plus-btn').forEach(btn => {

                btn.addEventListener('click', function(e) {

                    e.preventDefault();

                    fetch("{{ route('increment') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "X-Requested-With": "XMLHttpRequest"
                            },
                            body: JSON.stringify({
                                product_id: this.dataset.productId,
                                qty: 1
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

                            row.querySelector('.input-number').textContent = data.qty;

                            const itemPrice = row.querySelector('.item-total-price');

                            if (itemPrice) {
                                itemPrice.textContent =
                                    Number(data.item_total).toLocaleString('fa-IR');
                            }

                            const cartTotal = document.getElementById('cart-total');

                            if (cartTotal) {
                                cartTotal.textContent =
                                    Number(data.cart_total).toLocaleString('fa-IR');
                            }

                            document.querySelectorAll('.cart-badge').forEach(el => {
                                el.textContent = data.cart_count;
                            });

                            Toast.fire({
                                icon: 'success',
                                title: data.message
                            });

                        });

                });

            });

            document.querySelectorAll('.minus-btn').forEach(btn => {

                btn.addEventListener('click', function(e) {

                    e.preventDefault();

                    fetch("{{ route('decrement') }}", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "X-Requested-With": "XMLHttpRequest"
                            },
                            body: JSON.stringify({
                                product_id: this.dataset.productId
                            })
                        })
                        .then(res => res.json())
                        .then(data => {

                            if (!data.success) return;

                            const row = this.closest('.cart-item');

                            if (data.qty > 0) {
                                row.querySelector('.input-number').textContent = data.qty;

                                const itemPrice = row.querySelector('.item-total-price');

                                if (itemPrice) {
                                    itemPrice.textContent =
                                        Number(data.item_total).toLocaleString('fa-IR');
                                }

                                const cartTotal = document.getElementById('cart-total');

                                if (cartTotal) {
                                    cartTotal.textContent =
                                        Number(data.cart_total).toLocaleString('fa-IR');
                                }
                            }

                            document.querySelectorAll('.cart-badge').forEach(el => {
                                el.textContent = data.cart_count;
                            });

                        });

                });

            });

        });
    </script>
@endsection

@extends('layout.master')

@section('title', 'Show Product')

@section('content')
    <section class="single_page_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-10 offset-lg-1">
                    <div class="row gy-4 align-items-center">
                        <!-- product images -->
                        <div class="col-12 col-lg-6 order-1 order-lg-2">
                            {{-- ❌ dir="rtl" را حذف کنید --}}
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner rounded"> {{-- همچنین اینجا هم نباشد --}}
                                    <div class="carousel-item active">
                                        <img src="{{ ImageUrl($product->primary_image) }}"
                                            class="carousel-img d-block w-100" alt="">
                                    </div>
                                    @foreach ($product->images as $image)
                                        <div class="carousel-item">
                                            <img src="{{ ImageUrl($image->image) }}" class="carousel-img d-block w-100"
                                                alt="">
                                        </div>
                                    @endforeach
                                </div>
                                @if ($product->images->count() > 0)
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <!-- product info -->
                        <div class="col-12 col-lg-6 order-2 order-lg-1">
                            <div class="product-info p-4">
                                <h3 class="product-title">{{ $product->name }}</h3>
                                <div class="price-box">
                                    @if ($product->is_sale)
                                        <div class="old-price">
                                            <del>{{ number_format($product->price) }} تومان</del>
                                        </div>

                                        <div class="sale-row">
                                            <span class="sale-price">
                                                {{ number_format($product->sale_price) }} تومان
                                            </span>

                                            <span class="discount-badge">
                                                {{ salePercent($product->price, $product->sale_price) }}٪
                                            </span>
                                        </div>
                                    @else
                                        <div class="normal-price-show">
                                            {{ number_format($product->price) }} تومان
                                        </div>
                                    @endif
                                </div>

                                <div class="product-desc mt-3">
                                    {!! $product->description !!}
                                </div>
                                <br>
                                @if ($product->sizes->isNotEmpty())
                                    <h5>سایزهای موجود:</h5>
                                    <div class="d-flex flex-wrap gap-2 mt-2" id="sizeCheckboxes">
                                        @foreach ($product->sizes as $size)
                                            <div class="form-check">
                                                <input class="size-checkbox" type="checkbox" name="size"
                                                    value="{{ $size->size_name }}" id="size_{{ $size->size_name }}"
                                                    {{ $size->stock == 0 ? 'disabled' : '' }}>

                                                <label class="form-check-label" for="size_{{ $size->size_name }}">
                                                    {{ $size->size_name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                @endif
                            </div>

                            <!-- ===== فرم افزودن به سبد خرید با چک‌باکس سایز ===== -->
                            <form x-data="{ quantity: 1 }" action="{{ route('cart_add') }}" method="POST"
                                class="d-flex flex-column flex-sm-row gap-3 mt-3">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="qty" :value="quantity">
                                <input type="hidden" name="size" id="selectedSize" value="">

                                <button class="btn btn-dark" type="submit" id="addToCartBtn">
                                    افزودن به سبد خرید
                                </button>
                                <div class="input-counter d-flex align-items-center">
                                    <span @click="quantity < {{ $product->quantity }} && quantity++" class="plus-btn px-3">
                                        +
                                    </span>
                                    <div class="input-number px-3" x-text="quantity"></div>
                                    <span @click="quantity > 1 && quantity--" class="minus-btn px-3">
                                        -
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <hr>

    <section class="">
        <div class="show-box">
            <div class="products-scroll ps-3">
                <div class="scroll-inner">
                    @foreach ($randomProducts as $randomProduct)
                        <div class="product-card">
                            <div class="product-image">
                                <a href="{{ route('product_show', ['product' => $randomProduct->slug]) }}">
                                    <img class="img-fluid" src="{{ imageUrl($randomProduct->primary_image) }}"
                                        alt="{{ $randomProduct->name }}">
                                </a>
                            </div>
                            <div class="product-content">
                                <h3>
                                    <a href="{{ route('product_show', ['product' => $randomProduct->slug]) }}">
                                        {{ $randomProduct->name }}
                                    </a>
                                </h3>
                                <a href="{{ route('product_show', ['product' => $randomProduct->slug]) }}">
                                    <p class="description">
                                        {{ Str::limit($randomProduct->description, 80) }}
                                    </p>
                                </a>
                                <div class="product-footer">
                                    <div class="price">
                                        @if ($randomProduct->is_sale)
                                            <del>
                                                {{ number_format($randomProduct->price) }}
                                            </del>
                                            <strong class="sale-price">
                                                {{ number_format($randomProduct->sale_price) }}
                                                <small>
                                                    تومان
                                                </small>
                                            </strong>
                                        @else
                                            <strong class="normal-price">
                                                {{ number_format($randomProduct->price) }}
                                                <small>
                                                    تومان
                                                </small>
                                            </strong>
                                        @endif
                                    </div>
                                    <div class="product-actions">
                                        <a href="#" class="add-to-cart" data-product-id="{{ $randomProduct->id }}">
                                            <i class="bi bi-cart-fill"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <!-- اسکریپت برای محدود کردن انتخاب به یک چک‌باکس و مقداردهی فیلد hidden -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkboxes = document.querySelectorAll('.size-checkbox');
            const selectedSizeInput = document.getElementById('selectedSize');
            const addToCartBtn = document.getElementById('addToCartBtn');

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    // اگر این چک‌باکس تیک خورده، سایر چک‌باکس‌ها را غیرفعال کن
                    if (this.checked) {
                        checkboxes.forEach(function(other) {
                            if (other !== checkbox) {
                                other.checked = false;
                            }
                        });
                        selectedSizeInput.value = this.value;
                    } else {
                        selectedSizeInput.value = '';
                    }
                });
            });

            // جلوگیری از ارسال فرم بدون انتخاب سایز (اگر محصول سایز دارد)
            addToCartBtn.addEventListener('click', function(e) {
                const hasSizes = {{ $product->sizes->isNotEmpty() ? 'true' : 'false' }};
                if (hasSizes && !selectedSizeInput.value) {
                    e.preventDefault();
                    alert('لطفاً یک سایز را انتخاب کنید.');
                }
            });
        });
    </script>
@endsection

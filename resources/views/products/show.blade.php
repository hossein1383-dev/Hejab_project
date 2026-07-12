@extends('layout.master');

@section('title', 'Show Product')

@section('content')
    <section class="single_page_section layout_padding">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-10 offset-lg-1">
                    <div class="row gy-4 align-items-center">
                        <!-- product images -->
                        <div class="col-12 col-lg-6 order-1 order-lg-2">
                            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner rounded">
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
                                @foreach ($product->images as $image)
                                    <button class="carousel-control-prev" type="button"
                                        data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button"
                                        data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                @endforeach
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
                                <p class="product-desc">
                                    {{ $product->description }}
                                </p>
                            </div>
                            <form x-data="{ quantity: 1 }" action="{{ route('cart_add') }}"
                                class="d-flex flex-column flex-sm-row gap-3">
                                <button class="btn btn-dark">
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="qty" :value="quantity">
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
    </section>


    <hr>

    <section class="">
        <div class="show-box">
            <div class="products-scroll ps-3">
                <div class="scroll-inner">
                    @foreach ($randomProduct as $product)
                        <div class="product-card">
                            <div class="product-image">
                                <a href="{{ route('product_show', ['product' => $product->slug]) }}">
                                    <img class="img-fluid" src="{{ imageUrl($product->primary_image) }}"
                                        alt="{{ $product->name }}">
                                </a>
                            </div>
                            <div class="product-content">
                                <h3>
                                    <a href="{{ route('product_show', ['product' => $product->slug]) }}">
                                        {{ $product->name }}
                                    </a>
                                </h3>
                                <a href="{{ route('product_show', ['product' => $product->slug]) }}">
                                    <p class="description">
                                        {{ $product->description }}
                                    </p>
                                </a>
                                <div class="product-footer">
                                    <div class="price">
                                        @if ($product->is_sale)
                                            <del>
                                                {{ number_format($product->price) }}
                                            </del>
                                            <strong class="sale-price">
                                                {{ number_format($product->sale_price) }}
                                                <small>
                                                    تومان
                                                </small>
                                            </strong>
                                        @else
                                            <strong class="normal-price">
                                                {{ number_format($product->price) }}
                                                <small>
                                                    تومان
                                                </small>
                                            </strong>
                                        @endif
                                    </div>
                                    <div class="product-actions">
                                        <a href="#" class="add-to-cart" data-product-id="{{ $product->id }}">
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

@endsection

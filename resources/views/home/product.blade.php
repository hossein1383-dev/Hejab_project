    <!-- food section -->
    <section class="food_section layout_padding-bottom">
        <div id="message-box"></div>

        <div class="heading_container heading_center pb-3 pt-5">
            <h2> پرفروش ها</h2>
        </div>
        <div class="products-scroll ps-3">
            <div class="scroll-inner">
                @foreach ($bestSellers as $bestSeller)
                    <div class="product-card">
                        <div class="product-image">
                            <a href="{{ route('product_show', ['product' => $bestSeller->slug]) }}">
                                <img class="img-fluid" src="{{ imageUrl($bestSeller->primary_image) }}"
                                    alt="{{ $bestSeller->name }}">
                            </a>
                        </div>
                        <div class="product-content">
                            <h3>
                                <a href="{{ route('product_show', ['product' => $bestSeller->slug]) }}">
                                    {{ $bestSeller->name }}
                                </a>
                            </h3>
                            <a href="{{ route('product_show', ['product' => $bestSeller->slug]) }}">
                                <p class="description">
                                    {{ $bestSeller->description }}
                                </p>
                            </a>
                            <div class="product-footer">
                                <div class="price">
                                    @if ($bestSeller->is_sale)
                                        <del>
                                            {{ number_format($bestSeller->price) }}
                                        </del>
                                        <strong class="sale-price">
                                            {{ number_format($bestSeller->sale_price) }}
                                            <small>
                                                تومان
                                            </small>
                                        </strong>
                                    @else
                                        <strong class="normal-price">
                                            {{ number_format($bestSeller->price) }}
                                            <small>
                                                تومان
                                            </small>
                                        </strong>
                                    @endif
                                </div>
                                <div class="product-actions">
                                    <a href="#" class="add-to-cart" data-product-id="{{ $bestSeller->id }}">
                                        <i class="bi bi-cart-fill"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>



        <div class="container pt-5" x-data="{ tab: 1 }">
            <div class="heading_container heading_center">
                <h2>منو محصولات</h2>
            </div>

            <!-- تب‌ها -->
            <ul class="filters_menu">
                <li :class="tab === 1 ? 'active' : ''" @click="tab = 1">روسری</li>
                <li :class="tab === 2 ? 'active' : ''" @click="tab = 2">چادر</li>
                <li :class="tab === 3 ? 'active' : ''" @click="tab = 3">عبا</li>
            </ul>


            @php
                $rosaries = App\Models\Product::where('category_id', 2)
                    ->where('quantity', '>', 0)
                    ->where('status', 1)
                    ->take(6)
                    ->get();
                $chodors = App\Models\Product::where('category_id', 3)
                    ->where('quantity', '>', 0)
                    ->where('status', 1)
                    ->take(6)
                    ->get();
                $abas = App\Models\Product::where('category_id', 1)
                    ->where('quantity', '>', 0)
                    ->where('status', 1)
                    ->take(6)
                    ->get();
                // dd($abas);
            @endphp

            <!-- محتوا -->
            <div class="products-grid">
                <div x-show="tab === 1" class="scroll-box">
                    <div class="scroll-inner my-scroll">
                        @foreach ($rosaries as $rosary)
                            <div class="product-card">
                                <div class="product-image">
                                    <a href="{{ route('product_show', ['product' => $rosary->slug]) }}">
                                        <img class="img-fluid" src="{{ imageUrl($rosary->primary_image) }}"
                                            alt="{{ $rosary->name }}">
                                    </a>
                                </div>
                                <div class="product-content">
                                    <h3>
                                        <a href="{{ route('product_show', ['product' => $rosary->slug]) }}">
                                            {{ $rosary->name }}
                                        </a>
                                    </h3>
                                    <a href="{{ route('product_show', ['product' => $rosary->slug]) }}">
                                        <p class="description">
                                            {{ $rosary->description }}
                                        </p>
                                    </a>
                                    <div class="product-footer">
                                        <div class="price">
                                            @if ($rosary->is_sale)
                                                <del>
                                                    {{ number_format($rosary->price) }}
                                                </del>
                                                <strong class="sale-price">
                                                    {{ number_format($rosary->sale_price) }}
                                                    <small>
                                                        تومان
                                                    </small>
                                                </strong>
                                            @else
                                                <strong class="normal-price">
                                                    {{ number_format($rosary->price) }}
                                                    <small>
                                                        تومان
                                                    </small>
                                                </strong>
                                            @endif
                                        </div>
                                        <div class="product-actions">
                                            <a href="#" class="add-to-cart"
                                                data-product-id="{{ $rosary->id }}">
                                                <i class="bi bi-cart-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div x-show="tab === 2" class="scroll-box">
                    <div class="scroll-inner">
                        @foreach ($chodors as $chador)
                            <div class="product-card">
                                <div class="product-image">
                                    <a href="{{ route('product_show', ['product' => $chador->slug]) }}">
                                        <img class="img-fluid" src="{{ imageUrl($chador->primary_image) }}"
                                            alt="{{ $chador->name }}">
                                    </a>
                                </div>
                                <div class="product-content">
                                    <h3>
                                        <a href="{{ route('product_show', ['product' => $chador->slug]) }}">
                                            {{ $chador->name }}
                                        </a>
                                    </h3>
                                    <a href="{{ route('product_show', ['product' => $chador->slug]) }}">
                                        <p class="description">
                                            {{ $chador->description }}
                                        </p>
                                    </a>
                                    <div class="product-footer">
                                        <div class="price">
                                            @if ($chador->is_sale)
                                                <del>
                                                    {{ number_format($chador->price) }}
                                                </del>
                                                <strong class="sale-price">
                                                    {{ number_format($chador->sale_price) }}
                                                    <small>
                                                        تومان
                                                    </small>
                                                </strong>
                                            @else
                                                <strong class="normal-price">
                                                    {{ number_format($chador->price) }}
                                                    <small>
                                                        تومان
                                                    </small>
                                                </strong>
                                            @endif
                                        </div>
                                        <div class="product-actions">
                                            <a href="#" class="add-to-cart"
                                                data-product-id="{{ $chador->id }}">
                                                <i class="bi bi-cart-fill"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div x-show="tab === 3" class="scroll-box">
                    <div class="scroll-inner">
                        @foreach ($abas as $aba)
                            <div class="product-card">
                                <div class="product-image">
                                    <a href="{{ route('product_show', ['product' => $aba->slug]) }}">
                                        <img class="img-fluid" src="{{ imageUrl($aba->primary_image) }}"
                                            alt="{{ $aba->name }}">
                                    </a>
                                </div>
                                <div class="product-content">
                                    <h3>
                                        <a href="{{ route('product_show', ['product' => $aba->slug]) }}">
                                            {{ $aba->name }}
                                        </a>
                                    </h3>
                                    <a href="{{ route('product_show', ['product' => $aba->slug]) }}">
                                        <p class="description">
                                            {{ $aba->description }}
                                        </p>
                                    </a>
                                    <div class="product-footer">
                                        <div class="price">
                                            @if ($aba->is_sale)
                                                <del>
                                                    {{ number_format($aba->price) }}
                                                </del>
                                                <strong class="sale-price">
                                                    {{ number_format($aba->sale_price) }}
                                                    <small>
                                                        تومان
                                                    </small>
                                                </strong>
                                            @else
                                                <strong class="normal-price">
                                                    {{ number_format($aba->price) }}
                                                    <small>
                                                        تومان
                                                    </small>
                                                </strong>
                                            @endif
                                        </div>
                                        <div class="product-actions">
                                            <a href="#" class="add-to-cart"
                                                data-product-id="{{ $aba->id }}">
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

            <!-- دکمه مشاهده بیشتر -->
            <div class="btn-box">
                <a href="{{ route('product_menu') }}">مشاهده بیشتر</a>
            </div>
        </div>
    </section>
    <!-- end food section -->

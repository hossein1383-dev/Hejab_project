@if ($products->isEmpty())
    <div class="empty-product">
        محصولی یافت نشد!
    </div>
@endif

<div class="products-grid">
    @foreach ($products as $product)
        <div class="product-card">
            <div class="product-image">
                <a href="{{ route('product_show', ['product' => $product->slug]) }}">
                    <img class="img-fluid" src="{{ imageUrl($product->primary_image) }}" alt="{{ $product->name }}">
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

@extends('layout.master')

@section('title', 'Menu Page')


@section('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('filter', () => ({
                search: '{{ request('search') }}',
                currentUrl: '{{ url()->current() }}',
                filter(type, value) {
                    let params = new URLSearchParams(window.location.search);
                    if (value) {
                        params.set(type, value);
                    } else {
                        params.delete(type);
                    }
                    params.delete('page');
                    this.sendRequest(params);
                },
                removeFilter(type) {
                    let params = new URLSearchParams(window.location.search);
                    params.delete(type);
                    params.delete('page');
                    this.sendRequest(params);
                },
                sendRequest(params) {
                    fetch(this.currentUrl + '?' + params.toString(), {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // محصولات
                            document.querySelector('#products-list').innerHTML =
                                data.products;
                            // فیلترهای فعال
                            document.querySelector('.active-filters').innerHTML =
                                data.filters;
                            let mobileFilters = document.querySelector('#mobile-filters');

                            if (mobileFilters) {

                                mobileFilters.innerHTML = data.mobileFilters;

                            }
                            window.history.pushState({},
                                '',
                                '?' + params.toString()
                            );
                        });
                }
            }))
        })
    </script>
@endsection

@section('content')
    <section class="shop-section">
        <div class="shop-container">
            <div class="shop-layout">
                {{-- Desktop Filter --}}
                <aside class="desktop-filter d-none d-lg-block">
                    <div x-data="filter">

                        <div x-data="{ open: false }">

                            {{-- Toolbar --}}
                            <div class="shop-toolbar">
                                <button class="filter-button" @click="open = !open">
                                    <i class="bi bi-funnel"></i>
                                    فیلتر محصولات

                                    @if (request()->hasAny(['search', 'category', 'sortBy']))
                                        <span class="badge">
                                            {{ count(request()->only(['search', 'category', 'sortBy'])) }}
                                        </span>
                                    @endif
                                </button>
                            </div>


                            {{-- Active Filters --}}
                            <div id="active-filters" class="active-filters">
                                @if (request('search'))
                                    <span>
                                        {{ request('search') }}
                                        <i class="bi bi-x" @click="removeFilter('search')"></i>
                                    </span>
                                @endif
                                @if (request('category'))
                                    <span>
                                        دسته بندی
                                        <i class="bi bi-x" @click="removeFilter('category')"></i>
                                    </span>
                                @endif
                                @if (request('sortBy'))
                                    <span>
                                        مرتب سازی
                                        <i class="bi bi-x" @click="removeFilter('sortBy')"></i>
                                    </span>
                                @endif
                            </div>

                            {{-- Overlay --}}
                            <div class="filter-overlay" x-show="open" @click="open=false" x-transition>
                            </div>
                            {{-- Drawer --}}
                            <aside class="filter-drawer" x-show="open" x-transition:enter="drawer-enter"
                                x-transition:enter-start="drawer-enter-start" x-transition:enter-end="drawer-enter-end"
                                x-transition:leave="drawer-leave" x-transition:leave-start="drawer-leave-start"
                                x-transition:leave-end="drawer-leave-end">
                                {{-- Search --}}
                                <div class="filter-card">
                                    <h5>
                                        جستجو
                                    </h5>
                                    <div class="search-box">
                                        <input type="text" x-model="search" placeholder="نام محصول ...">
                                        <button @click="filter('search',search)">
                                            <i class="bi bi-search"></i>
                                        </button>
                                    </div>
                                </div>
                                {{-- Category --}}
                                <div class="filter-card">
                                    <h5>
                                        دسته بندی
                                    </h5>
                                    <ul class="category-list">
                                        @foreach ($categories as $category)
                                            <li @click="filter('category','{{ $category->id }}')"
                                                class="{{ request('category') == $category->id ? 'active' : '' }}">
                                                {{ $category->name }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                {{-- Sort --}}
                                <div class="filter-card">
                                    <h5>
                                        مرتب سازی
                                    </h5>
                                    <ul class="sort-select">
                                        <li @click="filter('sortBy','max')"
                                            class="{{ request('sortBy') == 'max' ? 'active' : '' }}">
                                            بیشترین قیمت
                                        </li>
                                        <li @click="filter('sortBy','min')"
                                            class="{{ request('sortBy') == 'min' ? 'active' : '' }}">
                                            کمترین قیمت
                                        </li>
                                        <li @click="filter('sortBy','bestseller')"
                                            class="{{ request('sortBy') == 'bestseller' ? 'active' : '' }}">
                                            پرفروش ترین
                                        </li>
                                        <li @click="filter('sortBy','sale')"
                                            class="{{ request('sortBy') == 'sale' ? 'active' : '' }}">
                                            با تخفیف
                                        </li>
                                    </ul>
                                </div>
                                <div class="drawer-footer">
                                    <button class="clear-btn" @click="window.location.href='{{ url()->current() }}'">
                                        حذف همه
                                    </button>
                                </div>
                            </aside>
                        </div>
                    </div>
                </aside>
                {{-- Products --}}
                <main class="products-area">
                    {{-- Mobile Filter Button --}}
                    <div x-data="{ open: false }" class="mobile-filter d-lg-none">
                        <button class="filter-button" @click="open=!open">
                            <i class="bi bi-funnel-fill"></i>
                            فیلتر محصولات
                            <i class="bi" :class="open ? 'bi-chevron-up' : 'bi-chevron-down'"></i>
                        </button>
                        <div x-show="open" x-transition class="mobile-filter-box">
                            <div x-data="filter">
                                <div id="mobile-filters">

                                    @include('partials.mobile-filters')

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="products-list">
                        @include('partials.products')
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection

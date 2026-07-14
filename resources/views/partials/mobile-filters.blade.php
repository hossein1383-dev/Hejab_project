<div class="filter-card">
    <div class="filter-title">
        جستجو
        @if(request()->has('search'))
            <i @click="removeFilter('search')"
               class="bi bi-x-circle text-danger">
            </i>

        @endif
    </div>
    <div class="search-box">
        <input type="text"
               x-model="search"
               placeholder="نام محصول ...">
        <button @click="filter('search',search)">
            <i class="bi bi-search"></i>
        </button>
    </div>
</div>

<div class="filter-card">
    <div class="filter-title">
        دسته بندی
        @if(request()->has('category'))
            <i @click="removeFilter('category')"
               class="bi bi-x-circle text-danger">
            </i>
        @endif
    </div>

    <ul class="category-list">
        @foreach($categories as $category)
            <li
            @click="filter('category','{{$category->id}}')"
            class="{{ request('category') == $category->id ? 'active' : '' }}">
                {{$category->name}}
            </li>
        @endforeach
    </ul>
</div>



<div class="filter-card">
    <div class="filter-title">
        مرتب سازی
        @if(request()->has('sortBy'))
            <i @click="removeFilter('sortBy')"
               class="bi bi-x-circle text-danger">
            </i>
        @endif
    </div>

    <label class="sort-item">
        <input type="radio"
               name="mobile-sort"
               @change="filter('sortBy','max')"
               {{request('sortBy')=='max'?'checked':''}}>
        <span class="custom-radio"></span>
        بیشترین قیمت
    </label>





    <label class="sort-item">
        <input type="radio"
               name="mobile-sort"
               @change="filter('sortBy','min')"
               {{request('sortBy')=='min'?'checked':''}}>
        <span class="custom-radio"></span>
        کمترین قیمت
    </label>

    <label class="sort-item">
        <input type="radio"
               name="mobile-sort"
               @change="filter('sortBy','bestseller')"
               {{request('sortBy')=='bestseller'?'checked':''}}>
        <span class="custom-radio"></span>
        پرفروش ترین
    </label>


    <label class="sort-item">
        <input type="radio"
               name="mobile-sort"
               @change="filter('sortBy','sale')"
               {{request('sortBy')=='sale'?'checked':''}}>
        <span class="custom-radio"></span>
        با تخفیف
    </label>
</div>
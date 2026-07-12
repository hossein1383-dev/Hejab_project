<div class="active-filters">
    @if(request('search'))
        <span>
            {{ request('search') }}
            <i class="bi bi-x"
               @click="removeFilter('search')">
            </i>
        </span>
    @endif
    @if(request('category'))
        <span>
            دسته بندی
            <i class="bi bi-x"
               @click="removeFilter('category')">
            </i>
        </span>
    @endif
    @if(request('sortBy'))
        <span>
            مرتب سازی
            <i class="bi bi-x"
               @click="removeFilter('sortBy')">
            </i>
        </span>
    @endif
</div>
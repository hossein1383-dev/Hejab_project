@extends('profile.layout.master')
@section('title', 'Create Address')

@section('script')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('cityInput', () => ({
                cities: @json($cities->toArray()),
                citiesFilter: [],
                province: 1,

                init() {
                    this.filterCities();

                    this.$watch('province', () => {
                        this.filterCities();
                    })
                },

                filterCities() {
                    this.citiesFilter = this.cities.filter(city => city.province_id == this.province);
                }
            }))
        })
    </script>
@endsection

@section('main')

    
    <div class="col-sm-12 col-lg-9 mx-auto" x-data="cityInput">
        <h5 class="mb-4 text-center">
            ایجاد آدرس جدید
        </h5>

        <form action="{{ route('addresses_store') }}" method="POST" class="card card-body shadow-sm p-4">
            @csrf
            <div class="row g-3">

                <div class="col-12 col-md-6">
                    <label class="form-label">شماره تماس</label>
                    <input name="cellphone" type="text" class="form-control" />
                    <div class="form-text text-danger">
                        @error('cellphone')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-md-6" >
                    <label class="form-label">کد پستی</label>
                    <input name="postal_code" type="text" class="form-control" />
                    <div class="form-text text-danger">
                        @error('postal_code')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">استان</label>
                    <select x-model="province" name="province_id" class="form-select">
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    <div class="form-text text-danger">
                        @error('province_id')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">شهر</label>
                    <select name="city_id" class="form-select">
                        <template x-for="city in citiesFilter" :key="city.id">
                            <option :value="city.id" x-text="city.name"></option>
                        </template>
                    </select>
                    <div class="form-text text-danger">
                        @error('city_id')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">آدرس</label>
                    <textarea name="address" rows="5" class="form-control"></textarea>
                    <div class="form-text text-danger">
                        @error('address')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-4">
                <button type="submit" class="btn btn-primary w-50 w-md-50">
                    ایجاد
                </button>
            </div>
        </form>
    </div>
@endsection

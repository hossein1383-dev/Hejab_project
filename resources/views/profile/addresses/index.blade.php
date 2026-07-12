@extends('profile.layout.master')
@section('title', 'Address Page')

@section('main')
    <div class="col-12 col-lg-9">

        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('addresses_create') }}" class="btn btn-primary">
                ایجاد آدرس جدید
            </a>
        </div>

        @foreach ($addresses as $address)
            <div class="card card-body">
                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">شماره تماس</label>
                        <input disabled type="text" value="{{ $address->cellphone }}" class="form-control" />
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">کد پستی</label>
                        <input disabled type="text" value="{{ $address->postal_code }}" class="form-control" />
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">استان</label>
                        <input disabled type="text" value="{{ $address->province->name }}" class="form-control" />
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">شهر</label>
                        <input disabled type="text" value="{{ $address->city->name }}" class="form-control" />
                    </div>

                    <div class="col-12">
                        <label class="form-label">آدرس</label>
                        <textarea disabled rows="5" class="form-control">
{{ $address->address }}
                </textarea>
                    </div>

                </div>

                <div class="mt-4">
                    <a href="{{ route('addresses_edit', ['address' => $address->id]) }}" class="btn btn-primary w-50" style="display:block; margin:0 auto;">

                        ویرایش
                    </a>
                </div>

            </div>
        @endforeach

        <hr />

    </div>
@endsection

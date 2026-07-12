@extends('profile.layout.master')
@section('title', 'Profile Page')

@section('main')
    <div class="col-sm-12 col-lg-9">
        <form action="{{ route('profile_update', ['user' => $user->id]) }}" method="POST" class="vh-70 p-3 p-md-4"
            style="background: #fff; border-radius: 12px;">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-12 col-md-6">
                    <label class="form-label">نام و نام خانوادگی</label>
                    <input name="name" type="text" class="form-control" value="{{ $user->name }}" />
                    <div class="form-text text-danger">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <label class="form-label">ایمیل</label>
                    <input name="email" type="text" class="form-control" value="{{ $user->email }}" />
                    <div class="form-text text-danger">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">شماره تلفن</label>
                    <input type="text" disabled class="form-control" value="{{ $user->cellphone }}" />
                </div>

            </div>

            <button type="submit" class="btn btn-primary mt-4 w-100 d-block d-md-inline-block px-4 py-2"
                style="font-size: 16px;">
                ویرایش
            </button>
        </form>
    </div>
@endsection

@extends('profile.layout.master')

@section('title', 'Profile Page')

@section('main')
    <div class="col-sm-12 col-lg-12">
        {{-- Desktop --}}
        <div class="table-responsive d-none d-md-block">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>شماره سفارش</th>
                        <th>آدرس</th>
                        <th>وضعیت</th>
                        <th>وضعیت پرداخت</th>
                        <th>قیمت کل</th>
                        <th>تاریخ</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <th>
                                {{ $order->id }}
                            </th>
                            <td>
                                {{ $order->address?->city?->name }}
                            </td>
                            <td>
                                {{ $order->status }}
                            </td>
                            <td>
                                <span
                                    class="{{ $order->getRawOriginal('payment_status') ? 'text-success' : 'text-danger' }}">
                                    {{ $order->payment_status }}
                                </span>
                            </td>
                            <td>
                                {{ number_format($order->paying_amount) }} تومان
                            </td>
                            <td>
                                {{ verta($order->created_at)->format('%B %d، %Y') }}
                            </td>
                            <td>
                                <button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modal-{{ $order->id }}">
                                    محصولات
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Mobile --}}
        <div class="d-md-none">
            @foreach ($orders as $order)
                <div class="card shadow-sm mb-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <strong>
                                سفارش #{{ $order->id }}
                            </strong>
                            <small class="text-muted">
                                {{ verta($order->created_at)->format('%d %B %Y') }}
                            </small>
                        </div>
                        <hr>
                        <div class="mb-2">
                            <small class="text-muted">
                                شهر
                            </small>
                            <div>
                                {{ $order->address?->city?->name }}
                            </div>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">
                                وضعیت سفارش
                            </small>
                            <div>
                                {{ $order->status }}
                            </div>
                        </div>
                        <div class="mb-2">
                            <small class="text-muted">
                                وضعیت پرداخت
                            </small>
                            <div class="{{ $order->getRawOriginal('payment_status') ? 'text-success' : 'text-danger' }}">
                                {{ $order->payment_status }}
                            </div>
                        </div>
                        <div class="mb-3">
                            <small class="text-muted">
                                مبلغ
                            </small>
                            <div class="fw-bold">

                                {{ number_format($order->paying_amount) }} تومان
                            </div>
                        </div>
                        <button class="btn btn-primary w-100" data-bs-toggle="modal"
                            data-bs-target="#modal-{{ $order->id }}">
                            مشاهده محصولات
                        </button>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Modals --}}
        @foreach ($orders as $order)
            <div class="modal fade" id="modal-{{ $order->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title">
                                محصولات سفارش شماره {{ $order->id }}
                            </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead>
                                        <tr>
                                            <th>
                                                محصول
                                            </th>
                                            <th>
                                                نام
                                            </th>
                                            <th>
                                                قیمت
                                            </th>
                                            <th>
                                                تعداد
                                            </th>
                                            <th>
                                                سایز
                                            </th>
                                            <th>
                                                قیمت کل
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderItems as $item)
                                            <tr>
                                                <th>
                                                    <img class="rounded"
                                                        src="{{ imageUrl($item->product->primary_image) }}" width="70">
                                                </th>
                                                <td>
                                                    {{ $item->product->name }}
                                                </td>
                                                <td>
                                                    {{ number_format($item->price) }}
                                                </td>
                                                <td>
                                                    {{ $item->quantity }}
                                                </td>
                                                <td>
                                                    {{ $item->size }}
                                                </td>
                                                <td>
                                                    {{ number_format($item->subtotal) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="orders-pagination">
            {{ $orders->links() }}
        </div>

        <style>
            .pagination {
                direction: rtl;
            }

            .pagination .small {
                text-align: right !important;
            }
        </style>
    </div>
@endsection

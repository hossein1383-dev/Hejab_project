@extends('profile.layout.master')
@section('title', 'Profile Page')

@section('main')
    <div class="col-sm-12 col-lg-9">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>شماره سفارش</th>
                        <th>شهر</th>
                        <th>وضعیت</th>
                        <th>وضعیت پرداخت</th>
                        <th>قیمت کل</th>
                        <th>تاریخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <th>
                                {{ $order->id }}
                            </th>
                            <td>{{ $order->address->city->name }}</td>
                            <td>{{ $order->status }}</td>
                            <td>
                                <span
                                    class="{{ $order->getRawOriginal('payment_status') ? 'text-success' : 'text-danger' }}">{{ $order->payment_status }}</span>
                            </td>
                            <td>{{ number_format($order->paying_amount) }} تومان</td>
                            <td>{{ verta($order->created_at)->format('%B %d، %Y') }}</td>

                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-1">
                                    محصولات
                                </button>

                                <div class="modal fade" id="modal-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">محصولات سفارش
                                                    شماره 25</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th>محصول</th>
                                                            <th>نام</th>
                                                            <th>قیمت</th>
                                                            <th>تعداد</th>
                                                            <th>قیمت کل</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>
                                                                <img class="rounded" src="../images/b1.jpg" width="80"
                                                                    alt="" />
                                                            </th>
                                                            <td class="fw-bold">برگر گوشت ذغالی</td>
                                                            <td>45,000 تومان</td>
                                                            <td>
                                                                2
                                                            </td>
                                                            <td>90,000 تومان</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <nav class="d-flex justify-content-center mt-5">
            <ul class="pagination">
                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                <li class="page-item"><a class="page-link" href="#">2</a></li>
                <li class="page-item"><a class="page-link" href="#">3</a></li>
            </ul>
        </nav>
    </div>
@endsection

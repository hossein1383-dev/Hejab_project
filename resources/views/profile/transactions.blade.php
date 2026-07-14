@extends('profile.layout.master')

@section('title', 'Profile Page')

@section('main')

    <div class="col-sm-12 col-lg-12">

        {{-- نسخه دسکتاپ --}}
        <div class="table-responsive d-none d-md-block">

            <table class="table align-middle">

                <thead>
                    <tr>
                        <th>شماره سفارش</th>
                        <th>مبلغ</th>
                        <th>وضعیت</th>
                        <th>شماره پیگیری</th>
                        <th>تاریخ</th>
                    </tr>
                </thead>


                <tbody>

                    @foreach ($transactions as $transaction)
                        <tr>

                            <th>
                                {{ $transaction->id }}
                            </th>

                            <td>
                                {{ number_format($transaction->amount) }} تومان
                            </td>

                            <td>
                                <span class="{{ $transaction->getRawOriginal('status') ? 'text-success' : 'text-danger' }}">
                                    {{ $transaction->status }}
                                </span>
                            </td>

                            <td>
                                {{ $transaction->ref_number }}
                            </td>

                            <td>
                                {{ verta($transaction->created_at)->format('%B %d، %Y') }}
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>

        </div>



        {{-- نسخه موبایل --}}
        <div class="d-md-none">

            @foreach ($transactions as $transaction)
                <div class="card mb-3 shadow-sm border-0">

                    <div class="card-body">


                        <div class="d-flex justify-content-between mb-2">

                            <span class="text-muted">
                                شماره سفارش
                            </span>

                            <strong>
                                #{{ $transaction->id }}
                            </strong>

                        </div>



                        <div class="d-flex justify-content-between mb-2">

                            <span class="text-muted">
                                مبلغ
                            </span>

                            <strong>
                                {{ number_format($transaction->amount) }} ریال
                            </strong>

                        </div>



                        <div class="d-flex justify-content-between mb-2">

                            <span class="text-muted">
                                وضعیت
                            </span>

                            <span class="{{ $transaction->getRawOriginal('status') ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->status }}
                            </span>

                        </div>



                        <div class="d-flex justify-content-between mb-2">

                            <span class="text-muted">
                                شماره پیگیری
                            </span>

                            <span>
                                {{ $transaction->ref_number }}
                            </span>

                        </div>



                        <div class="d-flex justify-content-between">

                            <span class="text-muted">
                                تاریخ
                            </span>

                            <span>
                                {{ verta($transaction->created_at)->format('%B %d، %Y') }}
                            </span>

                        </div>


                    </div>

                </div>
            @endforeach


        </div>


    </div>
    <div class="orders-pagination">
        {{ $transactions->links() }}
    </div>
@endsection

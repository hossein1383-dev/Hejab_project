<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\ZarinpalService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function send(Request $request, ZarinpalService $zarinpal)
    {
        // dd($request->session()->get('cart', []));
        $request->validate([
            'address_id' => ['required', 'integer', 'exists:user_addresses,id'],
        ]);
        $cart = $request->session()->get('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'سبد خرید خالی است');
        }

        $total = 0;
        $orderItems = []; 


        foreach ($cart as $productId => $item) {
            $product = Product::findOrFail($productId);

            $price = $product->is_sale ? $product->sale_price : $product->price;

            $total += $price * $item['qty'];
            $orderItems[$productId] = [
                'product' => $product,
                'price' => $price,
                'qty' => $item['qty'],
                'size' => $item['size'],
            ];
            // dd($orderItems);
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'address_id' => $request->address_id,
                'total_amount' => $total, // الان total با تخفیف محاسبه شده
                'paying_amount' => $total,
                
            ]);


            foreach ($orderItems as $productId => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'size' => $item['size'],
                    'price' => $item['price'], // قیمت تخفیف‌خورده یا اصلی
                    'quantity' => $item['qty'],
                    'subtotal' => $item['price'] * $item['qty'], // زیرمجموع با تخفیف
                ]);
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        $transaction = Transaction::create([
            'user_id' => Auth::id(),
            'order_id' => $order->id,
            'amount' => $total . 0,
            'status' => 0,
        ]);

        $result = $zarinpal->request($total, route('payment_verify', $transaction), "پرداخت سفارش #{$order->id}");

        if ($result['data']['code'] != 100) {
            return back()->with('error', 'خطا در اتصال به درگاه');
        }

        $transaction->update([
            'token' => $result['data']['authority'],
        ]);

        foreach ($cart as $item) {
            // افزایش sold_count به تعداد خریداری شده
            Product::where('id', $productId)->increment('sold_count', $item['qty']);
        }

        return redirect($zarinpal->redirectUrl($result['data']['authority']));
    }

    public function verify(Request $request, Transaction $transaction, ZarinpalService $zarinpal)
    {
        // قبلاً پرداخت شده
        if ($transaction->status == 1) {
            return back()->with('success', 'قبلاً پرداخت شده');
        }

        // کاربر پرداخت را لغو کرده
        if ($request->Status !== 'OK') {
            $transaction->update(['status' => 2]);

            return back()->with('error', 'پرداخت لغو شد');
        }

        $result = $zarinpal->verify($transaction->amount, $request->Authority);

        // خطاهای زرین پال
        if (!empty($result['errors'])) {
            $transaction->update(['status' => 2]);

            return back()->with('error', $result['errors']['message'] ?? 'پرداخت ناموفق');
        }

        $code = data_get($result, 'data.code');

        // عدم موفقیت در Verify
        if ($code !== 100 && $code !== 101) {
            $transaction->update(['status' => 2]);

            return back()->with('error', 'تأیید پرداخت ناموفق بود');
        }

        // پرداخت موفق
        $transaction->update([
            'status' => 1,
            'ref_number' => data_get($result, 'data.ref_id'),
        ]);

        $transaction->order->update([
            'status' => 1,
            'payment_status' => 1,
        ]);

        session()->forget('cart');

        return redirect()->route('index')->with('success', 'پرداخت با موفقیت انجام شد');
    }
}

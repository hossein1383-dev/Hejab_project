<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CatrController extends Controller
{
    /**
     * نمایش صفحه سبد خرید
     */
    public function index(Request $request)
    {
        $addresses = UserAddress::where('user_id', Auth::id())->get();
        $cart = session('cart', []);

        // محاسبه مجموع قیمت‌ها، تخفیف و قیمت نهایی برای نمایش اولیه
        $totals = $this->calculateTotals($cart);

        // اگر سبد خرید خالی نیست ولی totals صفر است، لاگ می‌کنیم
        if (!empty($cart) && $totals['total_price'] == 0) {
            Log::warning('Totals calculation returned zero despite non-empty cart', [
                'cart_structure' => json_encode($cart),
                'totals' => $totals,
            ]);
        }

        return view('cart.index', compact('cart', 'addresses', 'totals'));
    }

    /**
     * افزایش تعداد یک محصول در سبد خرید (AJAX)
     */
    public function increment(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            if ($cart[$product->id]['qty'] >= $product->quantity) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'تعداد محصول مورد نظر بیشتر از حد مجاز می‌باشد',
                    ]);
                }
                return redirect()->back()->with('error', 'تعداد محصول بیشتر از موجودی است');
            }
            $cart[$product->id]['qty']++;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $product->quantity,
                'is_sale' => $product->is_sale,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'primary_image' => $product->primary_image,
                'qty' => 1,
            ];
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            $price = $cart[$product->id]['is_sale'] ? $cart[$product->id]['sale_price'] : $cart[$product->id]['price'];
            $itemTotal = $cart[$product->id]['qty'] * $price;
            $totals = $this->calculateTotals($cart);

            return response()->json([
                'success' => true,
                'message' => 'محصول به سبد خرید اضافه شد',
                'qty' => $cart[$product->id]['qty'],
                'item_total' => $itemTotal,
                'cart_count' => collect($cart)->sum('qty'),
                'total_price' => $totals['total_price'],
                'total_discount' => $totals['total_discount'],
                'final_price' => $totals['final_price'],
            ]);
        }

        return redirect()->back()->with('success', 'تعداد محصول افزایش یافت');
    }

    /**
     * افزودن محصول به سبد خرید (غیر AJAX)
     */
    public function add(Request $request)
    {
        // اعتبارسنجی ورودی (با افزودن min:1 برای جلوگیری از عدد منفی یا صفر)
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session('cart', []);

        // بررسی وجود محصول در سبد خرید
        if (isset($cart[$product->id])) {
            // جمع تعداد موجود در سبد با تعداد جدید
            $newQty = $cart[$product->id]['qty'] + $request->qty;

            // بررسی اینکه مجموع از موجودی انبار بیشتر نباشد
            if ($newQty > $product->quantity) {
                return redirect()->back()->with('error', 'تعداد کل محصول در سبد خرید بیشتر از حد مجاز می‌باشد');
            }

            // بروزرسانی تعداد در سبد
            $cart[$product->id]['qty'] = $newQty;
        } else {
            // در صورت عدم وجود، ابتدا بررسی ساده موجودی (مانند قبل)
            if ($request->qty > $product->quantity) {
                return redirect()->back()->with('error', 'تعداد محصول مورد نظر بیشتر از حد مجاز می‌باشد');
            }

            // افزودن محصول جدید به سبد خرید
            $cart[$product->id] = [
                'name' => $product->name,
                'quantity' => $product->quantity,
                'is_sale' => $product->is_sale,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'primary_image' => $product->primary_image,
                'qty' => $request->qty,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'محصول مورد نظر به سبد خرید اضافه شد');
    }

    /**
     * کاهش تعداد یک محصول در سبد خرید (AJAX)
     */
    public function decrement(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session('cart', []);

        if (!isset($cart[$product->id])) {
            return response()->json([
                'success' => false,
                'message' => 'محصول در سبد خرید یافت نشد',
            ]);
        }

        if ($cart[$product->id]['qty'] <= 1) {
            unset($cart[$product->id]);
            $removed = true;
            $itemTotal = 0;
            $qty = 0;
        } else {
            $cart[$product->id]['qty']--;
            $removed = false;
            $price = $cart[$product->id]['is_sale'] ? $cart[$product->id]['sale_price'] : $cart[$product->id]['price'];
            $itemTotal = $cart[$product->id]['qty'] * $price;
            $qty = $cart[$product->id]['qty'];
        }

        session()->put('cart', $cart);

        $totals = $this->calculateTotals($cart);

        return response()->json([
            'success' => true,
            'message' => $removed ? 'محصول از سبد خرید حذف شد' : 'تعداد محصول کاهش یافت',
            'qty' => $qty,
            'item_total' => $itemTotal,
            'removed' => $removed,
            'cart_count' => collect($cart)->sum('qty'),
            'total_price' => $totals['total_price'],
            'total_discount' => $totals['total_discount'],
            'final_price' => $totals['final_price'],
        ]);
    }

    /**
     * حذف یک محصول از سبد خرید (غیر AJAX)
     */
    public function remove(Request $request)
    {
        $cart = session('cart', []);

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'محصول مورد نظر از سبد خرید حذف شد');
    }

    /**
     * پاک کردن کل سبد خرید
     */
    public function clear(Request $request)
    {
        session()->put('cart', []);

        return redirect()->route('index')->with('success', 'سبد خرید با موفقیت حذف شد');
    }

    // ----------------------------------------------
    // تابع کمکی برای محاسبه جمع کل، تخفیف و قیمت نهایی
    // ----------------------------------------------
    private function calculateTotals($cart)
    {
        $totalPrice = 0;
        $totalDiscount = 0;
        $finalPrice = 0;

        foreach ($cart as $item) {
            // استفاده از ?? برای جلوگیری از خطا در صورت عدم وجود کلید
            $price = $item['price'] ?? 0;
            $salePrice = $item['sale_price'] ?? $price;
            $qty = $item['qty'] ?? 0;
            $isSale = $item['is_sale'] ?? false;

            // اگر قیمت یا تعداد صفر باشد، محاسبه را ادامه نده
            if ($price == 0 || $qty == 0) {
                continue;
            }

            $itemOriginalTotal = $price * $qty;
            $itemFinalTotal = $isSale ? $salePrice * $qty : $itemOriginalTotal;
            $discount = $itemOriginalTotal - $itemFinalTotal;

            $totalPrice += $itemOriginalTotal;
            $totalDiscount += $discount;
            $finalPrice += $itemFinalTotal;
        }

        return [
            'total_price' => $totalPrice,
            'total_discount' => $totalDiscount,
            'final_price' => $finalPrice,
        ];
    }
}

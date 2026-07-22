<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CatrController extends Controller
{
    // ✅ لیست دسته‌بندی‌هایی که سایز دارند
    private function hasSize($product)
    {
        $categoriesWithSize = ['چادر', 'عبا']; // نام دسته‌بندی‌ها

        return in_array($product->category->name, $categoriesWithSize);
    }

    // ✅ تابع ساخت کلید سبد خرید
    private function getCartKey($productId, $size = null)
    {
        // اگر سایز وجود داشت، با productId و size کلید بساز
        if (!empty($size)) {
            return $productId . '_' . $size;
        }
        // اگر سایز نداشت، فقط با productId
        return $productId;
    }

    public function index(Request $request)
    {
        $addresses = UserAddress::where('user_id', Auth::id())->get();
        $cart = session('cart', []);
        $totals = $this->calculateTotals($cart);

        if (!empty($cart) && $totals['total_price'] == 0) {
            Log::warning('Totals calculation returned zero despite non-empty cart', [
                'cart_structure' => json_encode($cart),
                'totals' => $totals,
            ]);
        }

        return view('cart.index', compact('cart', 'addresses', 'totals'));
    }

    public function increment(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'size' => 'nullable|string|max:50',
        ]);

        $product = Product::with('category')->findOrFail($request->product_id);
        $cart = session('cart', []);

        // ✅ بررسی سایز
        $size = null;
        if ($this->hasSize($product)) {
            // اگر محصول سایز دارد و کاربر سایز نفرستاده، L بگذار
            $size = $request->size ?: 'L';
        } else {
            // اگر محصول سایز ندارد، سایز را null بگذار (حتی اگر کاربر فرستاده باشد)
            $size = null;
        }

        $cartKey = $this->getCartKey($request->product_id, $size);

        if (isset($cart[$cartKey])) {
            if ($cart[$cartKey]['qty'] >= $product->quantity) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'تعداد محصول مورد نظر بیشتر از حد مجاز می‌باشد',
                    ]);
                }
                return redirect()->back()->with('error', 'تعداد محصول بیشتر از موجودی است');
            }
            $cart[$cartKey]['qty']++;
        } else {
            $cart[$cartKey] = [
                'productId' => $product->id,
                'name' => $product->name,
                'quantity' => $product->quantity,
                'is_sale' => $product->is_sale,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'primary_image' => $product->primary_image,
                'size' => $this->hasSize($product) ? $size : null,

                'qty' => 1,
            ];

            // ✅ فقط اگر سایز دارد، size را ذخیره کن
            if ($this->hasSize($product)) {
                $cart[$cartKey]['size'] = $size;
            }
        }

        session()->put('cart', $cart);

        if ($request->ajax()) {
            $price = $cart[$cartKey]['is_sale'] ? $cart[$cartKey]['sale_price'] : $cart[$cartKey]['price'];
            $itemTotal = $cart[$cartKey]['qty'] * $price;
            $totals = $this->calculateTotals($cart);

            return response()->json([
                'success' => true,
                'message' => 'محصول به سبد خرید اضافه شد',
                'qty' => $cart[$cartKey]['qty'],
                'item_total' => $itemTotal,
                'cart_count' => collect($cart)->sum('qty'),
                'total_price' => $totals['total_price'],
                'total_discount' => $totals['total_discount'],
                'final_price' => $totals['final_price'],
            ]);
        }

        return redirect()->back()->with('success', 'تعداد محصول افزایش یافت');
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer|min:1',
            'size' => 'nullable|string|max:50',
        ]);

        $product = Product::with('category')->findOrFail($request->product_id);
        $cart = session('cart', []);

        // ✅ بررسی سایز
        $size = null;
        if ($this->hasSize($product)) {
            // اگر محصول سایز دارد و کاربر سایز نفرستاده، L بگذار
            $size = $request->size ?: 'L';
        } else {
            // اگر محصول سایز ندارد، سایز را null بگذار
            $size = null;
        }

        $cartKey = $this->getCartKey($request->product_id, $size);

        if (isset($cart[$cartKey])) {
            $newQty = $cart[$cartKey]['qty'] + $request->qty;
            if ($newQty > $product->quantity) {
                return redirect()->back()->with('error', 'تعداد کل محصول در سبد خرید بیشتر از حد مجاز می‌باشد');
            }
            $cart[$cartKey]['qty'] = $newQty;
        } else {
            if ($request->qty > $product->quantity) {
                return redirect()->back()->with('error', 'تعداد محصول مورد نظر بیشتر از حد مجاز می‌باشد');
            }

            $cart[$cartKey] = [
                'productId' => $product->id,
                'name' => $product->name,
                'quantity' => $product->quantity,
                'is_sale' => $product->is_sale,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'primary_image' => $product->primary_image,
                'size' => $this->hasSize($product) ? $size : null,
                // ✅ ذخیره می‌کنیم که سایز دارد یا نه
                'qty' => $request->qty,
            ];

            // ✅ فقط اگر سایز دارد، size را ذخیره کن
            if ($this->hasSize($product)) {
                $cart[$cartKey]['size'] = $size;
            }
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'محصول مورد نظر به سبد خرید اضافه شد');
    }

    public function decrement(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'size' => 'nullable|string|max:50',
        ]);

        $cart = session('cart', []);
        $product = Product::with('category')->find($request->product_id);

        // ✅ بررسی سایز
        $size = null;
        if ($product && $this->hasSize($product)) {
            $size = $request->size ?: 'L';
        }

        $cartKey = $this->getCartKey($request->product_id, $size);

        if (!isset($cart[$cartKey])) {
            return response()->json([
                'success' => false,
                'message' => 'محصول در سبد خرید یافت نشد',
            ]);
        }

        if ($cart[$cartKey]['qty'] <= 1) {
            unset($cart[$cartKey]);
            $removed = true;
            $itemTotal = 0;
            $qty = 0;
        } else {
            $cart[$cartKey]['qty']--;
            $removed = false;
            $price = $cart[$cartKey]['is_sale'] ? $cart[$cartKey]['sale_price'] : $cart[$cartKey]['price'];
            $itemTotal = $cart[$cartKey]['qty'] * $price;
            $qty = $cart[$cartKey]['qty'];
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

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'size' => 'nullable|string|max:50',
        ]);

        $cart = session('cart', []);
        $product = Product::with('category')->find($request->product_id);

        // بررسی سایز
        $size = null;
        if ($product && $this->hasSize($product)) {
            $size = $request->size ?: 'L';
        }

        $cartKey = $this->getCartKey($request->product_id, $size);

        if (isset($cart[$cartKey])) {
            unset($cart[$cartKey]);
        }

        session()->put('cart', $cart);

        // اگر درخواست AJAX است
        if ($request->ajax() || $request->wantsJson()) {
            // محاسبه مجدد مجموع‌ها
            $totals = $this->calculateTotals($cart);

            return response()->json([
                'success' => true,
                'message' => 'محصول مورد نظر از سبد خرید حذف شد',
                'cart_count' => count($cart),
                'total_price' => $totals['total_price'],
                'total_discount' => $totals['total_discount'],
                'final_price' => $totals['final_price'],
                'removed' => true,
            ]);
        }

        return redirect()->back()->with('success', 'محصول مورد نظر از سبد خرید حذف شد');
    }

    public function clear(Request $request)
    {
        session()->put('cart', []);
        return redirect()->route('index')->with('success', 'سبد خرید با موفقیت حذف شد');
    }

    private function calculateTotals($cart)
    {
        $totalPrice = 0;
        $totalDiscount = 0;
        $finalPrice = 0;

        foreach ($cart as $item) {
            $price = $item['price'] ?? 0;
            $salePrice = $item['sale_price'] ?? $price;
            $qty = $item['qty'] ?? 0;
            $isSale = $item['is_sale'] ?? false;

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

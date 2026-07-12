<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UserAddress;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CatrController extends Controller
{
    public function index(Request $request)
    {
        $addresses = UserAddress::all();
        // dd($addresses);
        $cart = $request->Session()->get('cart');

        return view('cart.index', compact('cart', 'addresses'));
    }

    public function increment(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            if ($cart[$product->id]['qty'] >= $product->quantity) {
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'تعداد محصول مورد نظر بیشتر از حد مجاز می باشد',
                    ]);
                }
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

            $cartTotal = collect($cart)->sum(function ($item) {
                $price = $item['is_sale'] ? $item['sale_price'] : $item['price'];

                return $item['qty'] * $price;
            });
            return response()->json([
                'success' => true,
                'message' => 'محصول به سبد خرید اضافه شد',
                'qty' => $cart[$product->id]['qty'],
                'item_total' => $itemTotal,
                'cart_total' => $cartTotal,
                'cart_count' => collect($cart)->sum('qty'),
            ]);
        }
    }
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'qty' => 'required|integer',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($request->qty >= $product->quantity) {
            return redirect()->back()->with('error', 'تعداد محصول مورد نظر بیشتر از حد مجاز می باشد');
        }

        $cart = $request->Session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] = $request->qty;
        } else {
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

        $request->Session()->put('cart', $cart);

        return redirect()->back()->with('success', 'محصول مورد نظر به سبد خرید اضافه شد');
    }
    public function decrement(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        $cart = session()->get('cart', []);

        if (!isset($cart[$product->id])) {
            return response()->json([
                'success' => false,
                'message' => 'محصول در سبد خرید یافت نشد',
            ]);
        }

        if ($cart[$product->id]['qty'] <= 1) {
            return response()->json([
                'success' => false,
                'message' => 'تعداد محصول کمتر از 1 نمی‌تواند باشد',
            ]);
        }

        $cart[$product->id]['qty']--;

        session()->put('cart', $cart);

        $price = $cart[$product->id]['is_sale'] ? $cart[$product->id]['sale_price'] : $cart[$product->id]['price'];

        $itemTotal = $cart[$product->id]['qty'] * $price;

        $cartTotal = collect($cart)->sum(function ($item) {
            $price = $item['is_sale'] ? $item['sale_price'] : $item['price'];

            return $item['qty'] * $price;
        });

        return response()->json([
            'success' => true,
            'message' => 'محصول به سبد خرید اضافه شد',
            'qty' => $cart[$product->id]['qty'],
            'item_total' => $itemTotal,
            'cart_total' => $cartTotal,
            'cart_count' => collect($cart)->sum('qty'),
        ]);
    }

    public function remove(Request $request)
    {
        $cart = $request->session()->get('cart');
        // dd($request->all());

        if (isset($cart[$request->product_id])) {
            unset($cart[$request->product_id]);
        }

        $request->Session()->put('cart', $cart);

        return redirect()->back()->with('success', 'محصول مورد نظر از سبد خرید حذف شد');
    }
    public function clear(Request $request)
    {
        $request->Session()->put('cart', []);

        return redirect()->route('index')->with('success', ' سبد خرید با موفقیت حذف شذ');
    }
}



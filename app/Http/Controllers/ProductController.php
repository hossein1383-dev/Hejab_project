<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(Product $product)
    {
        // $products = Product::get();
        $randomProduct = Product::where('quantity', '>', 0)->where('status', 1)->inRandomOrder()->take(6)->get();
        return view('products.show', compact('product', 'randomProduct'));
    }

    public function menu()
    {
        $products = Product::filter()->paginate(12);
        $categories = Category::all();
        if (request()->ajax()) {
            return response()->json([
                'products' => view('partials.products', compact('products'))->render(),

                'filters' => view('partials.remove-filter')->render(),

                'mobileFilters' => view('partials.mobile-filters', compact('categories'))->render(),
            ]);
        }

        return view('products.menu', compact('products', 'categories'));
    }
}

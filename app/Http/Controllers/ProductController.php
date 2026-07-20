<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->where('status', 1)->firstOrFail()->load('images', 'sizes');
        // dd($product->images);
        $randomProducts = Product::where('quantity', '>', 0)->where('status', 1)->where('id', '!=', $product->id)->inRandomOrder()->take(12)->get();

        $desc = $product->formatted_description;

        return response()->view('products.show', compact('product', 'randomProducts', 'desc'))->header('Cache-Control', 'no-cache, no-store, must-revalidate')->header('Pragma', 'no-cache')->header('Expires', '0');
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

    public function showChador()
    {
        $products = Product::where('category_id', 3)->where('status', 1)->orderBy('id')->paginate(12);
        return view('products.chador', compact('products', 'desc'));
    }
    public function showAba()
    {
        $products = Product::where('category_id', 2)->where('status', 1)->orderBy('id')->paginate(12);

        return view('products.aba', compact('products'));
    }
    public function showRosary()
    {
        $products = Product::where('category_id', 1)->where('status', 1)->orderBy('id')->paginate(12);

        return view('products.rosary', compact('products'));
    }
}

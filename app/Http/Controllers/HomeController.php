<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $bestSellers = Product::orderByDesc('sold_count')->limit(6)->get();
        // dd($bestSellers);
        return view('home.index', compact('bestSellers'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::where('is_featured', 1)
                                   ->where('is_active', 1)
                                   ->take(8)
                                   ->get();

        $categories = Category::all();

        $latestProducts = Product::where('is_active', 1)
                                 ->latest()
                                 ->take(8)
                                 ->get();

        return view('home', compact('featuredProducts', 'categories', 'latestProducts'));
    }
}

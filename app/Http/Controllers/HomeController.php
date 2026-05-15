<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Display homepage
     */
    public function index()
    {
        // Featured products
        $featuredProducts = Product::query()
            ->where('is_featured', '=', true)
            ->where('is_active', '=', true)
            ->limit(8)
            ->get();

        // Latest products
        $latestProducts = Product::query()
        ->where('is_active', true)
        ->orderByDesc('idProduct') // ← instead of created_at
        ->limit(8)
        ->get();

        // Categories
        $categories = Category::all();

        // Best selling products
        $bestSellingProducts = Product::query()
    ->whereHas('orderItems')
    ->where('is_active', true)
    ->withCount(['orderItems as total_sold' => function ($query) {
        $query->select(DB::raw('SUM(quantity)'));
    }])
    ->orderByDesc('total_sold')
    ->limit(8)
    ->get();

        return view('home', [
            'featured_products'     => $featuredProducts,
            'latest_products'       => $latestProducts,
            'categories'            => $categories,
            'best_selling_products' => $bestSellingProducts,
        ]);
    }
}

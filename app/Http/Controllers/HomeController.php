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
    $featuredProducts = Product::where('is_featured', true)
        ->where('is_active', true)
        ->limit(8)
        ->get();

    // Latest products
    $latestProducts = Product::where('is_active', true)
        ->orderBy('created_at', 'desc') // ou idProduct si pas de timestamps
        ->limit(8)
        ->get();

    // Categories
    $categories = Category::all();
    // Best selling products
    $bestSellingProducts = Product::join('order_items', 'products.idProduct', '=', 'order_items.product_id')
        ->where('products.is_active', true)
        ->select(
            'products.idProduct',
            'products.nameProduct',
            'products.priceProduct',
            'products.imageProduct',
            DB::raw('SUM(order_items.quantity) as total_sold')
        )
        ->groupBy(
            'products.idProduct',
            'products.nameProduct',
            'products.priceProduct',
            'products.imageProduct'
        )
        ->orderByDesc('total_sold')
        ->limit(8)
        ->get();

    return view('home', compact(
        'featuredProducts',
        'latestProducts',
        'categories',
        'bestSellingProducts'
    ));
}
}

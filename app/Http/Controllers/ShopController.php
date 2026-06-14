<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Affiche la boutique avec le design spécifique défini dans shop.blade.php.
     */
    public function index()
    {
        $products = Product::all();
        return view('shop', compact('products'));
    }
}

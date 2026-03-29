<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $reviews = Review::where('is_approved', 1)
                         ->with('user')
                         ->latest()
                         ->take(6)
                         ->get();

        return view('about', compact('reviews'));
    }
}

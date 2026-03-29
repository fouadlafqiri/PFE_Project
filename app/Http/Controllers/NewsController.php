<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;

class NewsController extends Controller
{
    public function index()
    {
        // ✅ Removed is_published filter until migration runs
        $news = News::orderBy('created_at', 'desc')
                    ->paginate(6);

        $latestProducts = Product::where('is_active', true)
                                 ->orderBy('created_at', 'desc')
                                 ->limit(3)
                                 ->get();

        // ✅ Fixed view path: news.index not news
        return view('news.index', compact('news', 'latestProducts'));
    }
   public function show($id)
{
    $news = News::findOrFail($id);

    $recentNews = News::where('idNews', '!=', $id)
                     ->orderBy('created_at', 'desc')
                     ->limit(5)
                     ->get();

    $latestProducts = Product::where('is_active', true)
                             ->orderBy('created_at', 'desc')
                             ->limit(5)
                             ->get();

    // ✅ points to news/single-news.blade.php
    return view('news.single-news', compact('news', 'recentNews', 'latestProducts'));
}
}

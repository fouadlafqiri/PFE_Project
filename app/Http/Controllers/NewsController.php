<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::where('is_published', true)
                    ->orderBy('created_at', 'desc')
                    ->paginate(6);

        $latestProducts = Product::where('is_active', true)
                                 ->orderBy('created_at', 'desc')
                                 ->limit(3)
                                 ->get();

        return view('news.index', compact('news', 'latestProducts'));
    }
   public function show($id)
{
    $news = News::where('is_published', true)->findOrFail($id);

    $recentNews = News::where('idNews', '!=', $id)
                     ->where('is_published', true)
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

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_active', true);

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('idCategory', $request->category);
        }

        // Search by name
        if ($request->has('search') && $request->search != '') {
            $query->where('nameProduct', 'like', '%' . $request->search . '%');
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price != '') {
            $query->where('priceProduct', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price != '') {
            $query->where('priceProduct', '<=', $request->max_price);
        }

        // Sort products
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('priceProduct', 'asc');
                break;
            case 'price_high':
                $query->orderBy('priceProduct', 'desc');
                break;
            case 'name':
                $query->orderBy('nameProduct', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(12);
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }
    /**
     * Summary of showByCategory
     * @param mixed $idCategory
     * @return \Illuminate\Contracts\View\View
     */
    public function showByCategory($idCategory)
{
    $products = Product::where('idCategory', $idCategory)
        ->where('is_active', true)
        ->get();

    $category = Category::findOrFail($idCategory);

    return view('products.by-category', compact('products', 'category'));
}

    /**
     * Display single product details
     */
    public function show($productId)
    {
        $product = Product::with(['category', 'reviews.user'])
                         ->findOrFail($productId);

        // Get related products from same category
        $relatedProducts = Product::where('idCategory', $product->idCategory)
                                 ->where('idProduct', '!=', $product->idProduct)
                                 ->where('is_active', true)
                                 ->limit(4)
                                 ->get();

        // Calculate average rating
        $averageRating = $product->reviews()->where('is_approved', true)->avg('rating');
        $totalReviews = $product->reviews()->where('is_approved', true)->count();

        return view('products.show', compact('product', 'relatedProducts', 'averageRating', 'totalReviews'));
    }

    /**
     * Search products (AJAX)
     */
    public function search(Request $request)
    {
        $search = $request->get('q', '');

        $products = Product::where('nameProduct', 'like', '%' . $search . '%')
                          ->where('is_active', true)
                          ->limit(10)
                          ->get(['idProduct', 'nameProduct', 'priceProduct', 'imageProduct']);

        return response()->json($products);
    }

    /**
     * Display products by category
     */
    public function category($categoryId)
    {
        $category = Category::findOrFail($categoryId);

        $products = Product::where('idCategory', $categoryId)
                          ->where('is_active', true)
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        $categories = Category::all();

        return view('products.category', compact('products', 'category', 'categories'));
    }
}

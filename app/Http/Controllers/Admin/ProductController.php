<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display all products (Admin)
     */
    public function index()
    {
        $products = Product::with('category')->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show create product form
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store new product
     */
    public function store(Request $request)
{
    $request->merge([
        'is_active' => $request->has('is_active'),
        'is_featured' => $request->has('is_featured'),
    ]);

    $validated = $request->validate([
        'idCategory' => 'required|exists:categories,idCategory',
        'nameProduct' => 'required|string|max:255',
        'descriptionProduct' => 'nullable|string',
        'priceProduct' => 'required|numeric|min:0',
        'quantityProduct' => 'required|integer|min:0',
        'imageProduct' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ]);

    // Debug: Log validated data
    \Log::info('Validated Data:', $validated);

    if ($request->hasFile('imageProduct')) {

        $image = $request->file('imageProduct');

        $imageName = time().'_'.$image->getClientOriginalName();

        $dir = public_path('images/products');

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $image->move($dir, $imageName);

        $validated['imageProduct'] = $imageName;
    }

    Product::create($validated);

    // Debug: Log successful creation
    \Log::info('Product created successfully');

    return redirect()->route('admin.products.index')
        ->with('success', 'Product created successfully!');
}

    /**
     * Show edit product form
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update product
     */
    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $request->merge([
        'is_active' => $request->has('is_active'),
        'is_featured' => $request->has('is_featured'),
    ]);

    $validated = $request->validate([
        'idCategory' => 'required|exists:categories,idCategory',
        'nameProduct' => 'required|string|max:255',
        'descriptionProduct' => 'nullable|string',
        'priceProduct' => 'required|numeric|min:0',
        'quantityProduct' => 'required|integer|min:0',
        'imageProduct' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ]);

    // Handle image upload
    if ($request->hasFile('imageProduct')) {
        // Delete old image if it exists
        if ($product->imageProduct && file_exists(public_path('images/products/'.$product->imageProduct))) {
            unlink(public_path('images/products/'.$product->imageProduct));
        }

        // Save new image
        $image = $request->file('imageProduct');
        $imageName = time().'_'.$image->getClientOriginalName();
        $dir = public_path('images/products');

        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $image->move($dir, $imageName);
        $validated['imageProduct'] = $imageName;
    }

    $product->update($validated);

    return redirect()->route('admin.products.index')
        ->with('success', 'Product updated successfully!');
}
    /**
     * Delete product
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Delete image if exists
        if ($product->imageProduct && file_exists(public_path('images/products/'.$product->imageProduct))) {
            unlink(public_path('images/products/'.$product->imageProduct));
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Toggle product active status
     */
    public function toggleStatus($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = ! $product->is_active;
        $product->save();

        return back()->with('success', 'Product status updated!');
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured($id)
    {
        $product = Product::findOrFail($id);
        $product->is_featured = ! $product->is_featured;
        $product->save();

        return back()->with('success', 'Featured status updated!');
    }
}

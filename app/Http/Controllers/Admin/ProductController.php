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
        // Debug: Log incoming request data
        \Illuminate\Support\Facades\Log::info('Product Store Request:', $request->all());

        $validated = $request->validate([
            'idCategory' => 'required|exists:categories,idCategory',
            'nameProduct' => 'required|string|max:255',
            'descriptionProduct' => 'nullable|string',
            'priceProduct' => 'required|numeric|min:0',
            'quantityProduct' => 'required|integer|min:0',
            'imageProduct' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_featured' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
        ]);

        // Handle image upload
        if ($request->hasFile('imageProduct')) {
            $image = $request->file('imageProduct');
            $imageName = time().'_'.$image->getClientOriginalName();

            // Ensure directory exists
            $dir = public_path('images/products');
            if (! file_exists($dir)) {
                mkdir($dir, 0755, true);
            }

            $image->move($dir, $imageName);
            $validated['imageProduct'] = $imageName;
        }

        $validated['is_featured'] = $request->has('is_featured');
        $validated['is_active'] = $request->has('is_active');

        // Debug: Log validated data
        \Illuminate\Support\Facades\Log::info('Validated Data:', $validated);

        try {
            $product = Product::create($validated);
            \Illuminate\Support\Facades\Log::info('Product created successfully:', ['id' => $product->idProduct]);

            return redirect()->route('admin.products.index')
                ->with('success', 'Product created successfully!');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Product creation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to create product: ' . $e->getMessage())->withInput();
        }
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

    // image upload ...

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

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display all categories
     */
    public function index()
    {
        $categories = Category::orderBy('created_at', 'desc')->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show create category form
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store new category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nameCategory' => 'required|string|max:255|unique:categories,nameCategory',
            'descriptionCategory' => 'nullable|string',
            'imageCategory' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('imageCategory')) {
            $image = $request->file('imageCategory');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/categories'), $imageName);
            $validated['imageCategory'] = $imageName;
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category created successfully!');
    }

    /**
     * Show edit category form
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update category
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $validated = $request->validate([
            'nameCategory' => 'required|string|max:255|unique:categories,nameCategory,' . $id . ',idCategory',
            'descriptionCategory' => 'nullable|string',
            'imageCategory' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('imageCategory')) {
            // Delete old image if exists
            if ($category->imageCategory && file_exists(public_path('images/categories/' . $category->imageCategory))) {
                unlink(public_path('images/categories/' . $category->imageCategory));
            }

            $image = $request->file('imageCategory');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/categories'), $imageName);
            $validated['imageCategory'] = $imageName;
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category updated successfully!');
    }

    /**
     * Delete category
     */
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        // Check if category has products
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing products!');
        }

        // Delete image if exists
        if ($category->imageCategory && file_exists(public_path('images/categories/' . $category->imageCategory))) {
            unlink(public_path('images/categories/' . $category->imageCategory));
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Category deleted successfully!');
    }
}

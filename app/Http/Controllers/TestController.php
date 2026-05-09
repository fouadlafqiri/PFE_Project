<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function testCreateProduct(Request $request)
    {
        Log::info('Test endpoint called', $request->all());

        $validated = $request->validate([
            'idCategory' => 'required|exists:categories,idCategory',
            'nameProduct' => 'required|string|max:255',
            'priceProduct' => 'required|numeric|min:0',
            'quantityProduct' => 'required|integer|min:0',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'success' => true,
            'product_id' => $product->idProduct,
            'message' => 'Product created successfully!'
        ]);
    }
}

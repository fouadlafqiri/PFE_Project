<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store a new review
     */
    public function store(Request $request, $productId)
    {
        // Validate request
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($productId);

        // Check if user has already reviewed this product
        $existingReview = Review::where('user_id', Auth::id())
                               ->where('product_id', $productId)
                               ->first();

        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this product!');
        }

        // Optional: Check if user has purchased this product
        // Uncomment below to enforce this rule
        /*
        $hasPurchased = Order::where('user_id', Auth::id())
                            ->whereHas('orderItems', function($query) use ($productId) {
                                $query->where('product_id', $productId);
                            })
                            ->where('status', 'delivered')
                            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'You can only review products you have purchased!');
        }
        */

        // Create review
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_approved' => false, // Admin needs to approve
        ]);

        return back()->with('success', 'Thank you! Your review has been submitted and is pending approval.');
    }

    /**
     * Update existing review
     */
    public function update(Request $request, $reviewId)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review = Review::findOrFail($reviewId);

        // Check if review belongs to current user
        if ($review->user_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action!');
        }

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'is_approved' => false, // Re-submit for approval after edit
        ]);

        return back()->with('success', 'Your review has been updated and is pending approval.');
    }

    /**
     * Delete review
     */
    public function destroy($reviewId)
    {
        $review = Review::findOrFail($reviewId);

        // Check if review belongs to current user
        if ($review->user_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action!');
        }

        $review->delete();

        return back()->with('success', 'Your review has been deleted.');
    }
}

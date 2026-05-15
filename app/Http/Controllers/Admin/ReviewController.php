<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    /**
     * Display all reviews for approval
     */
    public function index()
    {
        $pendingReviews = Review::with(['user', 'product'])
                                ->where('is_approved', false)
                                ->latest()
                                ->paginate(15);

        $approvedReviews = Review::with(['user', 'product'])
                                 ->where('is_approved', true)
                                 ->latest()
                                 ->paginate(15);

        return view('admin.reviews.index', compact('pendingReviews', 'approvedReviews'));
    }

    /**
     * Approve a review
     */
    public function approve($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->update(['is_approved' => true]);

        return back()->with('success', 'Avis approuvé avec succès!');
    }

    /**
     * Reject a review
     */
    public function reject($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->delete();

        return back()->with('success', 'Avis rejeté et supprimé!');
    }

    /**
     * Toggle approval status
     */
    public function toggle($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $review->update(['is_approved' => !$review->is_approved]);

        $status = $review->is_approved ? 'approuvé' : 'désapprouvé';
        return back()->with('success', "Avis {$status}!");
    }
}

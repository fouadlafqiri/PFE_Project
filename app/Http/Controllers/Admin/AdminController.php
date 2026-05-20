<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Category;
use App\Models\Review;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->role === 'livreur') {
            return redirect()->route('admin.orders.index');
        }

        $stats = [
            'total_users'    => \Illuminate\Foundation\Auth\User::count(),
            'total_products' => Product::count(),
            'total_orders'   => Order::count(),
            'total_revenue'  => Order::where('payment_status', 'paid')
                                     ->sum('total_amount'),

            'pending_orders'    => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::where('status', 'processing')->count(),
            'shipped_orders'    => Order::where('status', 'shipped')->count(),
            'delivered_orders'  => Order::where('status', 'delivered')->count(),
        ];

        $recentOrders = Order::with('user')
                             ->latest()
                             ->take(10)
                             ->get();

        $latestProducts = Product::with('category')
                                 ->latest()
                                 ->take(5)
                                 ->get();

        return view('admin.index', compact('stats', 'recentOrders', 'latestProducts'));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($request->only('name', 'email'));

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}

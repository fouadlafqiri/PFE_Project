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
        $delivery = null;

        if ($user->role === 'livreur') {
            $delivery = \App\Models\Delivery::where('email', $user->email)->first();
        }

        return view('admin.profile', compact('user', 'delivery'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $delivery = null;

        if ($user->role === 'livreur') {
            $delivery = \App\Models\Delivery::where('email', $user->email)->first();
        }

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ];

        if ($user->role === 'livreur') {
            $rules['status'] = 'required|in:active,inactive,on_delivery';
            $rules['vehicle_type'] = 'required|in:bike,car,truck';
            $rules['vehicle_number'] = 'nullable|string|max:50';

            if ($delivery) {
                $rules['email'] .= '|unique:deliveries,email,' . $delivery->idDelivery . ',idDelivery';
            } else {
                $rules['email'] .= '|unique:deliveries,email';
            }
        }

        $validated = $request->validate($rules);

        $user->update([
            'name'  => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? $user->phone,
        ]);

        if ($user->role === 'livreur') {
            $deliveryData = [
                'name'           => $validated['name'],
                'email'          => $validated['email'],
                'phone'          => $validated['phone'] ?? $delivery->phone ?? null,
                'status'         => $validated['status'],
                'vehicle_type'   => $validated['vehicle_type'],
                'vehicle_number' => $validated['vehicle_number'] ?? ($delivery->vehicle_number ?? null),
            ];

            if ($delivery) {
                $delivery->update($deliveryData);
            } else {
                \App\Models\Delivery::create($deliveryData);
            }
        }

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}

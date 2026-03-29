<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display order details
     */
    public function show($orderId)
    {
        $order = Order::with(['orderItems.product.category', 'user'])
                     ->findOrFail($orderId);

        // Verify order belongs to current user
        if ($order->user_id != Auth::id()) {
            abort(403, 'Unauthorized access to this order.');
        }

        return view('orders.show', compact('order'));
    }

    /**
     * Cancel order (only if status is pending)
     */
    public function cancel($orderId)
    {
        $order = Order::findOrFail($orderId);

        // Verify order belongs to current user
        if ($order->user_id != Auth::id()) {
            return back()->with('error', 'Unauthorized action!');
        }

        // Can only cancel if order is pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'Cannot cancel order. Order is already ' . $order->status);
        }

        // Restore product stock
        foreach ($order->orderItems as $orderItem) {
            $product = $orderItem->product;
            $product->quantityProduct += $orderItem->quantity;
            $product->save();
        }

        // Update order status
        $order->status = 'cancelled';
        $order->save();

        return back()->with('success', 'Order cancelled successfully. Stock has been restored.');
    }

    /**
     * Track order status
     */
    public function track(Request $request)
    {
        $orderNumber = $request->input('order_number');

        if (!$orderNumber) {
            return view('orders.track');
        }

        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return view('orders.track')->with('error', 'Order not found!');
        }

        return view('orders.track', compact('order'));
    }
}

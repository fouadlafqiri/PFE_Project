<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display all orders
     */
    public function index(Request $request)
    {
        $query = Order::with('user')->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by payment status
        if ($request->has('payment_status') && $request->payment_status != '') {
            $query->where('payment_status', $request->payment_status);
        }

        // Search by order number or customer name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_number', 'like', '%' . $search . '%')
                  ->orWhere('customer_name', 'like', '%' . $search . '%')
                  ->orWhere('customer_email', 'like', '%' . $search . '%');
            });
        }

        $orders = $query->paginate(20);

        // Get order statistics
        $stats = [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'processing' => Order::where('status', 'processing')->count(),
            'shipped' => Order::where('status', 'shipped')->count(),
            'delivered' => Order::where('status', 'delivered')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats'));
    }

    /**
     * Display order details
     */
    public function show($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled',
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;

        // If cancelling order, restore stock
        if ($validated['status'] == 'cancelled' && $oldStatus != 'cancelled') {
            foreach ($order->orderItems as $orderItem) {
                $product = $orderItem->product;
                $product->quantityProduct += $orderItem->quantity;
                $product->save();
            }
        }

        // If un-cancelling order, reduce stock again
        if ($oldStatus == 'cancelled' && $validated['status'] != 'cancelled') {
            foreach ($order->orderItems as $orderItem) {
                $product = $orderItem->product;
                $product->quantityProduct -= $orderItem->quantity;
                $product->save();
            }
        }

        $order->status = $validated['status'];
        $order->save();

        return back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Update payment status
     */
    public function updatePaymentStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,failed',
        ]);

        $order = Order::findOrFail($id);

        $oldPaymentStatus = $order->payment_status;
        $order->payment_status = $validated['payment_status'];

        // Si paiement devient payé => commande livrée
        if ($oldPaymentStatus !== 'paid' && $order->payment_status === 'paid') {
            $order->status = 'delivered';
        }

        $order->save();

        return back()->with('success', 'Payment status updated successfully!');
    }

    /**
     * Delete order
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);

        // Restore stock if order is not cancelled
        if ($order->status != 'cancelled') {
            foreach ($order->orderItems as $orderItem) {
                $product = $orderItem->product;
                $product->quantityProduct += $orderItem->quantity;
                $product->save();
            }
        }

        $order->delete();

        return redirect()->route('admin.orders.index')
                        ->with('success', 'Order deleted successfully!');
    }

    /**
     * Generate invoice (basic example)
     */
    public function invoice($id)
    {
        $order = Order::with(['user', 'orderItems.product'])->findOrFail($id);
        return view('admin.orders.invoice', compact('order'));
    }
}

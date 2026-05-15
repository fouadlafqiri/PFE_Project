<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Show checkout page
     */
    public function index()
    {
        // Require authentication for checkout
        if (!Auth::check()) {
            return redirect()->route('login')->with('message', 'Please login to continue checkout.');
        }

        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        // Check if all products are still in stock
        foreach ($cart->cartItems as $item) {
            if (!$item->product->hasStock($item->quantity)) {
                return redirect()->route('cart.index')
                    ->with('error', 'Some items in your cart are out of stock. Please update your cart.');
            }
        }

        $cartItems = $cart->cartItems()->with('product')->get();
        $total = $cart->getTotal();
        $user = Auth::user();

        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }

    /**
     * Process checkout and create order
     */
    public function process(Request $request)
    {
        // Copier l'adresse de facturation si la livraison utilise la même adresse
        if ($request->filled('same_address')) {
            $request->merge([
                'shipping_address' => $request->input('billing_address'),
            ]);
        }

        // Normaliser le numéro de carte pour validation
        if ($request->input('payment_method') === 'credit_card') {
            $request->merge([
                'card_number' => str_replace(' ', '', $request->input('card_number')),
            ]);
        }

        // Validate request
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'billing_address' => 'required|string|max:500',
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|in:cash_on_delivery,credit_card,bank_transfer',
            'card_number' => 'required_if:payment_method,credit_card|nullable|regex:/^[0-9]{16}$/',
            'card_holder' => 'nullable|string|max:255',
            'expiry_date' => 'nullable|string|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'nullable|regex:/^\d{3,4}$/',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Votre panier est vide!');
        }

        DB::beginTransaction();
        try {
            // Verify stock availability again
            foreach ($cart->cartItems as $cartItem) {
                $product = $cartItem->product;

                if (!$product->hasStock($cartItem->quantity)) {
                    throw new \Exception("Désolé, {$product->nameProduct} n'est pas en stock ou quantité insuffisante.");
                }
            }

            // Calculate total
            $totalAmount = 0;
            foreach ($cart->cartItems as $cartItem) {
                $totalAmount += $cartItem->quantity * $cartItem->product->priceProduct;
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $totalAmount,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'cash_on_delivery' ? 'pending' : 'paid',
                'shipping_address' => $validated['shipping_address'],
                'billing_address' => $validated['billing_address'],
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'notes' => $validated['notes'] ?? null,
            ]);

            // Create order items and reduce stock
            foreach ($cart->cartItems as $cartItem) {
                $product = $cartItem->product;

                // Create order item
                OrderItem::create([
                    'order_id' => $order->idOrder,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->priceProduct,
                    'subtotal' => $cartItem->quantity * $product->priceProduct,
                ]);

                // Reduce product stock
                $product->quantityProduct -= $cartItem->quantity;
                $product->save();
            }

            // Clear cart after successful order
            $cart->cartItems()->delete();

            DB::commit();

            // Redirect to order success page
            return redirect()->route('order.success', $order->idOrder)
                           ->with('success', 'Commande passée avec succès! Numéro de commande: ' . $order->order_number);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Show order success page
     */
    public function success($orderId)
    {
        $order = Order::with('orderItems.product')->findOrFail($orderId);

        // Verify order belongs to current user
        if ($order->user_id != Auth::id()) {
            abort(403, 'Unauthorized access to order.');
        }

        return view('checkout.success', compact('order'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $cart      = $this->getCart();
        $cartItems = $cart ? $cart->cartItems()->with('product.category')->get() : collect();

        $subtotal   = $cartItems->sum(fn($item) => $item->product->priceProduct * $item->quantity);
        $shipping   = $subtotal >= 75 ? 0 : 45;
        $total      = $subtotal + $shipping;
        $totalItems = $cartItems->sum('quantity');

        return view('cart.index', compact('cartItems', 'subtotal', 'shipping', 'total', 'totalItems'));
    }

    /**
     * Add product to cart
     */
    public function add(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        $product  = Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1);

        if (!$product->is_active) {
            return back()->with('error', 'Ce produit n\'est pas disponible.');
        }

        if (!$product->hasStock($quantity)) {
            return back()->with('error', 'Stock insuffisant. Seulement ' . $product->quantityProduct . ' articles disponibles.');
        }

        $cart     = $this->getOrCreateCart();
        $cartItem = CartItem::where('cart_id', $cart->idCart)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;

            if (!$product->hasStock($newQuantity)) {
                return back()->with('error', 'Stock insuffisant. Seulement ' . $product->quantityProduct . ' articles disponibles.');
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id'    => $cart->idCart,
                'product_id' => $productId,
                'quantity'   => $quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Produit ajouté au panier !');
    }

    /**
     * Update cart item quantity
     */
    public function update(Request $request, $cartItemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:0'
        ]);

        $cartItem = CartItem::findOrFail($cartItemId);
        $quantity = $request->input('quantity');

        if (!$this->verifyCartOwnership($cartItem->cart_id)) {
            return back()->with('error', 'Action non autorisée.');
        }

        if ($quantity <= 0) {
            $cartItem->delete();
            return back()->with('success', 'Article supprimé du panier.');
        }

        $product = $cartItem->product;
        if (!$product->hasStock($quantity)) {
            return back()->with('error', 'Stock insuffisant. Seulement ' . $product->quantityProduct . ' articles disponibles.');
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return back()->with('success', 'Panier mis à jour !');
    }

    /**
     * Remove item from cart
     */
    public function remove($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);

        if (!$this->verifyCartOwnership($cartItem->cart_id)) {
            return back()->with('error', 'Action non autorisée.');
        }

        $cartItem->delete();

        return back()->with('success', 'Article supprimé du panier.');
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        $cart = $this->getCart();

        if ($cart) {
            $cart->cartItems()->delete();
            return back()->with('success', 'Panier vidé avec succès.');
        }

        return back()->with('error', 'Le panier est déjà vide.');
    }

    /**
     * Get cart item count (for navbar badge)
     */
    public function count()
    {
        $cart  = $this->getCart();
        $count = $cart ? $cart->getTotalItems() : 0;

        return response()->json(['count' => $count]);
    }

    // -------------------------------------------------------
    // Private Helpers
    // -------------------------------------------------------

    private function getCart()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->first();
        }

        return Cart::where('session_id', session()->getId())->first();
    }

    private function getOrCreateCart()
    {
        $cart = $this->getCart();

        if (!$cart) {
            $cart = Cart::create([
                'user_id'    => Auth::check() ? Auth::id() : null,
                'session_id' => !Auth::check() ? session()->getId() : null,
            ]);
        }

        return $cart;
    }

    private function verifyCartOwnership($cartId)
    {
        $cart = Cart::find($cartId);

        if (!$cart) return false;

        if (Auth::check()) {
            return $cart->user_id == Auth::id();
        }

        return $cart->session_id == session()->getId();
    }
public function applyCoupon(Request $request)
{
    $request->validate([
        'coupon_code' => 'required'
    ]);

    $couponCode = strtoupper($request->coupon_code);

    // Valid coupon
    if ($couponCode === 'PROMO30') {

        // Get current cart
        $cart = $this->getCart();

        if (!$cart) {
            return back()->with('error', 'Panier vide.');
        }

        // Get cart items
        $cartItems = $cart->cartItems()->with('product')->get();

        // Calculate subtotal
        $subtotal = 0;

        foreach ($cartItems as $item) {

            $subtotal += $item->product->priceProduct * $item->quantity;

        }

        // 30% discount
        $discount = ($subtotal * 30) / 100;

        // Shipping
        $shipping = $subtotal >= 75 ? 0 : 45;

        // New total
        $newTotal = ($subtotal - $discount) + $shipping;

        // Save coupon session
        session()->put('coupon', [

            'code' => $couponCode,

            'discount_percent' => 30,

            'discount_amount' => $discount,

            'new_total' => $newTotal,

        ]);

        return back()->with('success', 'Coupon applied successfully!');
    }

    return back()->with('error', 'Invalid coupon code!');
}
}

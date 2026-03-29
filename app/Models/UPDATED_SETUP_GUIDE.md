# Laravel E-Commerce Setup Guide - Updated for Your Database

## 🎯 Your Current Database Structure:
- ✅ **users** table (already exists)
- ✅ **categories** table (already exists)
- ✅ **products** table (already exists)

## 📦 New Models to Add (5 models):

1. **Order** - Customer orders
2. **OrderItem** - Individual items in orders
3. **Cart** - Shopping cart
4. **CartItem** - Items in cart
5. **Review** - Product reviews

---

## 🚀 Installation Steps:

### Step 1: Copy Updated Models
Copy these model files to `app/Models/` in your Laravel project:

```
Updated_Category.php → app/Models/Category.php
Updated_Product.php → app/Models/Product.php
Updated_Order.php → app/Models/Order.php
Updated_OrderItem.php → app/Models/OrderItem.php
Updated_Cart.php → app/Models/Cart.php
Updated_CartItem.php → app/Models/CartItem.php
Updated_Review.php → app/Models/Review.php
```

### Step 2: Copy Migrations
Copy these migration files to `database/migrations/`:

```
create_orders_table.php → database/migrations/2024_02_15_000001_create_orders_table.php
create_order_items_table.php → database/migrations/2024_02_15_000002_create_order_items_table.php
create_carts_table.php → database/migrations/2024_02_15_000003_create_carts_table.php
create_cart_items_table.php → database/migrations/2024_02_15_000004_create_cart_items_table.php
create_reviews_table.php → database/migrations/2024_02_15_000005_create_reviews_table.php
```

**Note:** Update the date/time in the migration filenames to match today's date!

### Step 3: Update Your User Model
Add these relationships to your `app/Models/User.php`:

```php
public function orders()
{
    return $this->hasMany(Order::class, 'user_id', 'id');
}

public function reviews()
{
    return $this->hasMany(Review::class, 'user_id', 'id');
}

public function cart()
{
    return $this->hasOne(Cart::class, 'user_id', 'id');
}
```

### Step 4: Run Migrations

```bash
# Open terminal in your Laravel project directory
php artisan migrate
```

This will create the 5 new tables:
- orders
- order_items
- carts
- cart_items
- reviews

---

## 📊 Database Schema Overview:

### Your Existing Tables:

**categories**
- idCategory (PK)
- nameCategory
- descriptionCategory
- imageCategory

**products**
- idProduct (PK)
- idCategory (FK → categories.idCategory)
- nameProduct
- descriptionProduct
- priceProduct
- quantityProduct
- imageProduct

**users**
- id (PK)
- name
- email
- password

### New Tables to be Created:

**orders**
- idOrder (PK)
- user_id (FK → users.id)
- order_number (unique)
- total_amount
- status (pending/processing/shipped/delivered/cancelled)
- payment_method
- payment_status
- shipping_address
- billing_address
- customer_name
- customer_email
- customer_phone
- notes

**order_items**
- idOrderItem (PK)
- order_id (FK → orders.idOrder)
- product_id (FK → products.idProduct)
- quantity
- price
- subtotal

**carts**
- idCart (PK)
- user_id (FK → users.id, nullable)
- session_id (for guest users)

**cart_items**
- idCartItem (PK)
- cart_id (FK → carts.idCart)
- product_id (FK → products.idProduct)
- quantity

**reviews**
- idReview (PK)
- user_id (FK → users.id)
- product_id (FK → products.idProduct)
- rating (1-5)
- comment
- is_approved

---

## 🎨 Model Relationships:

```
Category (1) → (Many) Products
Product (1) → (Many) Reviews
Product (1) → (Many) OrderItems
Product (1) → (Many) CartItems
User (1) → (Many) Orders
User (1) → (Many) Reviews
User (1) → (1) Cart
Order (1) → (Many) OrderItems
Cart (1) → (Many) CartItems
```

---

## 💡 Next Steps - Create Controllers:

### 1. Generate Controllers

```bash
# Product & Category controllers (if you don't have them)
php artisan make:controller Admin/CategoryController --resource
php artisan make:controller Admin/ProductController --resource

# Shopping cart controller
php artisan make:controller CartController

# Order controllers
php artisan make:controller CheckoutController
php artisan make:controller OrderController

# Review controller
php artisan make:controller ReviewController
```

### 2. Example Cart Controller Methods

Create `app/Http/Controllers/CartController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // View cart
    public function index()
    {
        $cart = $this->getCart();
        $cartItems = $cart ? $cart->cartItems()->with('product')->get() : [];
        $total = $cart ? $cart->getTotal() : 0;
        
        return view('cart.index', compact('cartItems', 'total'));
    }

    // Add to cart
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $quantity = $request->input('quantity', 1);

        // Check stock
        if (!$product->hasStock($quantity)) {
            return back()->with('error', 'Not enough stock available!');
        }

        $cart = $this->getOrCreateCart();
        
        // Check if product already in cart
        $cartItem = CartItem::where('cart_id', $cart->idCart)
                            ->where('product_id', $productId)
                            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id' => $cart->idCart,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return back()->with('success', 'Product added to cart!');
    }

    // Update cart item quantity
    public function update(Request $request, $cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $quantity = $request->input('quantity');

        if ($quantity <= 0) {
            $cartItem->delete();
        } else {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        return back()->with('success', 'Cart updated!');
    }

    // Remove from cart
    public function remove($cartItemId)
    {
        $cartItem = CartItem::findOrFail($cartItemId);
        $cartItem->delete();

        return back()->with('success', 'Item removed from cart!');
    }

    // Get current cart
    private function getCart()
    {
        if (Auth::check()) {
            return Cart::where('user_id', Auth::id())->first();
        } else {
            $sessionId = session()->getId();
            return Cart::where('session_id', $sessionId)->first();
        }
    }

    // Get or create cart
    private function getOrCreateCart()
    {
        $cart = $this->getCart();

        if (!$cart) {
            $cart = Cart::create([
                'user_id' => Auth::check() ? Auth::id() : null,
                'session_id' => !Auth::check() ? session()->getId() : null,
            ]);
        }

        return $cart;
    }
}
```

### 3. Example Checkout Controller

Create `app/Http/Controllers/CheckoutController.php`:

```php
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
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $cartItems = $cart->cartItems()->with('product')->get();
        $total = $cart->getTotal();

        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            'shipping_address' => 'required|string',
            'billing_address' => 'required|string',
            'payment_method' => 'required|string',
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        DB::beginTransaction();
        try {
            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'total_amount' => $cart->getTotal(),
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'shipping_address' => $validated['shipping_address'],
                'billing_address' => $validated['billing_address'],
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
            ]);

            // Create order items
            foreach ($cart->cartItems as $cartItem) {
                $product = $cartItem->product;
                
                // Check stock
                if (!$product->hasStock($cartItem->quantity)) {
                    throw new \Exception("Not enough stock for {$product->nameProduct}");
                }

                OrderItem::create([
                    'order_id' => $order->idOrder,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $product->priceProduct,
                    'subtotal' => $cartItem->quantity * $product->priceProduct,
                ]);

                // Reduce stock
                $product->quantityProduct -= $cartItem->quantity;
                $product->save();
            }

            // Clear cart
            $cart->cartItems()->delete();

            DB::commit();

            return redirect()->route('order.success', $order->idOrder)
                           ->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
```

### 4. Create Routes

Add to `routes/web.php`:

```php
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Cart routes (guest & auth)
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{cartItem}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');

// Authenticated routes
Route::middleware('auth')->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    
    // Reviews
    Route::post('/products/{product}/review', [ReviewController::class, 'store'])->name('reviews.store');
});

// Admin routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('products', Admin\ProductController::class);
    Route::get('orders', [Admin\OrderController::class, 'index'])->name('admin.orders.index');
    Route::put('orders/{id}/status', [Admin\OrderController::class, 'updateStatus'])->name('admin.orders.updateStatus');
});
```

---

## 🔧 Additional Features to Add:

### 1. **Wishlist**
```bash
php artisan make:model Wishlist -m
```

Migration:
```php
Schema::create('wishlists', function (Blueprint $table) {
    $table->id('idWishlist');
    $table->unsignedBigInteger('user_id');
    $table->integer('product_id');
    $table->timestamps();
    
    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
    $table->foreign('product_id')->references('idProduct')->on('products')->onDelete('cascade');
});
```

### 2. **Coupons**
```bash
php artisan make:model Coupon -m
```

### 3. **Product Images** (Multiple images per product)
```bash
php artisan make:model ProductImage -m
```

### 4. **Order Status History**
```bash
php artisan make:model OrderStatusHistory -m
```

---

## 📝 Important Notes:

1. **Primary Keys**: Your database uses custom primary keys (idCategory, idProduct, etc.)
   - Models are configured with `protected $primaryKey` to handle this
   - Foreign keys are explicitly defined in relationships

2. **Column Names**: Your database uses camelCase (nameProduct, priceProduct, etc.)
   - Models' `$fillable` arrays match your exact column names

3. **Stock Management**: 
   - Product model includes `isInStock()` and `hasStock()` methods
   - Checkout automatically reduces stock quantity

4. **Guest Cart**: 
   - Carts support both authenticated users and guest sessions
   - Use `session_id` for guest users

5. **Order Numbers**: 
   - Automatically generated with format: ORD-YYYYMMDD-XXXXXX

---

## 🎯 Testing Your Setup:

After running migrations, test in Tinker:

```bash
php artisan tinker
```

```php
// Test relationships
$category = App\Models\Category::first();
$category->products;

$product = App\Models\Product::first();
$product->category;

// Create test cart
$cart = App\Models\Cart::create(['session_id' => 'test123']);
$cart->cartItems()->create(['product_id' => 1, 'quantity' => 2]);
$cart->getTotal();
```

---

## 📚 Resources:

- Laravel Documentation: https://laravel.com/docs
- E-commerce best practices
- Payment gateway integration (Stripe, PayPal)
- Email notifications for orders
- Admin dashboard with charts

Good luck with your e-commerce project! 🚀🛒

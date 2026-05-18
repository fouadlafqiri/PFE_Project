@extends('layouts.masterr')

@section('content1')

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Votre sélection</p>
                    <h1>Panier</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- cart section -->
<div class="cart-section mt-150 mb-150">
    <div class="container">

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Error Message --}}
        @if(session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif

        @if(isset($cartItems) && count($cartItems) > 0)

        <div class="row">

            <!-- Cart Table -->
            <div class="col-lg-8 col-md-12">

                <div class="cart-table-wrap">

                    <table class="cart-table">

                        <thead class="cart-table-head">
                            <tr class="table-head-row">
                                <th class="product-remove"></th>
                                <th class="product-image">Image</th>
                                <th class="product-name">Produit</th>
                                <th class="product-price">Prix</th>
                                <th class="product-quantity">Quantité</th>
                                <th class="product-total">Total</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($cartItems as $item)

                            <tr class="table-body-row">

                                <!-- Remove -->
                                <td class="product-remove">

                                    <form action="{{ route('cart.remove', $item->idCartItem) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                style="background:none;border:none;cursor:pointer;">

                                            <i class="far fa-window-close"></i>

                                        </button>

                                    </form>

                                </td>

                                <!-- Product Image -->
                                <td class="product-image">

                                    <img src="{{ asset('images/products/' . $item->product->imageProduct) }}"
                                         alt="{{ $item->product->nameProduct }}"
                                         width="80">

                                </td>

                                <!-- Product Name -->
                                <td class="product-name">

                                    <a href="{{ route('products.show', $item->product->idProduct) }}">

                                        {{ $item->product->nameProduct }}

                                    </a>

                                </td>

                                <!-- Product Price -->
                                <td class="product-price">

                                    DH {{ number_format($item->product->priceProduct, 2) }}

                                </td>

                                <!-- Quantity -->
                                <td class="product-quantity">

                                    <form action="{{ route('cart.update', $item->idCartItem) }}"
                                          method="POST"
                                          class="d-flex align-items-center">

                                        @csrf
                                        @method('PUT')

                                        <input type="number"
                                               name="quantity"
                                               value="{{ $item->quantity }}"
                                               min="1"
                                               class="form-control w-75">

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-secondary ms-1">

                                            <i class="fas fa-sync-alt"></i>

                                        </button>

                                    </form>

                                </td>

                                <!-- Line Total -->
                                <td class="product-total">

                                    DH {{ number_format($item->product->priceProduct * $item->quantity, 2) }}

                                </td>

                            </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                <!-- Clear Cart -->
                <form action="{{ route('cart.clear') }}"
                      method="POST"
                      class="mt-4">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="boxed-btn"
                            onclick="return confirm('Vider le panier ?')">

                        Vider le panier

                    </button>

                </form>

            </div>

            <!-- Summary -->
            <div class="col-lg-4">

                <div class="total-section">

                    <table class="total-table">

                        <thead class="total-table-head">
                            <tr class="table-total-row">
                                <th>Détail</th>
                                <th>Prix</th>
                            </tr>
                        </thead>

                        <tbody>

                            <!-- Subtotal -->
                            <tr class="total-data">

                                <td>
                                    <strong>Sous-total :</strong>
                                </td>

                                <td>
                                    DH {{ number_format($subtotal ?? 0, 2) }}
                                </td>

                            </tr>

                            <!-- Coupon -->
                            @if(session('coupon'))

                            <tr class="total-data">

                                <td>
                                    <strong>
                                        Coupon ({{ session('coupon.code') }})
                                    </strong>
                                </td>

                                <td class="text-success">
                                    -{{ session('coupon.discount_percent') }}%
                                </td>

                            </tr>

                            <tr class="total-data">

                                <td>
                                    <strong>Réduction :</strong>
                                </td>

                                <td class="text-success">

                                    - DH {{ number_format(session('coupon.discount_amount'), 2) }}

                                </td>

                            </tr>

                            @endif

                            <!-- Shipping -->
                            <tr class="total-data">

                                <td>
                                    <strong>Livraison :</strong>
                                </td>

                                <td>

                                    @if(($subtotal ?? 0) >= 75)

                                        <span class="text-success">
                                            Gratuite
                                        </span>

                                    @else

                                        DH {{ number_format($shipping ?? 0, 2) }}

                                    @endif

                                </td>

                            </tr>

                            <!-- Total -->
                            <tr class="total-data">

                                <td>
                                    <strong>Total :</strong>
                                </td>

                                <td>

                                    <strong>

                                        @if(session('coupon'))

                                            DH {{ number_format(session('coupon.new_total'), 2) }}

                                        @else

                                            DH {{ number_format($total ?? 0, 2) }}

                                        @endif

                                    </strong>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                    <!-- Buttons -->
                    <div class="cart-buttons">

                        <a href="{{ route('products.index') }}"
                           class="boxed-btn">

                            Continuer les achats

                        </a>

                        @auth

                            <a href="{{ route('checkout.index') }}"
                               class="boxed-btn black">

                                Commander

                            </a>

                        @else

                            <a href="{{ route('login') }}"
                               class="boxed-btn black">

                                Connectez-vous pour commander

                            </a>

                        @endauth

                    </div>

                </div>

                <!-- Coupon Section -->
                <div class="coupon-section mt-5">

                    <h3 class="mb-3">Code Promo</h3>

                    <div class="coupon-form-wrap">

                        <form action="{{ route('cart.coupon') }}"
                              method="POST"
                              style="display:flex; gap:10px; align-items:center;">

                            @csrf

                            <input type="text"
                                   name="coupon_code"
                                   placeholder="Entrer le code promo"
                                   style="
                                        flex:1;
                                        height:50px;
                                        padding:0 15px;
                                        border:1px solid #ddd;
                                        border-radius:5px;
                                   ">

                            <button type="submit"
                                    class="boxed-btn"
                                    style="
                                        border:none;
                                        height:50px;
                                        padding:0 25px;
                                    ">

                                Apply

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

        @else

        <!-- Empty Cart -->
        <div class="row">

            <div class="col-12 text-center">

                <h3>Votre panier est vide</h3>

                <p>
                    Vous n'avez encore ajouté aucun produit.
                </p>

                <a href="{{ route('products.index') }}"
                   class="boxed-btn mt-3">

                    Voir nos produits

                </a>

            </div>

        </div>

        @endif

    </div>
</div>

@endsection

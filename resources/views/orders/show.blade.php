@extends('layouts.masterr')

@section('content1')

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Détails de la commande</p>
                    <h1>Commande #{{ $order->idOrder }}</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- order details -->
<div class="cart-section mt-150 mb-150">
    <div class="container">

        <div class="row">

            <!-- LEFT -->
            <div class="col-lg-8">

                <div class="cart-table-wrap">

                    <table class="cart-table">

                        <thead class="cart-table-head">
                            <tr class="table-head-row">

                                <th>Produit</th>
                                <th>Catégorie</th>
                                <th>Prix</th>
                                <th>Quantité</th>
                                <th>Sous-total</th>

                            </tr>
                        </thead>

                        <tbody>

                        @foreach($order->orderItems as $item)

                            <tr class="table-body-row">

                                <!-- Product -->
                                <td>

                                    <div class="d-flex align-items-center">

                                        @if($item->product->imageProduct)

                                            <img src="{{ asset('storage/' . $item->product->imageProduct) }}"
                                                 width="80"
                                                 class="me-3"
                                                 alt="">

                                        @endif

                                        <div>
                                            <strong>
                                                {{ $item->product->nameProduct }}
                                            </strong>
                                        </div>

                                    </div>

                                </td>

                                <!-- Category -->
                                <td>
                                    {{ $item->product->category->nameCategory ?? 'N/A' }}
                                </td>

                                <!-- Price -->
                                <td>
                                    DH {{ number_format($item->price, 2) }}
                                </td>

                                <!-- Quantity -->
                                <td>
                                    {{ $item->quantity }}
                                </td>

                                <!-- Subtotal -->
                                <td>
                                    DH {{ number_format($item->price * $item->quantity, 2) }}
                                </td>

                            </tr>

                        @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-4">

                <div class="total-section">

                    <table class="total-table">

                        <thead class="total-table-head">
                            <tr class="table-total-row">
                                <th>Détails</th>
                                <th>Valeur</th>
                            </tr>
                        </thead>

                        <tbody>



                            <tr class="total-data">
                                <td><strong>Date:</strong></td>
                                <td>
                                    {{ $order->created_at->format('d/m/Y H:i') }}
                                </td>
                            </tr>

                            <tr class="total-data">
                                <td><strong>Client:</strong></td>
                                <td>
                                    {{ $order->user->name }}
                                </td>
                            </tr>

                            <tr class="total-data">

                                <td><strong>Status:</strong></td>

                                <td>

                                    @if($order->status == 'pending')

                                        <span class="badge bg-warning text-dark">
                                            En attente
                                        </span>

                                    @elseif($order->status == 'processing')

                                        <span class="badge bg-info text-dark">
                                            En préparation
                                        </span>

                                    @elseif($order->status == 'shipped')

                                        <span class="badge bg-primary">
                                            Expédiée
                                        </span>

                                    @elseif($order->status == 'delivered')

                                        <span class="badge bg-success">
                                            Livrée
                                        </span>

                                    @elseif($order->status == 'cancelled')

                                        <span class="badge bg-danger">
                                            Annulée
                                        </span>

                                    @endif

                                </td>

                            </tr>

                            <tr class="total-data">
                                <td><strong>Total:</strong></td>
                                <td>
                                    <strong class="text-success">
                                        DH {{ number_format($order->total_amount, 2) }}
                                    </strong>
                                </td>
                            </tr>

                        </tbody>

                    </table>

                    <!-- Buttons -->
                    <div class="mt-4">

                        <a href="{{ route('orders.index') }}"
                           class="boxed-btn">

                            Retour

                        </a>

                        @if($order->status == 'pending')

                            <form action="{{ route('orders.cancel', $order->idOrder) }}"
                                  method="POST"
                                  class="mt-3">

                                @csrf

                                <button type="submit"
                                        class="boxed-btn black"
                                        onclick="return confirm('Voulez-vous annuler cette commande ?')">

                                    Annuler la commande

                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

@endsection

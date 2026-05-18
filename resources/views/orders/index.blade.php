@extends('layouts.masterr')

@section('content1')

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Fresh and Organic</p>
                    <h1>Mes Commandes</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- orders section -->
<div class="cart-section mt-150 mb-150">
    <div class="container">

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Error Message -->
        @if(session('error'))
            <div class="alert alert-danger mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="cart-table-wrap">

            <table class="cart-table">

                <thead class="cart-table-head">
                    <tr class="table-head-row">
                        <th>Commande</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($orders as $order)

                    <tr class="table-body-row">

                        <!-- Order ID -->
                        <td>

                            @foreach($order->orderItems as $item)

                                {{ $item->product->nameProduct }}

                                @if(!$loop->last)
                                    ,
                                @endif

                            @endforeach

                        </td>

                        <!-- Date -->
                        <td>
                            {{ $order->created_at->format('d/m/Y') }}
                        </td>

                        <!-- Status -->
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

                            @else

                                <span class="badge bg-secondary">
                                    {{ ucfirst($order->status) }}
                                </span>

                            @endif

                        </td>

                        <!-- Total -->
                        <td>
                            DH {{ number_format($order->total_amount, 2) }}
                        </td>

                        <!-- Actions -->
                        <td>

                            <!-- Show Order -->
                            <a href="{{ route('orders.show', $order->idOrder) }}"
                               class="boxed-btn">

                                Voir

                            </a>

                            <!-- Cancel Order -->
                            @if($order->status == 'pending')

                                <form action="{{ route('orders.cancel', $order->idOrder) }}"
                                      method="POST"
                                      style="display:inline-block;">

                                    @csrf

                                    <button type="submit"
                                            class="boxed-btn black"
                                            onclick="return confirm('Voulez-vous annuler cette commande ?')">

                                        Annuler

                                    </button>

                                </form>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center p-4">

                            <h5>Aucune commande trouvée.</h5>

                            <a href="{{ route('products.index') }}"
                               class="boxed-btn mt-3">

                                Voir les produits

                            </a>

                        </td>
                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center">
            {{ $orders->links() }}
        </div>

    </div>
</div>

@endsection

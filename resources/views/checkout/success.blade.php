@extends('layouts.masterr')
@section('title', 'Artisana - Commande confirmée')
@section('content1')

<div class="checkout-section mt-150 mb-150">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="alert alert-success text-center">
                    <h2>Commande confirmée !</h2>
                    <p>Votre commande <strong>#{{ $order->order_number }}</strong> a bien été enregistrée.</p>
                </div>

                <div class="order-summary mb-4 p-4" style="background:#fff; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,.05);">
                    <h4>Détails de la commande</h4>
                    <p><strong>Montant total :</strong> {{ number_format($order->total_amount + 50, 2) }} DH</p>
                    <p><strong>Méthode de paiement :</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                    <p><strong>Adresse de livraison :</strong> {{ $order->shipping_address }}</p>
                    <p><strong>Adresse de facturation :</strong> {{ $order->billing_address }}</p>
                </div>

                <div class="order-items p-4" style="background:#fff; border-radius:8px; box-shadow:0 2px 10px rgba(0,0,0,.05);">
                    <h4>Produits commandés</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Prix</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->product->nameProduct }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->subtotal, 2) }} DH</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <a href="{{ url('/') }}" class="boxed-btn">Retour à l'accueil</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

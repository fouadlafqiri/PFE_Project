@extends('admin.master')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Facture</h1>
            <p class="text-muted">Commande #{{ $order->order_number }}</p>
        </div>
        <div>
            <a href="{{ route('admin.orders.show', $order->idOrder) }}" class="btn btn-secondary">
                <i data-feather="arrow-left"></i> Retour
            </a>
            <button onclick="window.print();" class="btn btn-primary ms-2">
                <i data-feather="printer"></i> Imprimer
            </button>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="card-title">Client</h5>
                    <p class="mb-1"><strong>Nom :</strong> {{ $order->customer_name }}</p>
                    <p class="mb-1"><strong>Email :</strong> {{ $order->customer_email }}</p>
                    <p class="mb-1"><strong>Téléphone :</strong> {{ $order->customer_phone }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <h5 class="card-title">Détails de la commande</h5>
                    <p class="mb-1"><strong>Numéro :</strong> {{ $order->order_number }}</p>
                    <p class="mb-1"><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                    <p class="mb-1"><strong>Statut :</strong> {{ ucfirst($order->status) }}</p>
                    <p class="mb-1"><strong>Paiement :</strong> {{ ucfirst($order->payment_status) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">Articles</h5>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Prix</th>
                            <th>Quantité</th>
                            <th>Sous-total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->product->nameProduct ?? 'Produit supprimé' }}</td>
                                <td>{{ number_format($item->price, 2) }} DH</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price * $item->quantity, 2) }} DH</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                            <td><strong>{{ number_format($order->total_amount, 2) }} DH</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection

@extends('admin.master')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Détails de la commande</h1>
            <p class="text-muted">Commande #{{ $order->order_number }}</p>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i data-feather="arrow-left"></i> Retour
            </a>
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.orders.invoice', $order->idOrder) }}" class="btn btn-primary ms-2">
                    <i data-feather="file-text"></i> Facture
                </a>
            @endif
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informations client</h5>
                    <p class="mb-1"><strong>Nom :</strong> {{ $order->customer_name }}</p>
                    <p class="mb-1"><strong>Email :</strong> {{ $order->customer_email }}</p>
                    <p class="mb-1"><strong>Téléphone :</strong> {{ $order->customer_phone }}</p>
                    <p class="mb-1"><strong>Adresse de livraison :</strong><br>{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Statut de la commande</h5>
                    <p class="mb-1"><strong>Commande :</strong> {{ ucfirst($order->status) }}</p>
                    <p class="mb-1"><strong>Paiement :</strong> {{ ucfirst($order->payment_status) }}</p>
                    <p class="mb-1"><strong>Montant :</strong> {{ number_format($order->total_amount, 2) }} DH</p>
                    <p class="mb-1"><strong>Date :</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">Articles commandés</h5>
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
                </table>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Notes</h5>
            <p>{{ $order->notes ?? 'Aucune note' }}</p>
        </div>
    </div>

    <div class="row g-3 mt-3">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">Mettre à jour le statut de la commande</h5>
                    @if(in_array(auth()->user()->role, ['admin', 'livreur']))
                        <form action="{{ route('admin.orders.updateStatus', $order->idOrder) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Statut</label>
                                <select name="status" class="form-select" required>
                                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>En cours</option>
                                    <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Expédiée</option>
                                    <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Livrée</option>
                                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Mettre à jour le statut</button>
                        </form>
                    @else
                        <p>Vous n'avez pas la permission de modifier le statut.</p>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mettre à jour le statut de paiement</h5>
                    @if(in_array(auth()->user()->role, ['admin', 'livreur']))
                        <form action="{{ route('admin.orders.updatePaymentStatus', $order->idOrder) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label class="form-label">Statut de paiement</label>
                                <select name="payment_status" class="form-select" required>
                                    <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>En attente</option>
                                    <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Payé</option>
                                    <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Échoué</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Mettre à jour le paiement</button>
                        </form>
                    @else
                        <p>Vous n'avez pas la permission de modifier le statut de paiement.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-6">
            @if(auth()->user()->role === 'admin')
                @include('admin.orders.delivery-form')
            @endif
        </div>
    </div>
@endsection

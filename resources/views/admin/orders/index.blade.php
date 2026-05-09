@extends('admin.master')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Commandes</h1>
            <p class="text-muted">Voir et gérer les commandes client.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
            <i data-feather="arrow-left"></i> Retour au dashboard
        </a>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-sm-6 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Total</h5>
                    <h3 class="mb-0">{{ $stats['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">En attente</h5>
                    <h3 class="mb-0">{{ $stats['pending'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">En cours</h5>
                    <h3 class="mb-0">{{ $stats['processing'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Expédiées</h5>
                    <h3 class="mb-0">{{ $stats['shipped'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Livrées</h5>
                    <h3 class="mb-0">{{ $stats['delivered'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-3">Annulées</h5>
                    <h3 class="mb-0">{{ $stats['cancelled'] }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Recherche</label>
                    <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Numéro, nom ou e-mail">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Statut</label>
                    <select name="status" class="form-select">
                        <option value="">Tous</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>En cours</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Expédié</option>
                        <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Livré</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Annulé</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Paiement</label>
                    <select name="payment_status" class="form-select">
                        <option value="">Tous</option>
                        <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>En attente</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Payé</option>
                        <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Échoué</option>
                    </select>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="submit" class="btn btn-primary">Filtrer</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Commande</th>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Paiement</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->idOrder }}</td>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->customer_name }}<br><small>{{ $order->customer_email }}</small></td>
                            <td>{{ number_format($order->total_amount, 2) }} DH</td>
                            <td>
                                <span class="badge bg-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : ($order->status == 'shipped' ? 'primary' : ($order->status == 'delivered' ? 'success' : 'danger'))) }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'failed' ? 'danger' : 'secondary') }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->idOrder) }}" class="btn btn-sm btn-primary me-1">
                                    <i data-feather="eye"></i>
                                </a>
                                <a href="{{ route('admin.orders.invoice', $order->idOrder) }}" class="btn btn-sm btn-secondary me-1">
                                    <i data-feather="file-text"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order->idOrder) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Supprimer cette commande ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i data-feather="trash-2"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">Aucune commande trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $orders->withQueryString()->links() }}
    </div>
@endsection

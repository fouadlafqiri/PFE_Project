@extends('admin.master')

@section('admin-content')

<h1 class="h3 mb-3"><strong>Tableau de Bord</strong></h1>

{{-- Stats Cards --}}
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Utilisateurs</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="users"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $stats['total_users'] }}</h1>
                <div class="mb-0">
                    <span class="text-muted">Total inscrits</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Produits</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="package"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $stats['total_products'] }}</h1>
                <div class="mb-0">
                    <span class="text-muted">Total produits</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Commandes</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="shopping-cart"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ $stats['total_orders'] }}</h1>
                <div class="mb-0">
                    <span class="text-warning">
                        {{ $stats['pending_orders'] }} en attente
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col mt-0">
                        <h5 class="card-title">Revenus</h5>
                    </div>
                    <div class="col-auto">
                        <div class="stat text-primary">
                            <i class="align-middle" data-feather="dollar-sign"></i>
                        </div>
                    </div>
                </div>
                <h1 class="mt-1 mb-3">{{ number_format($stats['total_revenue'], 2) }} DH</h1>
                <div class="mb-0">
                    <span class="text-muted">Commandes payées</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Order Status Cards --}}
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body text-center py-3">
                <h5 class="card-title">En attente</h5>
                <h2 class="text-warning">{{ $stats['pending_orders'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body text-center py-3">
                <h5 class="card-title">En traitement</h5>
                <h2 class="text-primary">{{ $stats['processing_orders'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body text-center py-3">
                <h5 class="card-title">Expédiées</h5>
                <h2 class="text-info">{{ $stats['shipped_orders'] }}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card">
            <div class="card-body text-center py-3">
                <h5 class="card-title">Livrées</h5>
                <h2 class="text-success">{{ $stats['delivered_orders'] }}</h2>
            </div>
        </div>
    </div>
</div>

<div class="row">
    {{-- Recent Orders --}}
    <div class="col-12 col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Commandes Récentes</h5>
            </div>
            <table class="table table-hover my-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Montant</th>
                        <th>Statut</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'N/A' }}</td>
                        <td>{{ number_format($order->total_amount, 2) }} DH</td>
                        <td>
                            @switch($order->status)
                                @case('pending')
                                    <span class="badge bg-warning">En attente</span>
                                    @break
                                @case('processing')
                                    <span class="badge bg-primary">En traitement</span>
                                    @break
                                @case('shipped')
                                    <span class="badge bg-info">Expédiée</span>
                                    @break
                                @case('delivered')
                                    <span class="badge bg-success">Livrée</span>
                                    @break
                                @case('cancelled')
                                    <span class="badge bg-danger">Annulée</span>
                                    @break
                                @default
                                    <span class="badge bg-secondary">{{ $order->status }}</span>
                            @endswitch
                        </td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order->idOrder) }}"
                               class="btn btn-sm btn-primary">
                                <i data-feather="eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Aucune commande</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Latest Products --}}
    <div class="col-12 col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Derniers Produits</h5>
            </div>
            <div class="card-body">
                @forelse($latestProducts as $product)
                <div class="d-flex align-items-center mb-3">
                    <img src="{{ asset('images/products/' . $product->imageProduct) }}"
                         alt="{{ $product->nameProduct }}"
                         class="rounded me-3"
                         style="width:45px; height:45px; object-fit:cover;">
                    <div class="flex-grow-1">
                        <strong>{{ $product->nameProduct }}</strong><br>
                        <small class="text-muted">{{ $product->category->nameCategory ?? 'N/A' }}</small>
                    </div>
                    <div class="text-end">
                        <strong>{{ number_format($product->priceProduct, 2) }} DH</strong>
                    </div>
                </div>
                @empty
                    <p class="text-muted text-center">Aucun produit</p>
                @endforelse

                <div class="text-center mt-3">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm">
                        Voir tous les produits
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

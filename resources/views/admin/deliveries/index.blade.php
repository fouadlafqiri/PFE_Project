@extends('admin.master')

@section('admin-content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0"><strong>Gestion des Livreurs</strong></h1>
    <a href="{{ route('admin.deliveries.create') }}" class="btn btn-primary">
        <i class="align-middle me-1" data-feather="plus"></i> Ajouter un Livreur
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover my-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Type Véhicule</th>
                    <th>Statut</th>
                    <th>Commandes</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($deliveries as $delivery)
                    <tr>
                        <td>{{ $delivery->idDelivery }}</td>
                        <td>{{ $delivery->name }}</td>
                        <td>{{ $delivery->email }}</td>
                        <td>{{ $delivery->phone }}</td>
                        <td>
                            @if($delivery->vehicle_type)
                                <span class="badge bg-info">{{ ucfirst($delivery->vehicle_type) }}</span>
                            @else
                                <span class="badge bg-secondary">Non spécifié</span>
                            @endif
                        </td>
                        <td>
                            @switch($delivery->status)
                                @case('active')
                                    <span class="badge bg-success">Actif</span>
                                    @break
                                @case('inactive')
                                    <span class="badge bg-danger">Inactif</span>
                                    @break
                                @case('on_delivery')
                                    <span class="badge bg-warning">En cours de livraison</span>
                                    @break
                            @endswitch
                        </td>
                        <td>{{ $delivery->orders_completed }}</td>
                        <td>
                            <a href="{{ route('admin.deliveries.edit', $delivery->idDelivery) }}" class="btn btn-sm btn-warning">
                                <i data-feather="edit"></i>
                            </a>
                            <form action="{{ route('admin.deliveries.destroy', $delivery->idDelivery) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr?')">
                                    <i data-feather="trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center">Aucun livreur trouvé</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

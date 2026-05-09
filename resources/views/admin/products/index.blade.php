@extends('admin.master')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Produits</h1>
            <p class="text-muted">Gérez les produits de la boutique artisanale.</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i data-feather="plus"></i> Nouveau produit
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Catégorie</th>
                        <th>Nom</th>
                        <th>Prix</th>
                        <th>Quantité</th>
                        <th>Actif</th>
                        <th>Mis en vedette</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>{{ $product->idProduct }}</td>
                            <td>{{ $product->category->nameCategory ?? 'N/A' }}</td>
                            <td>{{ $product->nameProduct }}</td>
                            <td>{{ number_format($product->priceProduct, 2) }} DH</td>
                            <td>{{ $product->quantityProduct }}</td>
                            <td>
                                <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $product->is_active ? 'Oui' : 'Non' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge {{ $product->is_featured ? 'bg-warning' : 'bg-secondary' }}">
                                    {{ $product->is_featured ? 'Oui' : 'Non' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->idProduct) }}" class="btn btn-sm btn-primary me-1">
                                    <i data-feather="edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->idProduct) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Supprimer ce produit ?');">
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
                            <td colspan="8" class="text-center">Aucun produit trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $products->links() }}
    </div>
@endsection

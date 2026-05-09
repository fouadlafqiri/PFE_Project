@extends('admin.master')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Catégories</h1>
            <p class="text-muted">Gérez les catégories de votre catalogue.</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i data-feather="plus"></i> Nouvelle catégorie
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Description</th>
                        <th>Image</th>
                        <th>Produits</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->idCategory }}</td>
                            <td>{{ $category->nameCategory }}</td>
                            <td>{{ strlen($category->descriptionCategory) > 80 ? substr($category->descriptionCategory, 0, 80) . '...' : $category->descriptionCategory }}</td>
                            <td>
                                @if($category->imageCategory)
                                    <img src="{{ asset('assets/img/categories/' . $category->imageCategory) }}" alt="{{ $category->nameCategory }}" class="rounded" style="width: 80px; height: 80px; object-fit: cover; display: block; margin: 0 auto;">
                                @else
                                    <span class="text-muted">Aucune</span>
                                @endif
                            </td>
                            <td>{{ $category->products()->count() }}</td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category->idCategory) }}" class="btn btn-sm btn-primary me-1">
                                    <i data-feather="edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->idCategory) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Supprimer cette catégorie ?');">
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
                            <td colspan="6" class="text-center">Aucune catégorie trouvée.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $categories->links() }}
    </div>
@endsection

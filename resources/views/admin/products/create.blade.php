@extends('admin.master')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ajouter un produit</h1>
            <p class="text-muted">Ajoutez un nouveau produit au catalogue.</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            <i data-feather="arrow-left"></i> Retour
        </a>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Catégorie</label>
                    <select name="idCategory" class="form-select" required>
                        <option value="">Sélectionnez une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->idCategory }}" {{ old('idCategory') == $category->idCategory ? 'selected' : '' }}>
                                {{ $category->nameCategory }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nom du produit</label>
                    <input type="text" name="nameProduct" class="form-control" value="{{ old('nameProduct') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="descriptionProduct" class="form-control" rows="4">{{ old('descriptionProduct') }}</textarea>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Prix</label>
                        <input type="number" step="0.01" name="priceProduct" class="form-control" value="{{ old('priceProduct') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Quantité</label>
                        <input type="number" name="quantityProduct" class="form-control" value="{{ old('quantityProduct') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Image</label>
                        <input type="file" name="imageProduct" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="form-check form-switch mt-3">
                    <input class="form-check-input" type="checkbox" id="isActive" name="is_active" {{ old('is_active') ? 'checked' : '' }}>
                    <label class="form-check-label" for="isActive">Activer</label>
                </div>

                <div class="form-check form-switch mt-2">
                    <input class="form-check-input" type="checkbox" id="isFeatured" name="is_featured" {{ old('is_featured') ? 'checked' : '' }}>
                    <label class="form-check-label" for="isFeatured">Mis en vedette</label>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Créer le produit</button>
            </form>
        </div>
    </div>
@endsection

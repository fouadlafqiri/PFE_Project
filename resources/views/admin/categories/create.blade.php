@extends('admin.master')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Ajouter une catégorie</h1>
            <p class="text-muted">Créez une nouvelle catégorie pour vos produits.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
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
            <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nom de la catégorie</label>
                    <input type="text" name="nameCategory" class="form-control" value="{{ old('nameCategory') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="descriptionCategory" class="form-control" rows="4">{{ old('descriptionCategory') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image de catégorie</label>
                    <input type="file" name="imageCategory" class="form-control" accept="image/*">
                </div>

                <button type="submit" class="btn btn-primary mt-3">Créer la catégorie</button>
            </form>
        </div>
    </div>
@endsection

@extends('admin.master')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Modifier la catégorie</h1>
            <p class="text-muted">Mettez à jour les informations de la catégorie.</p>
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
            <form action="{{ route('admin.categories.update', $category->idCategory) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nom de la catégorie</label>
                    <input type="text" name="nameCategory" class="form-control" value="{{ old('nameCategory', $category->nameCategory) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="descriptionCategory" class="form-control" rows="4">{{ old('descriptionCategory', $category->descriptionCategory) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Image de catégorie</label>
                    <input type="file" name="imageCategory" class="form-control" accept="image/*">
                </div>

                @if($category->imageCategory)
                    <div class="mb-3">
                        <label class="form-label">Image actuelle</label>
                        <div>
                            <img src="{{ asset('assets/img/categories/' . $category->imageCategory) }}" alt="{{ $category->nameCategory }}" class="img-fluid rounded" style="max-width: 160px;">
                        </div>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary mt-3">Mettre à jour</button>
            </form>
        </div>
    </div>
@endsection

@extends('admin.master')

@section('admin-content')
    <div class="mb-4">
        <h1 class="h3 mb-0">Nouvel article</h1>
        <p class="text-muted">Ajoutez une nouvelle actualité à votre site.</p>
    </div>

    <div class="card">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Extrait</label>
                    <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contenu</label>
                    <textarea name="content" class="form-control" rows="6" required>{{ old('content') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Auteur</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" {{ old('is_published') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">Publier immédiatement</label>
                </div>

                <button type="submit" class="btn btn-primary">Enregistrer</button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary ms-2">Annuler</a>
            </form>
        </div>
    </div>
@endsection

@extends('admin.master')

@section('admin-content')
    <div class="mb-4">
        <h1 class="h3 mb-0">Modifier l'article</h1>
        <p class="text-muted">Mettez à jour le contenu de l'article.</p>
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

            <form action="{{ route('admin.news.update', $news->idNews) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $news->title) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Extrait</label>
                    <textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $news->excerpt) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contenu</label>
                    <textarea name="content" class="form-control" rows="6" required>{{ old('content', $news->content) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Auteur</label>
                    <input type="text" name="author" class="form-control" value="{{ old('author', $news->author) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Image</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                    @if($news->image)
                        <div class="mt-2">
                            <img src="{{ asset('assets/img/news/' . $news->image) }}" alt="Image actuelle" style="max-width: 180px; max-height: 120px; object-fit: cover;" class="rounded">
                        </div>
                    @endif
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" id="is_published" {{ old('is_published', $news->is_published) ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_published">Publier</label>
                </div>

                <button type="submit" class="btn btn-primary">Mettre à jour</button>
                <a href="{{ route('admin.news.index') }}" class="btn btn-secondary ms-2">Annuler</a>
            </form>
        </div>
    </div>
@endsection

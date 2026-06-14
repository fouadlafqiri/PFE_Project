@extends('admin.master')

@section('admin-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0">Actualités</h1>
            <p class="text-muted">Gérez vos articles de blog et actualités.</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i data-feather="plus"></i> Nouvel article
        </a>
    </div>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Publié</th>
                        <th>Créé le</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $article)
                        <tr>
                            <td>{{ $article->idNews }}</td>
                            <td>{{ $article->title }}</td>
                            <td>{{ $article->author ?: 'N/A' }}</td>
                            <td>
                                @if($article->is_published)
                                    <span class="badge bg-success">Oui</span>
                                @else
                                    <span class="badge bg-secondary">Non</span>
                                @endif
                            </td>
                            <td>{{ $article->created_at->format('d/m/Y') }}</td>
                            <td>
                                <a href="{{ route('admin.news.edit', $article->idNews) }}" class="btn btn-sm btn-primary me-1">
                                    <i data-feather="edit"></i>
                                </a>
                                <form action="{{ route('admin.news.destroy', $article->idNews) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Supprimer cet article ?');">
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
                            <td colspan="6" class="text-center">Aucun article trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $news->links() }}
    </div>
@endsection

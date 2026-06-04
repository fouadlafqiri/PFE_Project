@extends('admin.master')

@section('admin-content')

<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Admin Panel</p>
                    <h1>Gestion des Avis</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="product-section mt-150 mb-150">
    <div class="container">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Avis en attente -->
        <div class="row mb-80">
            <div class="col-lg-12">
                <h3 class="mb-4">
                    <i class="fas fa-clock"></i> Avis en Attente d'Approbation
                    <span class="badge bg-warning">{{ $pendingReviews->total() }}</span>
                </h3>

                @forelse ($pendingReviews as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <strong>{{ $review->user->name ?? 'Anonyme' }}</strong>
                                    <br>
                                    <small class="text-muted">Produit: {{ $review->product->nameProduct }}</small>
                                    <br>
                                    <div class="mt-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                        <small>({{ $review->rating }}/5)</small>
                                    </div>
                                    <p class="mt-2 mb-0">{{ $review->comment }}</p>
                                    <small class="text-muted">{{ $review->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <form action="{{ route('admin.reviews.approve', $review->idReview) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Approuver
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.reviews.reject', $review->idReview) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr?')">
                                            <i class="fas fa-trash"></i> Rejeter
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Aucun avis en attente d'approbation.</p>
                @endforelse

                {{ $pendingReviews->links() }}
            </div>
        </div>

        <!-- Avis approuvés -->
        <div class="row">
            <div class="col-lg-12">
                <h3 class="mb-4">
                    <i class="fas fa-check-circle"></i> Avis Approuvés
                    <span class="badge bg-success">{{ $approvedReviews->total() }}</span>
                </h3>

                @forelse ($approvedReviews as $review)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <strong>{{ $review->user->name ?? 'Anonyme' }}</strong>
                                    <br>
                                    <small class="text-muted">Produit: {{ $review->product->nameProduct }}</small>
                                    <br>
                                    <div class="mt-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                        <small>({{ $review->rating }}/5)</small>
                                    </div>
                                    <p class="mt-2 mb-0">{{ $review->comment }}</p>
                                    <small class="text-muted">{{ $review->created_at->format('d/m/Y H:i') }}</small>
                                </div>
                                <div class="col-md-4 text-end">
                                    <form action="{{ route('admin.reviews.reject', $review->idReview) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr?')">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">Aucun avis approuvé.</p>
                @endforelse

                {{ $approvedReviews->links() }}
            </div>
        </div>

    </div>
</div>

@endsection

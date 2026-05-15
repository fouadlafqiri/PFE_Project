@extends('layouts.masterr')

@section('content1')

<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Fresh and Organic</p>
						<h1>Produits</h1>
					</div>
				</div>
			</div>
		</div>
	</div>

<!-- section liste des fonctionnalités -->
<div class="list-section pt-80 pb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="list-box d-flex align-items-center">
                    <div class="list-icon"><i class="fas fa-shipping-fast"></i></div>
                    <div class="content">
                        <h3>Livraison Gratuite</h3>
                        <p>Pour les commandes de plus de 75$</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="list-box d-flex align-items-center">
                    <div class="list-icon"><i class="fas fa-phone-volume"></i></div>
                    <div class="content">
                        <h3>Support 24/7</h3>
                        <p>Assistance disponible toute la journée</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="list-box d-flex align-items-center">
                    <div class="list-icon"><i class="fas fa-sync"></i></div>
                    <div class="content">
                        <h3>Remboursement</h3>
                        <p>Remboursement sous 3 jours !</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- section détail produit -->
<div class="product-section mt-150 mb-150">
    <div class="container">

        <!-- Produit principal -->
        <div class="row mb-80">
            <div class="col-lg-6 text-center">
                <img src="{{ asset('images/products/' . $product->imageProduct) }}"
                     alt="{{ $product->nameProduct }}" class="img-fluid"
                     style="max-height: 400px; object-fit: cover;">
            </div>
            <div class="col-lg-6">
                <h2>{{ $product->nameProduct }}</h2>

                <!-- Note moyenne -->
                <div class="rating mb-2">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fas fa-star {{ $i <= round($averageRating) ? 'text-warning' : 'text-muted' }}"></i>
                    @endfor
                    <small>({{ $totalReviews }} avis)</small>
                </div>

                <p class="product-price"><span>DH</span> {{ $product->priceProduct }}</p>
                <p>{{ $product->descriptionProduct ?? '' }}</p>

                <form action="{{ route('cart.add', $product->idProduct) }}" method="POST">
                    @csrf
                    <div class="d-flex align-items-center mb-3">
                        <input type="number" name="quantity" value="1" min="1"
                               class="form-control w-25 me-3">
                        <button type="submit" class="cart-btn">
                            <i class="fas fa-shopping-cart"></i> Ajouter au Panier
                        </button>
                    </div>
                </form>

                <p class="mt-2"><strong>Catégorie :</strong> {{ $product->category->nameCategory ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Avis clients -->
        <div class="row mb-80">
            <div class="col-lg-12">
                <h3 class="mb-4">Avis Clients</h3>

                @forelse ($product->reviews->where('is_approved', true) as $review)
                    <div class="review-item mb-3 p-3 border rounded">
                        <strong>{{ $review->user->name ?? 'Anonyme' }}</strong>
                        <span class="ms-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </span>
                        <p class="mb-0 mt-1">{{ $review->comment }}</p>
                    </div>
                @empty
                    <p>Aucun avis pour ce produit.</p>
                @endforelse

                <!-- Formulaire avis (connecté + achat obligatoire) -->
                @auth
                    @if ($hasPurchased)
                        <button type="button" class="cart-btn" onclick="document.getElementById('review-form-{{ $product->idProduct }}').scrollIntoView({behavior:'smooth'}); document.getElementById('review-form-{{ $product->idProduct }}').style.display='block';">
                            <i class="fas fa-pen"></i> Laisser un avis
                        </button>

                        <form id="review-form-{{ $product->idProduct }}" action="{{ route('reviews.store', $product->idProduct) }}" method="POST" style="display:none; margin-top:20px;">
                            @csrf
                            <div class="mb-3">
                                <label>Note</label>
                                <select name="rating" class="form-control w-25">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}">{{ $i }} étoile(s)</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Commentaire</label>
                                <textarea name="comment" class="form-control" rows="3"></textarea>
                            </div>
                            <button type="submit" class="cart-btn">Envoyer</button>
                        </form>
                    @else
                        <div class="alert alert-info mt-4">
                            <i class="fas fa-info-circle"></i>
                            Vous devez acheter ce produit et recevoir la commande pour pouvoir laisser un avis.
                        </div>
                    @endif
                @else
                    <div class="alert alert-warning mt-4">
                        <i class="fas fa-lock"></i>
                        <a href="{{ route('login') }}">Connectez-vous</a> pour laisser un avis.
                    </div>
                @endauth
            </div>
        </div>

        <!-- Produits similaires -->
        @if ($relatedProducts->count())
        <div class="row">
            <div class="col-lg-12 text-center mb-4">
                <h3><span class="orange-text">Produits</span> Similaires</h3>
            </div>
            @foreach ($relatedProducts as $related)
            <div class="col-lg-3 col-md-6 text-center">
                <div class="single-product-item">
                    <div class="product-image">
                        <a href="{{ route('products.show', $related->idProduct) }}">
                            <img src="{{ asset('assets/img/products/' . $related->imageProduct) }}"
                                 alt="{{ $related->nameProduct }}">
                        </a>
                    </div>
                    <h3>{{ $related->nameProduct }}</h3>
                    <p class="product-price"><span>DH</span> {{ $related->priceProduct }}</p>
                    <a href="{{ route('products.show', $related->idProduct) }}" class="cart-btn">
                        Voir le produit
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        @endif

    </div>
</div>

@endsection

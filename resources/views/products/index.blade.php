@extends('layouts.masterr')
@section('title','Artisana - Produits')
@section('styles')
<style>

    .product-card-modern {
        background: #fff;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0,0,0,0.05);
        transition: all 0.3s ease;
        height: 100%;
        border: 1px solid #f2f2f2;
        position: relative;
    }

    .product-card-modern:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    }

    .product-img-container {
        position: relative;
        height: 300px; /* Ajusté pour correspondre à la page shop */
        overflow: hidden;
        background-color: #f9f9f9;
    }

    .product-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s ease;
    }

    .product-card-modern:hover .product-img-container img {
        transform: scale(1.1);
    }

    .product-card-details {
        padding: 25px;
        text-align: center;
    }

    .product-category-tag {
        display: block;
        font-size: 11px;
        text-transform: uppercase;
        color: #F28123;
        font-weight: 700;
        margin-bottom: 10px;
        letter-spacing: 1.5px;
    }

    .product-price-tag {
        font-size: 22px;
        font-weight: 800;
        color: #051922;
        margin: 15px 0;
    }
</style>
@endsection
@section('content1')
<!-- breadcrumb-section -->
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
	<!-- end breadcrumb section -->
<!-- section liste des fonctionnalités -->
<div class="list-section pt-80 pb-80">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <div class="list-box d-flex align-items-center">
                    <div class="list-icon"><i class="fas fa-shipping-fast"></i></div>
                    <div class="content">
                        <h3>Livraison Gratuite</h3>
                        <p>Pour les commandes de plus de 75 DH</p>
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

<!-- section produits -->
<div class="product-section mt-150 mb-150">
    <div class="container">

        <!-- Titre -->
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">Nos</span> Produits</h3>
                    <p>Découvrez notre sélection de produits artisanaux de qualité.</p>
                </div>
            </div>
        </div>

        <!-- Filtres modernisés -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="filter-panel p-4 mb-3">
                    <form action="{{ route('products.index') }}" method="GET" class="row g-3">

                        <div class="col-xl-5 col-lg-5 col-md-12">
                            <label class="form-label" for="filter-search">Recherche</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input id="filter-search" type="text" name="search" class="form-control border-start-0" placeholder="Rechercher des produits" value="{{ request('search') }}" aria-label="Recherche de produits">
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <label class="form-label" for="filter-category">Catégorie</label>
                            <select id="filter-category" name="category" class="form-select" aria-label="Filtrer par catégorie">
                                <option value="">Toutes les catégories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->idCategory }}" {{ request('category') == $category->idCategory ? 'selected' : '' }}>{{ $category->nameCategory }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-6">
                            <label class="form-label" for="filter-sort">Trier</label>
                            <select id="filter-sort" name="sort" class="form-select" aria-label="Trier les produits">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Plus récents</option>
                                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Prix croissant</option>
                                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Prix décroissant</option>
                                <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Nom A-Z</option>
                            </select>
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <label class="form-label" for="filter-min-price">Prix min</label>
                            <input id="filter-min-price" type="number" name="min_price" class="form-control" placeholder="Prix min" value="{{ request('min_price') }}" aria-label="Prix minimum">
                        </div>

                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <label class="form-label" for="filter-max-price">Prix max</label>
                            <input id="filter-max-price" type="number" name="max_price" class="form-control" placeholder="Prix max" value="{{ request('max_price') }}" aria-label="Prix maximum">
                        </div>

                        <div class="col-12">
                            <div class="d-flex flex-wrap gap-2 justify-content-start">
                                <button type="submit" class="btn btn-primary filter-btn">Filtrer</button>
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">Réinitialiser</a>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        <!-- Alertes session -->
        @if(session('success'))
            <div class="alert alert-success mb-3">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif

        <!-- Liste produits -->
        <div class="row">
            @forelse ($products as $product)
                <div class="col-lg-4 col-md-6 mb-5">
                    <div class="product-card-modern">
                        <!-- Zone Image -->
                        <div class="product-img-container">
                            <a href="{{ route('products.show', $product->idProduct) }}">
                                <img src="{{ asset('images/products/' . $product->imageProduct) }}"
                                    alt="{{ $product->nameProduct }}"
                                    >
                            </a>
                        </div>

                        <!-- Zone Détails -->
                        <div class="product-card-details">
                            <span class="product-category-tag">Exclusivité Artisanale</span>
                            <h3 class="h5 font-weight-bold mb-0">{{ $product->nameProduct }}</h3>
                            <div class="product-price-tag">DH {{ number_format($product->priceProduct, 2) }}</div>

                            <form action="{{ route('cart.add', $product->idProduct) }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-outline-dark px-4 py-2" style="border-radius: 30px; font-weight: 600; font-size: 13px; transition: 0.3s;">
                                    <i class="fas fa-shopping-cart"></i> Ajouter au Panier
                                </button>
                            </form>
                            <a href="{{ route('products.show', $product->idProduct) }}" class="btn btn-outline-secondary px-4 py-2 mt-2" style="border-radius: 30px; font-weight: 600; font-size: 13px; transition: 0.3s;">
                                DÉCOUVRIR LE PRODUIT
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <p>Aucun produit trouvé.</p>
                    <a href="{{ route('products.index') }}" class="cart-btn">
                        Voir tous les produits
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12 d-flex justify-content-center mt-4">
                {{ $products->withQueryString()->links() }}
            </div>
        </div>

    </div>
</div>

@endsection

@extends('layouts.masterr')

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

        <!-- Filtres -->
        <div class="row mb-4">
            <div class="col-lg-12">
                <form action="{{ route('products.index') }}" method="GET"
                      class="d-flex flex-wrap gap-2 align-items-end">

                    <!-- Recherche -->
                    <div>
                        <input type="text" name="search" class="form-control"
                               placeholder="Rechercher..."
                               value="{{ request('search') }}">
                    </div>

                    <!-- Catégorie -->
                    <div>
                        <select name="category" class="form-control">
                            <option value="">Toutes les catégories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->idCategory }}"
                                    {{ request('category') == $category->idCategory ? 'selected' : '' }}>
                                    {{ $category->nameCategory }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Prix min -->
                    <div>
                        <input type="number" name="min_price" class="form-control"
                               placeholder="Prix min"
                               value="{{ request('min_price') }}">
                    </div>

                    <!-- Prix max -->
                    <div>
                        <input type="number" name="max_price" class="form-control"
                               placeholder="Prix max"
                               value="{{ request('max_price') }}">
                    </div>

                    <!-- Tri -->
                    <div>
                        <select name="sort" class="form-control">
                            <option value="latest"     {{ request('sort') == 'latest'     ? 'selected' : '' }}>Plus récents</option>
                            <option value="price_low"  {{ request('sort') == 'price_low'  ? 'selected' : '' }}>Prix croissant</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Prix décroissant</option>
                            <option value="name"       {{ request('sort') == 'name'       ? 'selected' : '' }}>Nom A-Z</option>
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="cart-btn">Filtrer</button>
                        <a href="{{ route('products.index') }}" class="cart-btn ms-2">Réinitialiser</a>
                    </div>

                </form>
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
                <div class="col-lg-4 col-md-6 text-center mb-4">
                    <div class="single-product-item">

                        <div class="product-image">
                            <a href="{{ route('products.show', $product->idProduct) }}">
                                <img src="{{ asset('images/products/' . $product->imageProduct) }}"
                                    alt="{{ $product->nameProduct }}"
                                    style="width: 100%; height: 200px; object-fit: cover;"
                                    >
                            </a>
                        </div>

                        <h3>{{ $product->nameProduct }}</h3>
                        <p class="product-price">
                            DH {{ number_format($product->priceProduct, 2) }}
                        </p>

                        <form action="{{ route('cart.add', $product->idProduct) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="cart-btn">
                                <i class="fas fa-shopping-cart"></i> Ajouter au Panier
                            </button>
                        </form>

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

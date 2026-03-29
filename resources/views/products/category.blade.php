@extends('layouts.master')

@section('content')

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
                    <h3><span class="orange-text">{{ $category->nameCategory }}</span></h3>
                    <p>Découvrez notre sélection de produits artisanaux de qualité.</p>
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
                <div class="col-lg-4 col-md-6 text-center mb-4">
                    <div class="single-product-item">

                        <div class="product-image">
                            <a href="{{ route('products.show', $product->idProduct) }}">
                                <img src="{{ asset('assets/img/products/' . $product->imageProduct) }}"
                                     alt="{{ $product->nameProduct }}">
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
                    <p>Aucun produit trouvé dans cette catégorie.</p>
                    <a href="{{ route('home') }}" class="cart-btn">
                        Retour à l'accueil
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

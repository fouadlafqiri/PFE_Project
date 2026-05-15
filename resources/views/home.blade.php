@extends('layouts.master')


@section('content')

    <!-- featured products section -->
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Produits</span> en Vedette</h3>
                        <p>Découvrez nos créations artisanales les plus populaires</p>
                    </div>
                </div>
            </div>

            <div class="row">
                @if(isset($featured_products) && $featured_products->isNotEmpty())
                    @foreach ($featured_products->take(6) as $product)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route('products.show', $product->idProduct) }}">
                                    <img src="{{ asset('images/products/' . $product->imageProduct) }}"
                                        alt="{{ $product->nameProduct }}"
                                        style="max-height: 250px; min-height: 250px; object-fit: cover;">
                                </a>
                            </div>
                            <h3>{{ $product->nameProduct }}</h3>
                            <p class="product-price" style="color: #ff9500; font-weight: bold; font-size: 18px;">
                                {{ $product->priceProduct }} DH
                            </p>
                            <a href="{{ route('products.show', $product->idProduct) }}" class="boxed-btn">Voir plus</a>
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="col-12 text-center">
                        <p>Aucun produit en vedette pour le moment.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- end featured products section -->

    <!-- categories section -->
    <div class="product-section mt-150 mb-150" style="background-color: #f9f9f9;">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Nos</span> Catégories</h3>
                        <p>Les produits de haute qualité disponibles chez nous</p>
                    </div>
                </div>
            </div>

            <div class="row">
                @foreach ($categories as $category)
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="single-product-item">
                        <div class="product-image">
                            {{-- ✅ Fixed link --}}
                            <a href="{{ route('products.category', $category->idCategory) }}">
                                <img src="{{ asset('assets/img/categories/' . $category->imageCategory) }}"
                                    alt="{{ $category->nameCategory }}"
                                    style="max-height: 250px; min-height: 250px; object-fit: cover;">
                            </a>
                        </div>
                        <h3>{{ $category->nameCategory }}</h3>
                        <p>{{ $category->descriptionCategory }}</p>
                        <a href="{{ route('products.category', $category->idCategory) }}" class="boxed-btn">Voir catégorie</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- end categories section -->

    <!-- why us section -->
    <div class="why-us-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Pourquoi</span> Nous Choisir ?</h3>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-center" style="border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <i class="fas fa-leaf" style="font-size: 40px; color: #ff9500; margin-bottom: 15px;"></i>
                            <h5 class="card-title">100% Authentique</h5>
                            <p class="card-text">Produits artisanaux fabriqués à la main par des artisans talentueux</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-center" style="border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <i class="fas fa-shipping-fast" style="font-size: 40px; color: #ff9500; margin-bottom: 15px;"></i>
                            <h5 class="card-title">Livraison Rapide</h5>
                            <p class="card-text">Livraison gratuite à partir de 75 DH dans tout le pays</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card text-center" style="border: none; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <div class="card-body">
                            <i class="fas fa-undo" style="font-size: 40px; color: #ff9500; margin-bottom: 15px;"></i>
                            <h5 class="card-title">Retour Facile</h5>
                            <p class="card-text">Retour gratuit sous 30 jours si vous n'êtes pas satisfait</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end why us section -->

    <!-- cta section -->
    <div class="mt-150 mb-150" style="background: linear-gradient(135deg, #ff9500 0%, #ffb84d 100%); padding: 60px 0; color: white;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 style="margin: 0; color: white;">Découvrez Notre Collection Complète</h2>
                    <p style="margin: 10px 0 0 0; font-size: 16px;">Explorez tous nos produits artisanaux et trouvez votre coup de cœur</p>
                </div>
                <div class="col-lg-4 text-right">
                    <a href="/products" class="bordered-btn" style="border-color: white; color: white;">Voir Tous les Produits</a>
                </div>
            </div>
        </div>
    </div>
    <!-- end cta section -->

@endsection


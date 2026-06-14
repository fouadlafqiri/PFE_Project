@extends('layouts.masterr')
@section('title', 'Artisana - Actualités')
@section('content1')

<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Actualités</p>
                    <h1>Nos Articles</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- latest news -->
<div class="latest-news mt-150 mb-150">
    <div class="container">

        <!-- News Grid -->
        <div class="row">
            @forelse($news as $article)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="single-latest-news">
                    <div class="latest-news-bg"
                         style="background-image: url('{{ $article->image
                             ? asset('assets/img/news/' . $article->image)
                             : asset('assets/img/news/default.jpg') }}');">
                    </div>
                    <div class="news-text-box">
                        <h3>{{ $article->title }}</h3>
                        <p class="blog-meta">
                            <span class="author">
                                <i class="fas fa-user"></i> {{ $article->author }}
                            </span>
                            <span class="date">
                                <i class="fas fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($article->created_at)->format('d F, Y') }}
                            </span>
                        </p>
                        <p class="excerpt">{{ Str::limit($article->excerpt, 100) }}</p>
                        <a href="{{ route('news.show', $article->idNews) }}" class="boxed-btn mt-3">Lire l'article</a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p>Aucun article disponible pour le moment.</p>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="pagination-wrap">
                    {{ $news->links() }}
                </div>
            </div>
        </div>

        <!-- Latest Products Section -->
        <div class="row mt-5">
            <div class="col-lg-8 offset-lg-2 text-center mb-4">
                <div class="section-title">
                    <h3><span class="orange-text">Derniers</span> Produits</h3>
                    <p>Découvrez nos produits récemment ajoutés.</p>
                </div>
            </div>
        </div>

        <div class="row">
            @foreach($latestProducts as $product)
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
                    <p class="product-price"><span>DH</span> {{ number_format($product->priceProduct, 2) }}</p>
                    <form action="{{ route('cart.add', $product->idProduct) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="modern-cart-btn">
                            <i class="fas fa-shopping-cart"></i> Ajouter au Panier
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>

@endsection

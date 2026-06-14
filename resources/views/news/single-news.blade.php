@extends('layouts.masterr')
@section('title', 'Artisana - ' . $news->title)
@section('content1')

<!-- breadcrumb -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Lire les détails</p>
                    <h1>Article</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- single article -->
<div class="mt-150 mb-150">
    <div class="container">
        <div class="row">

            <!-- Article principal -->
            <div class="col-lg-8">
                <div class="single-article-section">
                    <div class="single-article-text">

                        @if($news->image)
                            <div class="single-artcile-bg"
                                 style="background-image: url('{{ asset('assets/img/news/' . $news->image) }}');
                                        background-size: cover;
                                        background-position: center;
                                        height: 400px;
                                        margin-bottom: 30px;">
                            </div>
                        @else
                            <div class="single-artcile-bg" style="margin-bottom: 30px;"></div>
                        @endif

                        <p class="blog-meta">
                            <span class="author">
                                <i class="fas fa-user"></i> {{ $news->author }}
                            </span>
                            <span class="date">
                                <i class="fas fa-calendar"></i>
                                {{ \Carbon\Carbon::parse($news->created_at)->format('d F, Y') }}
                            </span>
                        </p>

                        <h2>{{ $news->title }}</h2>
                        <p>{{ $news->content }}</p>

                        <a href="{{ route('news.index') }}" class="boxed-btn mt-3">
                            ← Retour aux actualités
                        </a>

                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar-section">

                    <!-- Articles récents -->
                    <div class="recent-posts mb-4">
                        <h4>Articles Récents</h4>
                        <ul>
                            @foreach($recentNews as $recent)
                                <li>
                                    <a href="{{ route('news.show', $recent->idNews) }}">
                                        {{ Str::limit($recent->title, 50) }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Derniers produits ajoutés -->
                    <div class="recent-posts">
                        <h4>Nouveaux Produits</h4>
                        <ul>
                            @foreach($latestProducts as $product)
                                <li style="display:flex; align-items:center; gap:10px; margin-bottom:15px;">
                                    <img src="{{ asset('images/products/' . $product->imageProduct)}}"
                                         alt="{{ $product->nameProduct }}"
                                         style="width:60px; height:60px; object-fit:cover; border-radius:4px;">
                                    <div>
                                        <a href="{{ route('products.show', $product->idProduct) }}"
                                           style="display:block; font-weight:600;">
                                            {{ Str::limit($product->nameProduct, 30) }}
                                        </a>
                                        <span style="color:#f28123;">
                                            DH {{ number_format($product->priceProduct, 2) }}
                                        </span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@extends('layouts.master')


@section('content')




    <!-- product section -->
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">

                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Nos</span> Categories</h3>
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
                                    style="max-height: 250px; min-height: 250px;">
                            </a>
                        </div>
                        <h3>{{ $category->nameCategory }}</h3>
                        <p>{{ $category->descriptionCategory }}</p>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- end product section -->





@endsection

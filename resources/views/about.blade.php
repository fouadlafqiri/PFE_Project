@extends('layouts.masterr')

@section('title', 'À propos de nous')

@section('content1')

    <div class="breadcrumb-section breadcrumb-bg">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="breadcrumb-text">
                        <p>Savoir-faire et Authenticité</p>
                        <h1>À propos de notre boutique artisanale</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="about-us-section mt-150 mb-150">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="about-content">
                        <div class="section-title">
                            <h3><span class="orange-text">Notre</span> Histoire</h3>
                            <p>Nous réunissons des artisans passionnés et des créations authentiques pour faire vivre
                                votre intérieur avec des pièces originales et be
lles.</p>
                        </div>
                        <p>Depuis notre création, nous valorisons la qualité, le savoir-faire traditionnel et le commerce
                            équitable. Chaque produit est sélectionné avec soin pour offrir une expérience d'achat
                            responsable et inspirante.</p>
                        <ul class="list-unstyled" style="margin-top: 20px;">
                            <li><i class="fas fa-check" style="color: #ff9500; margin-right: 10px;"></i>Artisanat marocain authentique</li>
                            <li><i class="fas fa-check" style="color: #ff9500; margin-right: 10px;"></i>Matériaux durables et éco-responsables</li>
                            <li><i class="fas fa-check" style="color: #ff9500; margin-right: 10px;"></i>Livraison soignée partout au Maroc</li>
                        </ul>
                        <a href="/products" class="boxed-btn">Découvrir nos produits</a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-image" style="border-radius: 20px; overflow: hidden; box-shadow: 0 20px 60px rgba(0,0,0,0.12);">
                        <img src="{{ asset('assets/img/background/moroccan-area-rugs-1.jpeg') }}" alt="Artisanat" style="width: 100%; height: 100%; object-fit: cover;" />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="feature-section pb-150" style="background-color: #f9f9f9; padding-top: 80px; padding-bottom: 80px;">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-8 offset-lg-2">
                    <div class="section-title">
                        <h3><span class="orange-text">Nos</span> Engagements</h3>
                        <p>Nous plaçons la confiance, la transparence et la créativité au cœur de chaque commande.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="single-service-item text-center" style="padding: 30px; border-radius: 20px; background: #fff; box-shadow: 0 15px 35px rgba(0,0,0,0.08);">
                        <i class="fas fa-handshake" style="font-size: 36px; color: #ff9500; margin-bottom: 20px;"></i>
                        <h5>Commerce Équitable</h5>
                        <p>Nous soutenons les artisans et garantissons des conditions de travail respectueuses.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="single-service-item text-center" style="padding: 30px; border-radius: 20px; background: #fff; box-shadow: 0 15px 35px rgba(0,0,0,0.08);">
                        <i class="fas fa-palette" style="font-size: 36px; color: #ff9500; margin-bottom: 20px;"></i>
                        <h5>Design Authentique</h5>
                        <p>Chaque création est pensée pour sublimer votre décoration avec un style unique.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="single-service-item text-center" style="padding: 30px; border-radius: 20px; background: #fff; box-shadow: 0 15px 35px rgba(0,0,0,0.08);">
                        <i class="fas fa-shipping-fast" style="font-size: 36px; color: #ff9500; margin-bottom: 20px;"></i>
                        <h5>Livraison Rapide</h5>
                        <p>Expédition fiable et emballage sécurisé pour une arrivée parfaite de vos achats.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="stat-section mt-150 mb-150">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="section-title text-left">
                        <h3><span class="orange-text">Notre</span> Mission</h3>
                        <p>Offrir une expérience de shopping artisanale moderne et chaleureuse, tout en valorisant le talent
                            local et les traditions.</p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="counter-box text-center" style="padding: 30px; background: #fff; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
                                <h2 style="color: #ff9500; margin-bottom: 10px;">+120</h2>
                                <p>Produits exclusifs</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="counter-box text-center" style="padding: 30px; background: #fff; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
                                <h2 style="color: #ff9500; margin-bottom: 10px;">+50</h2>
                                <p>Artisans partenaires</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="counter-box text-center" style="padding: 30px; background: #fff; border-radius: 20px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
                                <h2 style="color: #ff9500; margin-bottom: 10px;">4.9/5</h2>
                                <p>Satisfaction client</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="cta-section" style="background: linear-gradient(135deg, #07212e 0%, #0f3b51 100%); color: #fff; padding: 80px 0;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2 style="margin-bottom: 10px;">Prêt à découvrir un artisanat raffiné ?</h2>
                    <p style="font-size: 16px; max-width: 560px;">Parcourez notre collection et trouvez des pièces uniques qui racontent une histoire.</p>
                </div>
                <div class="col-lg-4 text-lg-right text-center">
                    <a href="/products" class="boxed-btn" style="background: rgb(227, 142, 22); border: none;">Voir la boutique</a>
                </div>
            </div>
        </div>
    </div>

@endsection

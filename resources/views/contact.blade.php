@extends('layouts.masterr')
@section('title', 'Contact')
@section('content1')

<!-- Breadcrumb Section -->
<div class="breadcrumb-section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="breadcrumb-text">
                    <p>Tradition • Authenticité • Qualité</p>
                    <h1>Contactez Produit Artisanal</h1>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Form Section -->
<div class="contact-from-section mt-150 mb-150">
    <div class="container">
        <div class="row">

            <!-- Formulaire -->
            <div class="col-lg-8 mb-5 mb-lg-0">

                <!-- Logo -->


                <div class="form-title">
                    <h2>Une question sur nos produits artisanaux ?</h2>



                    <p>
                        Nous sommes à votre disposition pour répondre à toutes vos questions concernant
                        nos produits artisanaux, vos commandes ou les modalités de livraison.
                        N'hésitez pas à nous contacter via le formulaire ci-dessous.
                        Notre équipe vous répondra dans les meilleurs délais.
                    </p>
                </div>

                <div id="form_status"></div>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="contact-form">
                    <form method="POST"
                          action="{{ route('contact.store') }}"
                          id="artisan-contact"
                          onSubmit="return valid_datas(this);">

                        @csrf

                        <p>
                            <input type="text"
                                   placeholder="Nom complet"
                                   name="name"
                                   id="name"
                                   required>

                            <input type="email"
                                   placeholder="Adresse e-mail"
                                   name="email"
                                   id="email"
                                   required>
                        </p>

                        <p>
                            <input type="tel"
                                   placeholder="Numéro de téléphone"
                                   name="phone"
                                   id="phone">

                            <input type="text"
                                   placeholder="Objet de votre demande"
                                   name="subject"
                                   id="subject"
                                   required>
                        </p>

                        <p>
                            <textarea
                                name="message"
                                id="message"
                                cols="30"
                                rows="10"
                                placeholder="Écrivez votre message ici..."
                                required></textarea>
                        </p>

                        <p>
                            <input type="submit" value="Envoyer le message">
                        </p>

                    </form>
                </div>

                <!-- Avantages -->
                <div class="row mt-5 text-center">

                    <div class="col-md-4">
                        <i class="fas fa-hands fa-3x text-warning mb-3"></i>
                        <h5>Savoir-faire artisanal</h5>
                        <p>
                            Des créations réalisées avec passion par des artisans qualifiés.
                        </p>
                    </div>

                    <div class="col-md-4">
                        <i class="fas fa-shipping-fast fa-3x text-warning mb-3"></i>
                        <h5>Livraison rapide</h5>
                        <p>
                            Livraison sécurisée partout au Maroc.
                        </p>
                    </div>

                    <div class="col-md-4">
                        <i class="fas fa-award fa-3x text-warning mb-3"></i>
                        <h5>Qualité garantie</h5>
                        <p>
                            Produits soigneusement sélectionnés pour leur qualité.
                        </p>
                    </div>

                </div>

            </div>

            <!-- Informations -->
            <div class="col-lg-4">
                <div class="contact-form-wrap">

                    <div class="contact-form-box">
                        <h4><i class="fas fa-map"></i> Adresse</h4>
                        <p>
                            Sidi Kacem<br>
                            Région Rabat-Salé-Kénitra<br>
                            Maroc
                        </p>
                    </div>

                    <div class="contact-form-box">
                        <h4><i class="far fa-clock"></i> Horaires d'ouverture</h4>
                        <p>
                            Lundi - Vendredi : 08h00 - 18h00<br>
                            Samedi : 09h00 - 16h00<br>
                            Dimanche : Fermé
                        </p>
                    </div>

                    <div class="contact-form-box">
                        <h4><i class="fas fa-address-book"></i> Contact</h4>
                        <p>
                            Téléphone : +212 653 0844 12<br>
                            Email : fouadfaqiri123@gmail.com
                        </p>
                    </div>

                    <div class="contact-form-box">
                        <h4><i class="fas fa-share-alt"></i> Réseaux Sociaux</h4>

                        <a href="#" class="mr-3">
                            <i class="fab fa-facebook-f"></i>
                        </a>

                        <a href="#" class="mr-3">
                            <i class="fab fa-instagram"></i>
                        </a>

                        <a href="#">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Localisation -->
<div class="find-location blue-bg">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <p>
                    <i class="fas fa-map-marker-alt"></i>
                    Découvrez l'emplacement de notre atelier artisanal
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Google Maps -->
<div class="embed-responsive embed-responsive-21by9">
    <iframe
        src="https://www.google.com/maps?q=Sidi+Kacem,+Morocco&output=embed"
        width="100%"
        height="450"
        style="border:0;"
        allowfullscreen
        loading="lazy">
    </iframe>
</div>

@endsection

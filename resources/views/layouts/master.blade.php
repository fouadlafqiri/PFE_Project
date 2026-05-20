<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content=".............">

    <!-- titre -->
    <title>E-commerce website</title>

    <!-- favicon -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <!-- fontawesome -->
    <link rel="stylesheet" href="{{ asset('assets/css/all.min.css') }}">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">
    <!-- owl carousel -->
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.css') }}">
    <!-- magnific popup -->
    <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css') }}">
    <!-- animate css -->
    <link rel="stylesheet" href="{{ asset('assets/css/animate.css') }}">
    <!-- mean menu css -->
    <link rel="stylesheet" href="{{ asset('assets/css/meanmenu.min.css') }}">
    <!-- style principal -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
    <!-- responsive -->
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    <style>
        .button-container {
    display: flex;
    align-items: center;
    gap: 10px;
}

.button-container a,
.button-container form {
    padding: 8px 16px;
    font-size: 14px;
}

.button-container a:hover,
.button-container form:hover {
    opacity: 0.8;
}

.button-container .admin-btn {
    /* Add any specific styling for the admin button */
}

.button-container .logout-btn {
    /* Add any specific styling for the logout button */
}
    </style>
</head>

<body>

    <!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->

    <!-- en-tête -->
    <div class="top-header-area" id="sticker">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-sm-12 text-center">
                    <div class="main-menu-wrap">
                        <!-- logo -->
                        <div class="site-logo">
                            <a href="/">
                                <img src="{{ asset('assets/img/logo/logo_artisan.png') }}" alt=""
                                    style="max-height: 100px">
                            </a>
                        </div>
                        <!-- logo -->

                        <!-- menu début -->
                        <nav class="main-menu">
                            <ul>
                                <li class="current-list-item"><a href="/">Accueil</a>
                                </li>
                                <li><a href="/products">Les produits</a></li>
                                <li><a href="/about">À propos</a></li>
                                {{-- <li><a href="#">Pages</a>
									<ul class="sub-menu">
										<li><a href="404.html">Page 404</a></li>
										<li><a href="about.html">À propos</a></li>
										<li><a href="cart.html">Panier</a></li>
										<li><a href="checkout.html">Paiement</a></li>
										<li><a href="contact.html">Contact</a></li>
										<li><a href="news.html">Actualités</a></li>
										<li><a href="shop.html">Boutique</a></li>
									</ul>
								</li> --}}
                                <li><a href="/news">Actualités</a>

                                </li>
                                <li><a href="/contact">Contact</a></li>
                                <li><a href="#">Boutique</a>
                                    <ul class="sub-menu">
                                        <li><a href="/shop">Boutique</a></li>
                                        <li><a href="/checkout">Paiement</a></li>
                                        <li><a href="/orders">Commandes</a></li>
                                        <li><a href="/cart">Panier</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </nav>

                        <div class="header-actions">
                            <div class="header-icons">
                                <a class="shopping-cart" href="/cart"><i class="fas fa-shopping-cart"></i></a>
                                {{-- Profile Dropdown --}}
                                @guest
                                    <a href="{{ route('login') }}" class="boxed-btn"
                                        style="margin-left:10px; padding:8px 16px; font-size:14px;">Connexion</a>
                                @else
                                    <div class="profile-wrap" style="position:relative; margin-left:10px;">
                                        <button type="button" class="profile-trigger" onclick="toggleProfileDrop(event)">
                                            @if (Auth::user()->photo)
                                                <img src="{{ Auth::user()->photo }}" alt="avatar"
                                                    style="width:40px;height:40px;border-radius:50%;object-fit:cover;" />
                                            @else
                                                <span class="avatar-initials"
                                                    style="width:40px;height:40px;display:inline-flex;align-items:center;justify-content:center;border-radius:50%;background:#333;color:#fff;font-size:14px;">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                                            @endif
                                            <span>{{ explode(' ', Auth::user()->name)[0] }}</span>
                                            <i class="fas fa-chevron-down"></i>
                                        </button>
                                        <div class="profile-drop" id="profileDrop">
                                            <div class="profile-drop-header">
                                                <strong>{{ Auth::user()->name }}</strong>
                                                <small>{{ Auth::user()->email }}</small>
                                                @if (Auth::user()->phone)
                                                    <small>{{ Auth::user()->phone }}</small>
                                                @endif
                                            </div>
                                            {{-- Admin only button --}}
                                            @if (Auth::user()->role === 'admin')
                                                <a href="{{ route('admin.dashboard') }}" class="admin-btn">
                                                    <i class="fas fa-gauge"></i> Dashboard Admin
                                                </a>
                                                <div class="drop-divider"></div>
                                            @endif
                                            <a href="{{ route('profile') }}"><i class="fas fa-user-pen"></i> Mon
                                                profil</a>
                                            <a href="{{ route('orders.index') }}"><i class="fas fa-box"></i> Mes
                                                commandes</a>
                                            <div class="drop-divider"></div>
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit" class="logout-btn">
                                                    <i class="fas fa-right-from-bracket"></i> Déconnexion
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @endguest
                            </div>
                        </div>

                        <a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>

                        <div class="mobile-menu">

                        </div>
                        {{-- login --}}

                        <!-- menu fin -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- fin en-tête -->
    <!-- slider page d'accueil -->
    <div class="homepage-slider">
        <!-- slider unique page d'accueil -->
        <div class="single-homepage-slider homepage-bg-1">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-7 offset-lg-1 offset-xl-0">
                        <div class="hero-text">
                            <div class="hero-text-tablecell">
                                <p class="subtitle">Fait Main & Authentique</p>
                                <h1>Produits Artisanaux Traditionnels</h1>
                                <div class="hero-btns">
                                    <a href="/shop" class="boxed-btn">Notre Collection</a>
                                    <a href="/contact" class="bordered-btn">Contactez-nous</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider unique page d'accueil -->
        <div class="single-homepage-slider homepage-bg-2">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <div class="hero-text">
                            <div class="hero-text-tablecell">
                                <p class="subtitle">Qualité Supérieure</p>
                                <h1>Collection 100% Artisanale</h1>
                                <div class="hero-btns">
                                    <a href="/shop" class="boxed-btn">Visitez la Boutique</a>
                                    <a href="/contact" class="bordered-btn">Contactez-nous</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- slider unique page d'accueil -->
        <div class="single-homepage-slider homepage-bg-3">
            <div class="container">
                <div class="row">
                    <div class="col-lg-10 offset-lg-1 text-right">
                        <div class="hero-text">
                            <div class="hero-text-tablecell">
                                <p class="subtitle">Méga Soldes en Cours !</p>
                                <h1>Obtenez la Réduction de Décembre</h1>
                                <div class="hero-btns">
                                    <a href="/shop" class="boxed-btn">Visitez la Boutique</a>
                                    <a href="/contact" class="bordered-btn">Contactez-nous</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- fin slider page d'accueil -->
    {{-- yield for the content --}}

    <div class="main-content">
    @yield('content')
</div>




    <!-- footer -->
    <div class="footer-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box about-widget">
                        <h2 class="widget-title">À propos de nous</h2>
                        <p>Découvrez notre collection unique de produits artisanaux, fabriqués à la main par des
                            artisans talentueux avec passion et savoir-faire traditionnel.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box get-in-touch">
                        <h2 class="widget-title">Contactez-nous</h2>
                        <ul>
                            <li>34/8, East Hukupara, Gifirtok, Sadan.</li>
                            <li>support@fruitkha.com</li>
                            <li>+00 111 222 3333</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box pages">
                        <h2 class="widget-title">Pages</h2>
                        <ul>
                            <li><a href="/index">Accueil</a></li>
                            <li><a href="/about">À propos</a></li>
                            <li><a href="/services">Boutique</a></li>
                            <li><a href="/news">Actualités</a></li>
                            <li><a href="/contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-box subscribe">
                        <h2 class="widget-title">S'abonner</h2>
                        <p>Abonnez-vous à notre liste de diffusion pour recevoir les dernières mises à jour.</p>
                        <form action="index">
                            <input type="email" placeholder="Email">
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end footer -->

    <!-- copyright -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-12">
                    <p>Droits d'auteur &copy; 2026 - <a href="https://imransdesign.com/">Sidi Kacem</a>, Tous droits
                        réservés.<br>
                        Distribué par - <a href="https://themewagon.com/"></a>
                    </p>
                </div>
                <div class="col-lg-6 text-right col-md-12">
                    <div class="social-icons">
                        <ul>
                            <li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                            <li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end copyright -->

    <!-- jquery -->
    <script src="{{ asset('assets/js/jquery-1.11.3.min.js') }}"></script>
    <!-- bootstrap -->
    <script src="{{ asset('assets/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- count down -->
    <script src="{{ asset('assets/js/jquery.countdown.js') }}"></script>
    <!-- isotope -->
    <script src="{{ asset('assets/js/jquery.isotope-3.0.6.min.js') }}"></script>
    <!-- waypoints -->
    <script src="{{ asset('assets/js/waypoints.js') }}"></script>
    <!-- owl carousel -->
    <script src="{{ asset('assets/js/owl.carousel.min.js') }}"></script>
    <!-- magnific popup -->
    <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
    <!-- mean menu -->
    <script src="{{ asset('assets/js/jquery.meanmenu.min.js') }}"></script>
    <!-- sticker js -->
    <script src="{{ asset('assets/js/sticker.js') }}"></script>
    <!-- main js -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script>
        window.toggleProfileDrop = function(e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            var wrap = e && e.currentTarget ? e.currentTarget.closest('.profile-wrap') : document.querySelector('.profile-wrap');
            if (wrap) {
                wrap.classList.toggle('open');
            }
        };

        document.addEventListener('click', function() {
            var w = document.querySelector('.profile-wrap.open');
            if (w) w.classList.remove('open');
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.profile-trigger').forEach(function(btn) {
                btn.style.cursor = 'pointer';
            });
        });
    </script>
</body>

</html>

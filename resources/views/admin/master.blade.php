<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin - Produit Artisanal</title>

    <link href="{{ asset('assets/admin-dashboard/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
    <div class="wrapper">

        {{-- Sidebar --}}
        <nav id="sidebar" class="sidebar js-sidebar">
            <div class="sidebar-content js-simplebar">
                <a class="sidebar-brand" href="{{ route('admin.dashboard') }}">
                    <span class="align-middle">Produit Artisanal</span>
                </a>

                <ul class="sidebar-nav">

                    @if(auth()->user()->role === 'admin')
                        <li class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.dashboard') }}">
                                <i class="align-middle" data-feather="sliders"></i>
                                <span class="align-middle">Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.products.index') }}">
                                <i class="align-middle" data-feather="package"></i>
                                <span class="align-middle">Produits</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.categories.index') }}">
                                <i class="align-middle" data-feather="grid"></i>
                                <span class="align-middle">Catégories</span>
                            </a>
                        </li>
                        <li class="sidebar-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.reviews.index') }}">
                                <i class="align-middle" data-feather="grid"></i>
                                <span class="align-middle">Reviews</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.contacts.index') }}">
                                <i class="align-middle" data-feather="mail"></i>
                                <span class="align-middle">Messages</span>
                            </a>
                        </li>

                        <li class="sidebar-item {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.news.index') }}">
                                <i class="align-middle" data-feather="book-open"></i>
                                <span class="align-middle">Actualités</span>
                            </a>
                        </li>
                    @endif

                    <li class="sidebar-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.orders.index') }}">
                            <i class="align-middle" data-feather="shopping-cart"></i>
                            <span class="align-middle">Commandes</span>
                        </a>
                    </li>

                    @if(auth()->user()->role === 'admin')
                        <li class="sidebar-item {{ request()->routeIs('admin.deliveries.*') ? 'active' : '' }}">
                            <a class="sidebar-link" href="{{ route('admin.deliveries.index') }}">
                                <i class="align-middle" data-feather="truck"></i>
                                <span class="align-middle">Livreurs</span>
                            </a>
                        </li>
                    @endif

                    <li class="sidebar-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                        <a class="sidebar-link" href="{{ route('admin.profile') }}">
                            <i class="align-middle" data-feather="user"></i>
                            <span class="align-middle">Profil</span>
                        </a>
                    </li>

                </ul>
            </div>
        </nav>

        {{-- Main Content --}}
        <div class="main">

            {{-- Top Navbar --}}
            <nav class="navbar navbar-expand navbar-light navbar-bg">
                <a class="sidebar-toggle js-sidebar-toggle">
                    <i class="hamburger align-self-center"></i>
                </a>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav navbar-align">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-none d-sm-inline-block"
                               href="#" data-bs-toggle="dropdown">
                                <i class="align-middle me-1" data-feather="user"></i>
                                <span class="text-dark">{{ auth()->user()->name ?? 'Admin' }}</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <a class="dropdown-item" href="{{ route('admin.profile') }}">
                                    <i class="align-middle me-1" data-feather="user"></i> Profil
                                </a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="align-middle me-1" data-feather="log-out"></i> Déconnexion
                                    </button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>

            {{-- Page Content --}}
            <main class="content">
                <div class="container-fluid p-0">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @yield('admin-content')
                </div>
            </main>

            {{-- Footer --}}
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-muted">
                        <div class="col-6 text-start">
                            <p class="mb-0"><strong>Produit Artisanal</strong> &copy; {{ date('Y') }}</p>
                        </div>
                        <div class="col-6 text-end">
                            {{--  --}}
                             @if(auth()->user()->role === 'admin')
                                    <a href="{{ route('home') }}" class="text-muted">Voir le site</a>
                                @endif
                            {{--  --}}

                        </div>
                    </div>
                </div>
            </footer>

        </div>
    </div>

    <script src="{{ asset('assets/admin-dashboard/js/app.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const alerts = document.querySelectorAll('.alert.alert-dismissible.fade.show');
            if (!alerts.length) {
                return;
            }

            setTimeout(function () {
                alerts.forEach(function (alert) {
                    if (window.bootstrap && typeof window.bootstrap.Alert === 'function') {
                        window.bootstrap.Alert.getOrCreateInstance(alert).close();
                    } else {
                        alert.classList.remove('show');
                        alert.classList.add('hide');
                        alert.remove();
                    }
                });
            }, 3500);
        });
    </script>
</body>
</html>

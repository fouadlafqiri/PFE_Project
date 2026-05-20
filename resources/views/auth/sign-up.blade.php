@extends('layouts.masterr')

@section('title', 'Artisan - Inscription')
@section('body-class', 'login-page')

@section('styles')
    <style>
        .login-page{
            margin:0;
            padding:0;
            min-height:100vh;
            background:
                linear-gradient(rgba(5,25,34,0.82), rgba(5,25,34,0.82)),
                url('{{ asset('assets/img/background/img-bg-1.avif') }}') center center/cover no-repeat;
            position:relative;
            font-family:'Poppins', sans-serif;
        }

        .login-overlay{
            position:absolute;
            inset:0;
            background:rgba(0,0,0,0.65);
            z-index:1;
        }

        .login-container{
            position:relative;
            z-index:2;
            min-height:calc(100vh - 120px);
            display:flex;
            justify-content:center;
            align-items:center;
            padding:120px 30px 60px;
        }

        .login-box{
            width:100%;
            max-width:450px;
            margin:0 auto;
        }

        .login-card{
            background:rgba(255,255,255,0.08);
            border:1px solid rgba(255,255,255,0.12);
            backdrop-filter:blur(18px);
            border-radius:24px;
            padding:45px;
            box-shadow:0 10px 40px rgba(0,0,0,0.45);
        }

        .login-logo img{
            width:150px;
            filter:drop-shadow(0 5px 15px rgba(0,0,0,0.35));
        }

        .login-subtitle{
            color:#F28123;
            letter-spacing:5px;
            font-size:15px;
            font-weight:600;
        }

        .login-title{
            color:#ffffff;
            font-size:52px;
            font-weight:700;
            margin-bottom:15px;
        }

        .login-text{
            color:#dcdcdc;
            font-size:17px;
        }

        .form-label{
            color:#ffffff;
            font-weight:500;
            margin-bottom:10px;
        }

        .custom-input{
            background:rgba(255,255,255,0.10);
            border:1px solid rgba(255,255,255,0.15);
            color:#fff;
            height:58px;
            border-radius:14px;
            padding:15px 18px;
            transition:0.3s;
        }

        .custom-input::placeholder{
            color:#d0d0d0;
        }

        .custom-input:focus{
            background:rgba(255,255,255,0.15);
            border-color:#F28123;
            box-shadow:0 0 0 4px rgba(242,129,35,0.15);
            color:#fff;
        }

        .login-btn{
            width:100%;
            height:58px;
            border:none;
            border-radius:14px;
            background:#F28123;
            color:#fff;
            font-size:17px;
            font-weight:600;
            transition:0.3s;
        }

        .login-btn:hover{
            background:#ff9b47;
            transform:translateY(-2px);
            box-shadow:0 10px 20px rgba(242,129,35,0.35);
        }

        .register-link{
            color:#F28123;
            font-weight:600;
            text-decoration:none;
        }

        .register-link:hover{
            color:#fff;
        }

        @media(max-width:768px){
            .login-title{
                font-size:42px;
            }
            .login-card{
                padding:30px;
            }
            .login-container{
                padding:80px 20px 40px;
            }
        }
    </style>
@endsection

@section('content1')
    <div class="login-overlay"></div>
    <main class="login-container">

        <div class="login-box register-box">

            <!-- Logo -->
            <div class="login-logo">
                <img src="{{ asset('assets/img/logo/logo_artisan.png') }}" alt="Logo">
            </div>

            <!-- Header -->
            <div class="text-center mb-4">

                <p class="login-subtitle">
                    REJOIGNEZ NOTRE COMMUNAUTÉ
                </p>

                <h1 class="login-title">
                    Créer un Compte
                </h1>

                <p class="login-text">
                    Découvrez nos produits artisanaux authentiques
                </p>

            </div>

            <!-- Card -->
            <div class="login-card">

                <form method="POST"
                      action="{{ route('register') }}"
                      enctype="multipart/form-data">

                    @csrf

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Nom -->
                    <div class="mb-3">
                        <label class="form-label">
                            Nom complet
                        </label>

                        <input
                            class="form-control custom-input"
                            type="text"
                            name="name"
                            placeholder="Entrez votre nom"
                            value="{{ old('name') }}"
                            required
                        />
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">
                            Adresse Email
                        </label>

                        <input
                            class="form-control custom-input"
                            type="email"
                            name="email"
                            placeholder="Entrez votre email"
                            value="{{ old('email') }}"
                            required
                        />
                    </div>

                    <!-- Téléphone -->
                    <div class="mb-3">
                        <label class="form-label">
                            Téléphone
                        </label>

                        <input
                            class="form-control custom-input"
                            type="text"
                            name="phone"
                            placeholder="Entrez votre numéro"
                            value="{{ old('phone') }}"
                        />
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">
                            Mot de passe
                        </label>

                        <input
                            class="form-control custom-input"
                            type="password"
                            name="password"
                            placeholder="Entrez votre mot de passe"
                            required
                        />
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label class="form-label">
                            Confirmez le mot de passe
                        </label>
                        <input
                            class="form-control custom-input"
                            type="password"
                            name="password_confirmation"
                            placeholder="Confirmez votre mot de passe"
                            required
                        />
                    </div>
                    <!-- Button -->
                    <div class="d-grid">
                        <button type="submit" class="login-btn">
                            Créer un compte
                        </button>
                    </div>

                </form>

            </div>

            <!-- Login -->
            <div class="text-center mt-4">

                <span class="text-light">
                    Vous avez déjà un compte ?
                </span>

                <a href="/login" class="register-link">
                    Se connecter
                </a>

            </div>

        </div>

    </main>
@endsection

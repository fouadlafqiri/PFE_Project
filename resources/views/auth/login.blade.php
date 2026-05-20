@extends('layouts.masterr')

@section('title', 'Artisan - Connexion')
@section('body-class', 'login-page')

@section('styles')
    <style>
        /* LOGIN PAGE */
        .login-page{
            margin:0;
            padding:0;
            min-height:100vh;
            background:
                linear-gradient(rgba(5,25,34,0.72), rgba(5,25,34,0.72)),
                url('{{ asset('assets/img/background/img-bg-1.avif') }}') center center/cover no-repeat;
            position:relative;
            font-family:'Poppins', sans-serif;
        }

        /* OVERLAY */
        .login-overlay{
            position:absolute;
            inset:0;
            background:rgba(0,0,0,0.65);
            z-index:1;
        }

        /* CONTAINER */
        .login-container{
            position:relative;
            z-index:2;
            min-height:calc(100vh - 120px);
            display:flex;
            justify-content:center;
            align-items:center;
            padding:120px 30px 60px;
        }

        /* BOX */
        .login-box{
            width:100%;
            max-width:450px;
            margin:0 auto;
        }

        /* CARD */
        .login-card{
            background:rgba(255,255,255,0.08);
            backdrop-filter:blur(10px);
            border:1px solid rgba(255,255,255,0.15);
            padding:40px;
            border-radius:20px;
            box-shadow:0 10px 30px rgba(0,0,0,0.3);
        }

        .login-logo{
            text-align:center;
            margin-bottom:20px;
        }

        .login-logo img{
            max-width:120px;
        }

        .login-subtitle{
            color:#F28123;
            letter-spacing:5px;
            font-size:14px;
            font-weight:600;
            margin-bottom:10px;
        }

        .login-title{
            color:#fff;
            font-size:42px;
            font-weight:700;
            margin-bottom:10px;
        }

        .login-text{
            color:#ddd;
            font-size:16px;
        }

        .form-label{
            color:#fff;
            margin-bottom:10px;
            font-weight:500;
        }

        .custom-input{
            height:55px;
            border:none;
            border-radius:12px;
            padding:15px;
            background:rgba(255,255,255,0.1);
            color:#fff;
            font-size:15px;
        }

        .custom-input::placeholder{
            color:#ccc;
        }

        .custom-input:focus{
            background:rgba(255,255,255,0.15);
            color:#fff;
            box-shadow:none;
            border:1px solid #F28123;
        }

        .form-check-label{
            color:#ddd;
        }

        .login-btn{
            height:55px;
            border:none;
            border-radius:12px;
            background:#F28123;
            color:#fff;
            font-size:16px;
            font-weight:600;
            transition:0.3s;
        }

        .login-btn:hover{
            background:#051922;
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
                font-size:34px;
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
        <div class="login-box">
            <div class="login-logo">
                <img src="{{ asset('assets/img/logo/logo_artisan.png') }}" alt="Logo">
            </div>
            <div class="text-center mb-4">
                <p class="login-subtitle">FAIT MAIN & AUTHENTIQUE</p>
                <h1 class="login-title">Bon Retour</h1>
                <p class="login-text">Connectez-vous à votre compte</p>
            </div>
            <div class="login-card">
                <form method="POST" action="{{ route('login') }}">
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
                    <div class="mb-3">
                        <label class="form-label">Adresse Email</label>
                        <input class="form-control custom-input" type="email" name="email" placeholder="Entrer votre email" value="{{ old('email') }}" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input class="form-control custom-input" type="password" name="password" placeholder="Entrer votre mot de passe" required />
                    </div>
                    <div class="form-check mb-4">
                        <input id="remember" type="checkbox" class="form-check-input" name="remember">
                        <label class="form-check-label" for="remember">Se souvenir de moi</label>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="login-btn">Se connecter</button>
                    </div>
                </form>
            </div>
            <div class="text-center mt-4">
                <span class="text-light">Vous n'avez pas de compte ?</span>
                <a href="/register" class="register-link">S'inscrire</a>
            </div>
        </div>
    </main>
@endsection


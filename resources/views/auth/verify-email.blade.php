@extends('layouts.public')

@section('title', 'Vérification de l’email')

@section('content')
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card shadow-lg border-0 rounded-3" style="max-width: 580px; width: 100%;">
        <div class="card-body p-4 p-md-5">

            <!-- Logo -->
            <div class="text-center mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/cimburkina_officiel_logo.jpg') }}"
                         alt="Logo officiel CIMBURKINA"
                         class="d-block mx-auto"
                         style="height: 100px;">
                </a>

                <h4 class="mt-3 fw-bold">Vérification de l’email</h4>
                <p class="text-muted small">
                    Merci pour votre inscription ! Avant de commencer, veuillez vérifier votre email en cliquant sur le lien que nous venons de vous envoyer.
                    Si vous n’avez pas reçu l’email, nous pouvons vous en envoyer un autre.
                </p>
            </div>

            <!-- Message de session -->
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success mb-4" role="alert">
                    Un nouveau lien de vérification a été envoyé à l’adresse email que vous avez fournie lors de l’inscription.
                </div>
            @endif

            <!-- Formulaires -->
            <div class="d-grid gap-2 mb-3">
                <!-- Renvoyer le lien -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        Renvoyer le lien de vérification
                    </button>
                </form>

                <!-- Déconnexion -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-lg w-100">
                        Se déconnecter
                    </button>
                </form>
            </div>

            <!-- Lien accueil -->
            <div class="text-center">
                <a href="{{ url('/') }}" class="text-muted small">
                    ← Retour à l'accueil
                </a>
            </div>

        </div>
    </div>
</div>
@endsection

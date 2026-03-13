@extends('layouts.public')

@section('title', 'Réinitialisation du mot de passe')

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

                <h4 class="mt-3 fw-bold">Réinitialisation du mot de passe</h4>
                <p class="text-muted small">
                    Entrez votre email pour recevoir un lien de réinitialisation
                </p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="alert alert-success mb-4" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Formulaire -->
            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email:</label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="form-control border-success @error('email') is-invalid @enderror"
                           placeholder="exemple@email.com"
                           value="{{ old('email') }}"
                           required
                           autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success btn-lg">
                        Envoyer le lien de réinitialisation
                    </button>
                </div>

                <!-- Liens -->
                <div class="text-center">
                    <p class="mb-1">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            ← Retour à la connexion
                        </a>
                    </p>
                    <p class="mb-0">
                        <a href="{{ url('/') }}" class="text-muted small">
                            ← Retour à l’accueil
                        </a>
                    </p>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.public')

@section('title', 'Connexion')

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

                <h4 class="mt-3 fw-bold">Se connecter</h4>
                <p class="text-muted small">
                    Accédez à votre compte sur la plateforme CIMBURKINA
                </p>
            </div>

            <!-- Formulaire -->
            <form method="POST" action="{{ route('login') }}">
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

                <!-- Mot de passe -->
                <div class="mb-3">
                    <label for="password" class="form-label">Mot de passe:</label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-control border-success @error('password') is-invalid @enderror"
                           placeholder="Votre mot de passe"
                           required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Se souvenir de moi</label>
                </div>

                <!-- Bouton -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success btn-lg">
                        Se connecter
                    </button>
                </div>

                <!-- Liens -->
                <div class="text-center">
                    @if (Route::has('password.request'))
                        <p class="mb-1">
                            <a href="{{ route('password.request') }}" class="text-decoration-none">
                                Mot de passe oublié ?
                            </a>
                        </p>
                    @endif
                    <p class="mb-1">
                        <a href="{{ route('register') }}" class="text-decoration-none">
                            Pas encore inscrit ? Créer un compte
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

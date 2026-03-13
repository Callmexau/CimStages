@extends('layouts.public')

@section('title', 'Confirmer le mot de passe')

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

                <h4 class="mt-3 fw-bold">Confirmer votre mot de passe</h4>
                <p class="text-muted small">
                    Cette zone est sécurisée. Veuillez confirmer votre mot de passe avant de continuer.
                </p>
            </div>

            <!-- Formulaire -->
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Mot de passe -->
                <div class="mb-4">
                    <label for="password" class="form-label">Mot de passe :</label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-control border-success @error('password') is-invalid @enderror"
                           placeholder="••••••••"
                           required
                           autocomplete="current-password"
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Bouton -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        Confirmer
                    </button>
                </div>

                <!-- Lien accueil -->
                <div class="text-center">
                    <a href="{{ url('/') }}" class="text-muted small">
                        ← Retour à l’accueil
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

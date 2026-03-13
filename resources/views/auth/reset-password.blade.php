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

                <h4 class="mt-3 fw-bold">Réinitialiser le mot de passe</h4>
                <p class="text-muted small">
                    Entrez votre email et votre nouveau mot de passe pour réinitialiser votre compte.
                </p>
            </div>

            <!-- Formulaire -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Token de réinitialisation -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email :</label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="form-control border-success @error('email') is-invalid @enderror"
                           placeholder="exemple@email.com"
                           value="{{ old('email', $request->email) }}"
                           required
                           autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe :</label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="form-control border-success @error('password') is-invalid @enderror"
                           placeholder="••••••••"
                           required
                    >
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmation -->
                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe :</label>
                    <input type="password"
                           id="password_confirmation"
                           name="password_confirmation"
                           class="form-control border-success"
                           placeholder="••••••••"
                           required
                    >
                </div>

                <!-- Bouton -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success btn-lg w-100">
                        Réinitialiser le mot de passe
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

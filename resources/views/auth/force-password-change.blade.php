@extends('layouts.public')

@section('title', 'Nouveau mot de passe')

@section('content')
<div class="container min-vh-100 d-flex align-items-center justify-content-center">
    <div class="card shadow-lg border-0 rounded-3" style="max-width: 580px; width: 100%;">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/cimburkina_officiel_logo.jpg') }}" 
                         alt="Logo officiel CIMBURKINA" 
                         class="d-block mx-auto" 
                         style="height: 100px;">
                </a>

                <h4 class="mt-3 fw-bold text-dark">Réinitialisation</h4>
                <p class="text-muted small">
                    Veuillez définir votre nouveau mot de passe sécurisé.
                </p>
            </div>

            <div class="alert alert-warning border-0 bg-warning bg-opacity-10 d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-shield-lock me-2 fs-5 text-warning"></i>
                <div class="small text-dark">
                    Cette action est nécessaire pour la sécurité de votre compte CIMBURKINA.
                </div>
            </div>

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <div class="mb-3">
                    <label for="password" class="form-label">Nouveau mot de passe :</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-success text-success"><i class="bi bi-lock"></i></span>
                        <input type="password" 
                                id="password" 
                                name="password" 
                                class="form-control border-success @error('password') is-invalid @enderror" 
                                placeholder="Votre mot de passe"
                                required 
                                autofocus>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="form-label">Confirmer le mot de passe :</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-success text-success"><i class="bi bi-shield-check"></i></span>
                        <input type="password" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               class="form-control border-success" 
                               placeholder="Confirmer votre mot de passe"
                               required>
                    </div>
                </div>

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-success btn-lg fw-bold">
                        Enregistrer le nouveau mot de passe
                    </button>
                </div>

                <div class="text-center">
                    <p class="mb-0">
                        <a href="{{ url('/') }}" class="text-muted small text-decoration-none">
                            <i class="bi bi-arrow-left me-1"></i> Retour à l'accueil
                        </a>
                    </p>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.public') 

@section('title', 'Inscription')

@section('content')
<div class="container min-vh-100 d-flex align-items-center justify-content-center py-4">
    <div class="card shadow-lg border-0 rounded-4" style="max-width: 650px; width: 100%;">
        <div class="card-body p-4 p-md-5">

            <div class="text-center mb-4">
                <a href="{{ url('/') }}">
                    <img src="{{ asset('images/cimburkina_officiel_logo.jpg') }}"
                         alt="Logo officiel"
                         class="d-block mx-auto mb-2"
                         style="height: 70px;"> </a>
                <h4 class="fw-bold mb-1">Créer un compte</h4>
                <p class="text-muted small">Plateforme officielle de gestion des stages</p>
            </div>

            <form method="POST" action="{{ route('register.store') }}">
                @csrf
                <style>
                    .form-control { border: 2px solid #1a5a45; border-radius: 0.5rem; padding: 0.5rem 0.75rem; }
                    .form-control:focus { border-color: #009E49; box-shadow: 0 0 0 0.2rem rgba(0,158,73,0.25); }
                    .btn-primary { background-color: #1a5a45; border-color: #1a5a45; }
                    .btn-primary:hover { background-color: #009E49; border-color: #009E49; }
                    label { font-size: 0.85rem; font-weight: 600; margin-bottom: 0.25rem; }
                </style>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="nom" class="form-label">Nom :</label>
                        <input type="text" id="nom" name="nom" class="form-control @error('nom') is-invalid @enderror" placeholder="Ouedraogo" value="{{ old('nom') }}" required>
                        @error('nom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="prenom" class="form-label">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" class="form-control @error('prenom') is-invalid @enderror" placeholder="Josée" value="{{ old('prenom') }}" required>
                        @error('prenom') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-5">
                        <label for="sexe" class="form-label">Genre :</label>
                        <select id="sexe" name="sexe" class="form-control @error('sexe') is-invalid @enderror" required>
                            <option value="" disabled selected>— Sélectionner —</option>
                            <option value="Masculin" {{ old('sexe') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                            <option value="Féminin" {{ old('sexe') == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                        </select>
                    </div>
                    <div class="col-md-7">
                        <label for="date_naissance" class="form-label">Date de naissance :</label>
                        <input type="date" id="date_naissance" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror" value="{{ old('date_naissance') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Adresse email :</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="exemple@email.com" value="{{ old('email') }}" required>
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <label for="password" class="form-label">Mot de passe :</label>
                        <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Votre mot de passe" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="form-label">Confirmation :</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" placeholder="Confirmez votre mot de passe" required>
                    </div>
                </div>

                <div class="d-grid gap-2 text-center">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">Créer mon compte</button>
                    <div class="mt-2">
                        <a href="{{ route('login') }}" class="text-decoration-none small fw-bold">Déjà inscrit ? Se connecter</a>
                    </div>
                    <a href="{{ url('/') }}" class="text-muted extra-small" style="font-size: 0.75rem;">← Retour à l'accueil</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
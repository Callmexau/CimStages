@extends('layouts.adminlte')

@section('content_header')
    <div class="container-fluid pt-4">
        <div class="row mb-4 align-items-end">
            <div class="col-sm-6">
                <h1 class="m-0 font-weight-bold text-dark" style="letter-spacing: -1px; font-size: 1.8rem;">
                    Gestion des Stagiaires
                </h1>
                <p class="text-muted small mb-0">Pilotez le cycle de vie de vos talents au sein de la structure.</p>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent p-0 small">
                    <li class="breadcrumb-item"><a href="#" class="text-muted">Espace Responsable</a></li>
                    <li class="breadcrumb-item active text-dark">Stagiaires</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- CARTE : EN COURS --}}
        <div class="col-lg-6 mb-4">
            <div class="card h-100 border-0 shadow-sm custom-hover-card" style="border-radius: 12px; transition: transform 0.3s ease;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="icon-shape shadow-sm text-white" style="background: linear-gradient(135deg, #1a2a6c, #2a4858); width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-user-graduate fa-lg"></i>
                        </div>
                        <span class="badge badge-pill badge-light border px-3 py-2 text-muted uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Actifs</span>
                    </div>
                    <h3 class="font-weight-bold mb-2">Stagiaires en cours</h3>
                    <p class="text-muted mb-4">Supervisez les missions actuelles, validez les étapes clés et suivez l'évolution des stagiaires en poste.</p>
                    <a href="{{ route('responsable.stagiaires.enCours') }}" class="btn btn-dark btn-block shadow-sm" style="background-color: #1a2a6c; border: none; border-radius: 8px; padding: 12px;">
                        Ouvrir le suivi <i class="fas fa-chevron-right ml-2" style="font-size: 0.8rem;"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- CARTE : TERMINÉS --}}
        <div class="col-lg-6 mb-4">
            <div class="card h-100 border-0 shadow-sm custom-hover-card" style="border-radius: 12px; transition: transform 0.3s ease;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start justify-content-between mb-4">
                        <div class="icon-shape shadow-sm text-white" style="background: linear-gradient(135deg, #1a5a45, #2d7a5f); width: 50px; height: 50px; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-archive fa-lg"></i>
                        </div>
                        <span class="badge badge-pill badge-light border px-3 py-2 text-muted uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Archives</span>
                    </div>
                    <h3 class="font-weight-bold mb-2">Historique des stagiaires</h3>
                    <p class="text-muted mb-4">Consultez l'historique des dossiers clôturés et gérez les évaluations finales.</p>
                    <a href="{{ route('responsable.stagiaires.termines') }}" class="btn btn-dark btn-block shadow-sm" style="background-color: #1a5a45; border: none; border-radius: 8px; padding: 12px;">
                        Consulter l'historique <i class="fas fa-chevron-right ml-2" style="font-size: 0.8rem;"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
    .custom-hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
    }
    .icon-shape i {
        filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
    }
    .uppercase {
        text-transform: uppercase;
    }
    body {
        background-color: #f4f6f9;
    }
</style>
@endsection
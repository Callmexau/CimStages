@extends('layouts.adminlte')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 fw-bold">Gestion des Stagiaires</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Accueil</a></li>
                    <li class="breadcrumb-item active">Stagiaires</li>
                </ol>
            </div>
        </div>
    </div>
@endsection

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 col-6">
            <div class="small-box bg-primary shadow-sm">
                <div class="inner">
                    <h3>En cours</h3>
                    <p>Suivi des stagiaires actifs</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <a href="{{ route('responsable.stagiaires.enCours') }}" class="small-box-footer">
                    Accéder à la liste <i class="fas fa-arrow-circle-right ms-1"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-6 col-6">
            <div class="small-box bg-success shadow-sm">
                <div class="inner">
                    <h3>Terminés</h3>
                    <p>Archives et attestations</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-double"></i>
                </div>
                <a href="{{ route('responsable.stagiaires.termines') }}" class="small-box-footer">
                    Consulter l'historique <i class="fas fa-arrow-circle-right ms-1"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 text-muted">
            <p class="small">
                <i class="fas fa-info-circle me-1"></i> 
                Sélectionnez une catégorie pour gérer les dossiers.
            </p>
        </div>
    </div>
</div>
@endsection
@extends('layouts.adminlte')

@section('title', 'Détails de ma demande')

@section('content')
<div class="container-fluid pt-5">
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-11">
            
            <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                {{-- En-tête Stylisé --}}
                <div class="card-header bg-dark p-4 position-relative" style="background: linear-gradient(135deg, #17a2b8 0%, #0056b3 100%);">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-white">
                            <h3 class="font-weight-bold mb-1">Récapitulatif du Dossier</h3>
                            <p class="mb-0 opacity-75 small"><i class="far fa-clock mr-1"></i> Soumis le {{ $demande->created_at->format('d/m/Y à H:i') }}</p>
                        </div>
                        <div class="text-right">
                            <span class="badge badge-light p-2 shadow-sm text-info px-3" style="border-radius: 10px;">
                                ID: #ST-{{ str_pad($demande->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="row no-gutters">
                        
                        {{-- Colonne Gauche : État de progression --}}
                        <div class="col-md-4 bg-light p-4 border-right">
                            <h5 class="font-weight-bold mb-4">Suivi du traitement</h5>
                            
                            <div class="vertical-timeline">
                                <div class="timeline-step active">
                                    <div class="icon bg-success"><i class="fas fa-check"></i></div>
                                    <div class="text">
                                        <p class="mb-0 font-weight-bold">Dépôt du dossier</p>
                                        <small class="text-muted">Terminé</small>
                                    </div>
                                </div>
                                <div class="timeline-step @if($demande->statut != 'En attente') active @endif">
                                    <div class="icon @if($demande->statut == 'En attente') bg-warning @else bg-success @endif">
                                        <i class="fas @if($demande->statut == 'En attente') fa-spinner fa-spin @else fa-check @endif"></i>
                                    </div>
                                    <div class="text">
                                        <p class="mb-0 font-weight-bold">Examen technique</p>
                                        <small class="text-muted">{{ $demande->statut }}</small>
                                    </div>
                                </div>
                                <div class="timeline-step">
                                    <div class="icon bg-secondary"><i class="fas fa-flag-checkered"></i></div>
                                    <div class="text">
                                        <p class="mb-0 font-weight-bold">Décision finale</p>
                                        <small class="text-muted">En attente</small>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">
                            
                            <h6 class="font-weight-bold small text-uppercase text-muted mb-3">Documents joints</h6>
                            <div class="d-grid gap-2">
                                <a href="{{ asset('storage/'.$demande->cv_path) }}" class="btn btn-white btn-sm border btn-block text-left mb-2 shadow-sm hover-info">
                                    <i class="fas fa-file-pdf text-danger mr-2"></i> Mon Curriculum Vitae
                                </a>
                                <a href="{{ asset('storage/'.$demande->cnib_path) }}" class="btn btn-white btn-sm border btn-block text-left shadow-sm hover-info">
                                    <i class="fas fa-id-card text-primary mr-2"></i> Pièce d'Identité
                                </a>
                            </div>
                        </div>

                        {{-- Colonne Droite : Informations détaillées --}}
                        <div class="col-md-8 p-4 p-lg-5 bg-white">
                            <h5 class="font-weight-bold mb-4">Informations Candidat</h5>
                            
                            <div class="row mb-4">
                                <div class="col-sm-6 mb-3">
                                    <label class="text-muted small text-uppercase font-weight-bold mb-1 d-block">Niveau & Filière</label>
                                    <p class="h6 font-weight-bold">{{ $demande->niveau_etude }} - {{ $demande->filiere }}</p>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="text-muted small text-uppercase font-weight-bold mb-1 d-block">Établissement</label>
                                    <p class="h6 font-weight-bold">{{ $demande->universite }}</p>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-sm-6 mb-3">
                                    <label class="text-muted small text-uppercase font-weight-bold mb-1 d-block">Structure Ciblée</label>
                                    <p class="h6 text-info font-weight-bold"><i class="fas fa-building mr-1"></i> {{ $demande->structure?->name ?? 'Non définie' }}</p>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="text-muted small text-uppercase font-weight-bold mb-1 d-block">Contact Téléphonique</label>
                                    <p class="h6 font-weight-bold">{{ $demande->telephone }}</p>
                                </div>
                            </div>

                            <div class="p-3 bg-light rounded-lg border border-dashed">
                                <label class="text-muted small text-uppercase font-weight-bold mb-1 d-block">Expérience Professionnelle</label>
                                <p class="mb-0 italic">{{ $demande->experience_professionnelle ?? 'Aucune expérience préalable mentionnée.' }}</p>
                            </div>

                            <div class="mt-5 text-right">
                                <a href="{{ route('stagiaire.dashboard') }}" class="btn btn-outline-secondary rounded-pill px-4 mr-2">
                                    Tableau de bord
                                </a>
                                <button onclick="window.print();" class="btn btn-info rounded-pill px-4 shadow-sm">
                                    <i class="fas fa-print mr-1"></i> Imprimer
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Timeline Verticale Custom */
    .vertical-timeline { position: relative; padding-left: 45px; }
    .vertical-timeline::before {
        content: ''; position: absolute; left: 17px; top: 0; height: 100%; width: 2px;
        background: #e9ecef;
    }
    .timeline-step { position: relative; margin-bottom: 30px; }
    .timeline-step .icon {
        position: absolute; left: -45px; width: 35px; height: 35px;
        border-radius: 50%; display: flex; align-items: center; justify-content: center;
        color: white; font-size: 12px; border: 4px solid white; z-index: 1;
    }
    .timeline-step.active .text p { color: #17a2b8; }
    
    /* Effets et Utils */
    .opacity-75 { opacity: 0.75; }
    .hover-info:hover {
        border-color: #17a2b8 !important;
        background: #f8fdff !important;
        transform: translateX(5px);
        transition: all 0.3s;
    }
    .border-dashed { border-style: dashed !important; border-width: 2px !important; }
    .rounded-lg { border-radius: 12px !important; }
</style>
@endsection
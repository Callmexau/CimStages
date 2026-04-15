@extends('layouts.adminlte')

@section('content')

<div class="container-fluid py-2">

    @if(session('success'))
    <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger alert-sm">{{ session('error') }}</div>
    @endif

    {{-- NAVIGATION --}}
    <div class="mb-2 d-flex align-items-center justify-content-between">
        <a href="{{ url()->previous() }}" class="back-link small">
            <i class="fas fa-arrow-left mr-1"></i> Retour
        </a>
        <span class="badge badge-light border text-muted">
            Dossier #{{ str_pad($demande->id, 5, '0', STR_PAD_LEFT) }}
        </span>
    </div>

    {{-- CARTE --}}
    <div class="card shadow-sm border-0 mb-0" style="border-radius: 8px;">
        <div class="row no-gutters">
            
            {{-- SIDEBAR --}}
            <div class="col-md-3 border-right bg-light-side">
                <div class="card-body text-center p-3">
                    <div class="avatar-mini mb-2">
                        {{ strtoupper(substr($demande->stagiaire->prenom ?? 'S', 0, 1)) }}
                    </div>

                    <h6 class="font-weight-bold mb-0">
                        {{ $demande->stagiaire->prenom }} {{ strtoupper($demande->stagiaire->nom) }}
                    </h6>

                    <div class="status-badge {{ $demande->statut }} my-2">
                        {{ ucfirst($demande->statut) }}
                    </div>

                    <div class="text-left mt-3 small">
                        <div class="info-row">
                            <i class="far fa-envelope text-muted"></i>
                            <span>{{ $demande->stagiaire->email ?? '-' }}</span>
                        </div>

                        <div class="info-row">
                            <i class="fas fa-phone text-muted"></i>
                            <span>{{ $demande->telephone ?? '-' }}</span>
                        </div>

                        <div class="info-row">
                            <i class="fas fa-venus-mars text-muted"></i>
                            <span>{{ $demande->stagiaire->sexe ?? '-' }}</span>
                        </div>

                        <div class="info-row">
                            <i class="far fa-calendar-alt text-muted"></i>
                            <span>{{ $demande->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- CONTENU --}}
            <div class="col-md-9 bg-white">
                <div class="card-body p-3">
                    
                    {{-- SECTION ACADÉMIQUE --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="text-uppercase text-muted font-weight-bold mb-2"
                               style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                <i class="fas fa-graduation-cap mr-1"></i> Parcours Académique
                            </p>
                        </div>

                        <div class="col-md-3">
                            <div class="mini-data">
                                <label>Filière</label>
                                <span>{{ $demande->filiere ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mini-data">
                                <label>Niveau</label>
                                <span>{{ $demande->niveau_etude ?? '-' }}</span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mini-data">
                                <label>Type de stage</label>
                                <span>
                                    @if($demande->type_stage == 'soutenance')
                                        🎓 Soutenance
                                    @else
                                        💼 Perfectionnement
                                    @endif
                                </span>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="mini-data border-left-emerald pl-2">
                                <label>Établissement</label>
                                <span class="text-emerald font-weight-bold">
                                    {{ $demande->universite ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    {{-- DOCUMENTS --}}
                    <div class="row mb-3">
                        <div class="col-12">
                            <p class="text-uppercase text-muted font-weight-bold mb-2"
                               style="font-size: 0.65rem; letter-spacing: 0.5px;">
                                <i class="fas fa-paperclip mr-1"></i> Documents
                            </p>
                        </div>

                        <div class="col-12 d-flex flex-row">
                            @if($demande->cv_path)
                            <a href="{{ asset('storage/'.$demande->cv_path) }}" target="_blank" class="doc-pill mr-2">
                                <i class="far fa-file-pdf mr-2"></i> CV
                            </a>
                            @endif

                            @if($demande->cnib_path)
                            <a href="{{ asset('storage/'.$demande->cnib_path) }}" target="_blank" class="doc-pill">
                                <i class="far fa-id-card mr-2"></i> ID
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- ACTIONS --}}
                <div class="card-footer bg-white border-top p-2 px-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="text-muted small italic" style="font-size: 0.7rem;">
                            En attente de traitement
                        </span>

                        <div class="d-flex">
                            <form action="{{ route('responsable.demande.rejeter', $demande->id) }}" method="POST" class="mr-2">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger px-3">
                                    Rejeter
                                </button>
                            </form>

                            <form action="{{ route('responsable.demande.valider', $demande->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success px-3"
                                        style="background-color: #1a5a45;">
                                    Valider
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- STYLE --}}
<style>
.bg-light-side { background-color: #f8f9fa; }
.text-emerald { color: #1a5a45; }

.avatar-mini {
    width: 50px; height: 50px;
    background: #1a5a45;
    color: white;
    font-size: 20px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

.status-badge {
    display: inline-block;
    padding: 2px 10px;
    border-radius: 20px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    background: #e9ecef;
}
.status-badge.en_attente {
    background: #fff3cd;
    color: #856404;
}

.info-row {
    display: flex;
    align-items: center;
    margin-bottom: 6px;
    gap: 8px;
    color: #555;
}
.info-row i { width: 14px; font-size: 11px; }

.mini-data label {
    display: block;
    font-size: 10px;
    color: #aaa;
    text-transform: uppercase;
    font-weight: 700;
}
.mini-data span {
    font-size: 13px;
    font-weight: 600;
}

.border-left-emerald {
    border-left: 3px solid #1a5a45;
}

.doc-pill {
    display: flex;
    align-items: center;
    padding: 5px 15px;
    background: #f1f3f5;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
    border: 1px solid #dee2e6;
}
.doc-pill:hover {
    background: #e9ecef;
}

.back-link {
    color: #888;
    text-decoration: none;
}
.back-link:hover { color: #333; }
</style>

@endsection
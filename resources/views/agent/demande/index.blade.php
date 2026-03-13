@extends('layouts.adminlte')

@push('css')
<style>
    /* Carte style Jackson */
    .card-demande {
        transition: all 0.2s ease-in-out;
        border-radius: 12px;
        border: 1px solid rgba(0,0,0,.05);
    }
    .card-demande:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.08) !important;
    }
    .avatar-circle {
        width: 48px; height: 48px;
        background: linear-gradient(135deg, #17a2b8 0%, #007bff 100%);
        color: white;
        display: flex; align-items: center; justify-content: center;
        border-radius: 50%; font-weight: 700; font-size: 1.2rem;
    }
    .status-badge {
        font-size: 10px; font-weight: 800;
        padding: 5px 12px; border-radius: 50px;
        letter-spacing: 0.8px;
    }
    /* Ajout pour le sexe */
    .gender-icon {
        font-size: 0.8rem;
        margin-left: 5px;
    }
    .text-female { color: #e83e8c; } /* Rose discret */
    .text-male { color: #007bff; }   /* Bleu discret */
    
    .document-link {
        transition: all 0.2s;
        border-radius: 8px;
    }
    .document-link:hover { background-color: #f1f3f5; }
    .search-wrapper { border-radius: 15px; border: none; }
</style>
@endpush

@section('content')
<div class="container-fluid pt-3">

    {{-- Filtre Compact --}}
    <div class="search-wrapper bg-white shadow-sm p-3 mb-4">
        <form action="{{ route('agent.demande.index') }}" method="GET">
            <div class="row g-2 align-items-center">
                <div class="col-md-9">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-search"></i></span>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="form-control border-0 bg-light" placeholder="Chercher un candidat, une école...">
                    </div>
                </div>
                <div class="col-md-3 text-right">
                    <button type="submit" class="btn btn-dark px-4 rounded-pill">Filtrer</button>
                    @if(request('search'))
                        <a href="{{ route('agent.demande.index') }}" class="btn btn-link text-muted btn-sm">Annuler</a>
                    @endif
                </div>
            </div>
        </form>
    </div>

    {{-- Grille --}}
    <div class="row">
        @forelse($demandes as $demande)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card card-demande h-100 bg-white shadow-sm">
                    
                    <div class="card-header bg-white border-0 pt-4 d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="avatar-circle mr-3 shadow-sm">
                                {{ strtoupper(substr($demande->stagiaire->prenom ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="mb-0 font-weight-bold text-dark d-flex align-items-center">
                                    {{ $demande->stagiaire->prenom }} {{ strtoupper($demande->stagiaire->nom) }}
                                    {{-- Affichage du sexe par icône --}}
                                    @if(strtolower($demande->stagiaire->sexe) == 'feminin' || strtolower($demande->stagiaire->sexe) == 'f')
                                        <i class="fas fa-venus gender-icon text-female" title="Féminin"></i>
                                    @else
                                        <i class="fas fa-mars gender-icon text-male" title="Masculin"></i>
                                    @endif
                                </h6>
                                <small class="text-muted"><i class="fas fa-university mr-1"></i> {{ Str::limit($demande->universite, 25) }}</small>
                            </div>
                        </div>
                        @php
                            $status = [
                                'en_attente' => ['c' => 'badge-warning', 't' => 'ATTENTE'],
                                'validee'    => ['c' => 'badge-success', 't' => 'VALIDÉE'],
                                'rejetee'    => ['c' => 'badge-danger', 't' => 'REFUSÉE'],
                                'transferée' => ['c' => 'badge-info', 't' => 'EN COURS'],
                            ][$demande->statut] ?? ['c' => 'badge-secondary', 't' => $demande->statut];
                        @endphp
                        <span class="status-badge badge {{ $status['c'] }}">{{ $status['t'] }}</span>
                    </div>

                    <div class="card-body py-2">
                        {{-- Bloc Info Compact avec Sexe en texte si nécessaire --}}
                        <div class="bg-light p-3 rounded-lg mb-3">
                            <div class="row text-center">
                                <div class="col-4 border-right">
                                    <small class="text-muted d-block text-uppercase" style="font-size: 8px;">Sexe</small>
                                    <span class="font-weight-bold small">{{ strtoupper(substr($demande->stagiaire->sexe, 0, 1)) }}</span>
                                </div>
                                <div class="col-4 border-right">
                                    <small class="text-muted d-block text-uppercase" style="font-size: 8px;">Niveau</small>
                                    <span class="font-weight-bold small">{{ $demande->niveau_etude }}</span>
                                </div>
                                <div class="col-4">
                                    <small class="text-muted d-block text-uppercase" style="font-size: 8px;">Dépôt</small>
                                    <span class="font-weight-bold small">{{ $demande->created_at->format('d/m/y') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted font-weight-bold">Filière :</small>
                            <p class="mb-1 text-dark small font-weight-bold">{{ $demande->filiere }}</p>
                        </div>

                        {{-- Documents --}}
                        <div class="d-flex gap-2 mb-3">
                            @if($demande->cv_path)
                                <a href="{{ asset('storage/'.$demande->cv_path) }}" target="_blank" class="btn btn-sm btn-outline-primary document-link flex-fill">
                                    <i class="fas fa-file-pdf mr-1"></i> Consulter CV
                                </a>
                            @endif
                            @if($demande->cnib_path)
                                <a href="{{ asset('storage/'.$demande->cnib_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary document-link px-3" title="CNIB">
                                    <i class="fas fa-id-card"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer bg-white border-top-0 pt-0 pb-4">
                        @if($demande->statut === 'en_attente')
                            <form action="{{ route('agent.demande.transfer', $demande) }}" method="POST" class="transfer-form">
                                @csrf
                                <div class="input-group input-group-sm">
                                    <select name="responsable_id" class="form-control custom-select border-info" required>
                                        <option value="" disabled selected>Transférer vers...</option>
                                        @foreach($responsables as $resp)
                                            <option value="{{ $resp->id }}">{{ $resp->name }} ({{ $resp->structure->name ?? '...' }})</option>
                                        @endforeach
                                    </select>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-info" title="Envoyer">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-2 border rounded bg-light">
                                <small class="text-muted font-italic"><i class="fas fa-history mr-1"></i> Dossier déjà orienté</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5 text-center">
                <i class="fas fa-inbox fa-3x text-light mb-3"></i>
                <h5 class="text-muted">Aucune demande ne correspond</h5>
            </div>
        @endforelse
    </div>
</div>
@endsection
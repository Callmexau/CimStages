@extends('layouts.adminlte')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Détail de la demande</h2>
            <p class="text-muted mb-0">
                <i class="fas fa-folder-open me-1"></i> Consultation du dossier du stagiaire
            </p>
        </div>

        <div class="mt-3 mt-md-0">
            <a href="{{ route('agent.archives.index') }}" class="btn btn-outline-secondary rounded-pill">
                <i class="fas fa-arrow-left me-1"></i> Retour aux archives
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4">
            <h5 class="mb-0 fw-bold text-primary">
                {{ $demande->stagiaire->prenom ?? '' }} {{ strtoupper($demande->stagiaire->nom ?? '') }}
            </h5>
        </div>

        <div class="card-body p-4">
            <div class="row g-4">

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-4 h-100">
                        <h6 class="fw-bold mb-3 text-dark">Informations personnelles</h6>

                        <p class="mb-2">
                            <strong>Nom complet :</strong>
                            {{ $demande->stagiaire->prenom ?? 'Non renseigné' }}
                            {{ strtoupper($demande->stagiaire->nom ?? '') }}
                        </p>

                        <p class="mb-2">
                            <strong>Email :</strong>
                            {{ $demande->stagiaire->email ?? 'Non renseigné' }}
                        </p>

                        <p class="mb-2">
                            <strong>Téléphone :</strong>
                            {{ $demande->telephone ?? 'Non renseigné' }}
                        </p>

                        <p class="mb-2">
                            <strong>Université :</strong>
                            {{ $demande->universite ?? 'Non renseignée' }}
                        </p>

                        <p class="mb-0">
                            <strong>Filière :</strong>
                            {{ $demande->filiere ?? 'Non renseignée' }}
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-4 h-100">
                        <h6 class="fw-bold mb-3 text-dark">Informations académiques et stage</h6>

                        <p class="mb-2">
                            <strong>Niveau d’étude :</strong>
                            {{ $demande->niveau_etude ?? 'Non renseigné' }}
                        </p>

                        <p class="mb-2">
                            <strong>Type de stage :</strong>
                            <span class="badge bg-info text-dark rounded-pill px-3 py-2">
                                {{ ucfirst($demande->type_stage ?? 'Non renseigné') }}
                            </span>
                        </p>

                        <p class="mb-2">
                            <strong>Structure :</strong>
                            {{ $demande->structure->name ?? 'Non définie' }}
                        </p>

                        <p class="mb-2">
                            <strong>Statut :</strong>
                            <span class="badge bg-success rounded-pill px-3 py-2">
                                {{ ucfirst($demande->statut) }}
                            </span>
                        </p>

                        <p class="mb-2">
                            <strong>Date début :</strong>
                            {{ $demande->debut_stage ? \Carbon\Carbon::parse($demande->debut_stage)->format('d/m/Y') : 'Non définie' }}
                        </p>

                        <p class="mb-0">
                            <strong>Date fin :</strong>
                            {{ $demande->fin_stage ? \Carbon\Carbon::parse($demande->fin_stage)->format('d/m/Y') : 'Non définie' }}
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="p-3 border rounded-4 h-100">
                        <h6 class="fw-bold mb-3 text-dark">Pièces jointes</h6>

                        <div class="d-flex flex-wrap gap-2">
                            @if($demande->cv_path)
                                <a href="{{ asset('storage/' . $demande->cv_path) }}" target="_blank" class="btn btn-outline-primary rounded-pill">
                                    <i class="fas fa-file-pdf me-1"></i> Voir le CV
                                </a>
                            @endif

                            @if($demande->cnib_path)
                                <a href="{{ asset('storage/' . $demande->cnib_path) }}" target="_blank" class="btn btn-outline-dark rounded-pill">
                                    <i class="fas fa-id-card me-1"></i> Voir la CNIB
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                @if($demande->evaluation)
                <div class="col-md-6">
                    <div class="p-3 border rounded-4 h-100">
                        <h6 class="fw-bold mb-3 text-dark">Évaluation finale</h6>

                        <p class="mb-2">
                            <strong>Note finale :</strong>
                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                {{ $demande->evaluation->note_finale ?? 'Non notée' }}/20
                            </span>
                        </p>

                        <p class="mb-2">
                            <strong>Recommandation :</strong>
                            {{ $demande->evaluation->recommandation ?? 'Non renseignée' }}
                        </p>

                        <p class="mb-0">
                            <strong>Commentaire :</strong>
                            {{ $demande->evaluation->commentaires ?? 'Aucun commentaire' }}
                        </p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

</div>
@endsection
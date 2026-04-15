@extends('layouts.adminlte')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-body p-4 p-lg-5 bg-white">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">
                <div>
                    <div class="d-inline-flex align-items-center px-3 py-2 rounded-pill bg-primary-subtle text-primary fw-bold small mb-3">
                        <i class="fas fa-user-check me-2"></i> Gestion des stagiaires terminés
                    </div>
                    <h2 class="fw-bold text-dark mb-1">Stagiaires terminés</h2>
                    <p class="text-muted mb-0">
                        Consultez les stages terminés, évaluez les stagiaires en attente et lancez un renouvellement si nécessaire.
                    </p>
                </div>

                <div class="d-flex flex-wrap gap-3">
                    <div class="mini-stat-card">
                        <span class="mini-stat-label">Total</span>
                        <span class="mini-stat-value">{{ $stagiairesTermines->count() }}</span>
                    </div>
                    <div class="mini-stat-card warning">
                        <span class="mini-stat-label">À évaluer</span>
                        <span class="mini-stat-value">{{ $stagiairesTermines->where('evaluation', null)->count() }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($stagiairesTermines->isEmpty())
        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body text-center py-5">
                <div class="empty-icon mb-3">
                    <i class="fas fa-folder-open"></i>
                </div>
                <h5 class="fw-bold text-dark">Aucun stagiaire terminé</h5>
                <p class="text-muted mb-0">Aucun stage terminé n’est disponible pour le moment.</p>
            </div>
        </div>
    @else

        @php
            $stagiairesTries = $stagiairesTermines->sortBy(function ($demande) {
                return $demande->evaluation ? 1 : 0;
            });
        @endphp

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-0 p-4 pb-0">
                <div>
                    <h5 class="fw-bold mb-1 text-dark">Liste des stagiaires</h5>
                    <p class="text-muted small mb-0">
                        Les stagiaires non évalués sont affichés en priorité.
                    </p>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table modern-table align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4">#</th>
                                <th>Stagiaire</th>
                                <th>Email</th>
                                <th>État</th>
                                <th>Renouvellement</th>
                                <th class="text-center pe-4">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($stagiairesTries as $demande)
                                @php
                                    $stagiaire = $demande->stagiaire;
                                    $estEvalue = !is_null($demande->evaluation);
                                    $renouvellements = $demande->renouvellement_count ?? 0;
                                    $peutRenouveler = !$estEvalue && $renouvellements < 2;
                                @endphp

                                <tr class="{{ !$estEvalue ? 'row-highlight' : '' }}">
                                    <td class="ps-4 fw-semibold text-muted">{{ $loop->iteration }}</td>

                                    <td>
                                        <div class="d-flex align-items-center gap-3">

                                            <div>
                                                <div class="fw-bold text-dark">
                                                    {{ $stagiaire->prenom }} {{ strtoupper($stagiaire->nom) }}
                                                </div>

                                                @if(!$estEvalue)
                                                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-2 mt-1">
                                                        <i class="fas fa-clock me-1"></i> À évaluer
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <span class="text-muted fw-medium">{{ $stagiaire->email }}</span>
                                    </td>

                                    <td>
                                        @if($estEvalue)
                                            <span class="status-pill success">
                                                <i class="fas fa-check-circle me-1"></i> Évalué
                                            </span>
                                        @else
                                            <span class="status-pill warning">
                                                <i class="fas fa-hourglass-half me-1"></i> En attente
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="d-flex flex-column gap-2">

                                            @if(!$estEvalue)
                                                @if($peutRenouveler)
                                                    <a href="{{ route('responsable.besoins.create', ['demande' => $demande->id, 'renouvellement' => 1]) }}"
                                                        class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                            <i class="fas fa-redo-alt me-1"></i> Renouveler
                                                        </a>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3" disabled>
                                                        <i class="fas fa-ban me-1"></i> Limite atteinte
                                                    </button>
                                                @endif
                                            @else
                                                <span class="text-muted small">Indisponible après évaluation</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="text-center pe-4">
                                        @if($estEvalue)
                                            <span class="badge bg-success px-3 py-2 rounded-pill">
                                                ⭐ {{ number_format((float)$demande->evaluation->note_finale, 2, ',', ' ') }}/20
                                            </span>
                                        @else
                                            <a href="{{ route('responsable.evaluations.create', $demande->id) }}"
                                               class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm">
                                                <i class="fas fa-star me-1"></i> Évaluer
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    @endif

    <div class="mt-4">
        <a href="{{ route('responsable.stagiaires.index') }}" class="btn btn-light border rounded-pill px-4 shadow-sm">
            <i class="fas fa-arrow-left me-2"></i> Retour au menu
        </a>
    </div>
</div>
@endsection

@push('css')
<style>
    .mini-stat-card {
        min-width: 120px;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 16px;
        padding: 14px 18px;
        display: flex;
        flex-direction: column;
        box-shadow: 0 6px 16px rgba(0,0,0,0.04);
    }

    .mini-stat-card.warning {
        border-color: rgba(255, 193, 7, 0.35);
        background: #fffdf7;
    }

    .mini-stat-label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: #6c757d;
        margin-bottom: 4px;
    }

    .mini-stat-value {
        font-size: 1.5rem;
        font-weight: 800;
        color: #212529;
        line-height: 1;
    }

    .modern-table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        font-weight: 800;
        padding-top: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e9ecef;
        white-space: nowrap;
    }

    .modern-table tbody td {
        padding-top: 1rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eef2f7;
        vertical-align: middle;
    }

    .modern-table tbody tr {
        transition: all 0.2s ease;
    }

    .modern-table tbody tr:hover {
        background: #fafcff;
    }

    .row-highlight {
        background: linear-gradient(90deg, rgba(255,193,7,0.08) 0%, rgba(255,255,255,1) 35%);
    }

    .avatar-box {
        width: 46px;
        height: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, #0d6efd, #1e3a8a);
        color: white;
        font-weight: 800;
        font-size: 0.85rem;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 18px rgba(13, 110, 253, 0.18);
        flex-shrink: 0;
    }

    .status-pill {
        display: inline-flex;
        align-items: center;
        border-radius: 999px;
        padding: 7px 14px;
        font-size: 0.78rem;
        font-weight: 700;
        border: 1px solid transparent;
    }

    .status-pill.success {
        background: #ecfdf5;
        color: #059669;
        border-color: #d1fae5;
    }

    .status-pill.warning {
        background: #fff8e1;
        color: #b78103;
        border-color: #ffe69c;
    }

    .renew-badge {
        display: inline-block;
        font-size: 0.78rem;
        font-weight: 700;
        color: #6c757d;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 999px;
        padding: 6px 12px;
        width: fit-content;
    }

    .empty-icon {
        width: 72px;
        height: 72px;
        margin: 0 auto;
        border-radius: 20px;
        background: #f8f9fa;
        color: #6c757d;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.6rem;
    }

    @media (max-width: 768px) {
        .modern-table th,
        .modern-table td {
            white-space: nowrap;
        }
    }
</style>
@endpush
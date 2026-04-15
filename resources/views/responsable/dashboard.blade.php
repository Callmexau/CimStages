@extends('layouts.adminlte')

@section('content')
<div class="dashboard-container">
    
    {{-- HEADER DYNAMIQUE --}}
    <div class="header-section px-4 pt-4 pb-2">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="h3 font-weight-bold text-dark mb-1">Tableau de Bord</h2>
                <p class="text-muted mb-0">
                    <span class="opacity-75"><i class="far fa-calendar-alt mr-2"></i>{{ ucfirst(now()->translatedFormat('l d F Y')) }}</span>
                </p>
            </div>
            <div class="user-pill d-none d-sm-flex align-items-center bg-white shadow-sm border px-3 py-2">
                <div class="status-indicator mr-2"></div>
                <span class="small font-weight-bold text-secondary">
                    {{ Auth::user()->name ?? 'Responsable' }}
                </span>
            </div>
        </div>

        {{-- STATS RAPIDES --}}
        <div class="row mb-2">
            <div class="col-md-3">
                <div class="stat-card border-0 shadow-sm bg-white p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary-soft text-primary mr-3">
                            <i class="fas fa-inbox"></i>
                        </div>
                        <div>
                            <span class="text-uppercase text-muted ls-1 small font-weight-bold">Total Demandes</span>
                            <h3 class="mb-0 font-weight-bold text-dark">{{ $demandes->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card border-0 shadow-sm bg-white p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-warning-soft text-warning mr-3">
                            <i class="fas fa-history"></i>
                        </div>
                        <div>
                            <span class="text-uppercase text-muted ls-1 small font-weight-bold">En attente</span>
                            <h3 class="mb-0 font-weight-bold text-dark">
                                {{ $demandes->where('statut','en_attente')->count() }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card border-0 shadow-sm bg-white p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-success-soft text-success mr-3">
                            <i class="fas fa-user-graduate"></i>
                        </div>
                        <div>
                            <span class="text-uppercase text-muted ls-1 small font-weight-bold">En cours</span>
                            <h3 class="mb-0 font-weight-bold text-dark">{{ $stagiairesEnCours }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card border-0 shadow-sm bg-white p-3 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-danger-soft text-danger mr-3">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <div>
                            <span class="text-uppercase text-muted ls-1 small font-weight-bold">
                                Non évalués
                            </span>
                            <h3 class="mb-0 font-weight-bold text-dark">
                                {{ $stagiairesTerminesNonEvalues }}
                            </h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- GRILLE DES DEMANDES --}}
    <div class="main-scroll-area px-4 pb-5">
        <div class="row">
            @forelse($demandes as $demande)
                <div class="col-xl-4 col-lg-6 mb-4">
                    <div class="card card-modern h-100">
                        
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-styled mr-3">
                                        {{ strtoupper(substr($demande->stagiaire->prenom ?? 'S', 0, 1)) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 font-weight-bold text-dark">
                                            {{ $demande->stagiaire->prenom ?? 'N/A' }} {{ strtoupper($demande->stagiaire->nom ?? '') }}
                                        </h6>
                                        <small class="text-muted">Reçu le {{ $demande->created_at->format('d/m/Y') }}</small>
                                    </div>
                                </div>
                                
                                @php
                                    $statusMap = [
                                        'en_attente' => ['class' => 's-pending', 'label' => 'En attente'],
                                        'validee'    => ['class' => 's-success', 'label' => 'Validée'],
                                        'rejetee'    => ['class' => 's-danger', 'label' => 'Refusée'],
                                        'transferée' => ['class' => 's-info', 'label' => 'Transférée'],
                                    ];
                                    $currentStatus = $statusMap[$demande->statut] ?? ['class' => 's-default', 'label' => $demande->statut];
                                @endphp
                                <span class="badge-dot {{ $currentStatus['class'] }}">
                                    {{ $currentStatus['label'] }}
                                </span>
                            </div>

                            <div class="info-grid py-3 px-3 rounded-xl mb-4">
                                <div class="row no-gutters">
                                    <div class="col-6 pr-2 border-right">
                                        <label class="d-block text-muted text-uppercase mb-1">Filière</label>
                                        <span class="font-weight-bold small text-dark">{{ $demande->filiere ?? 'N/A' }}</span>
                                    </div>
                                    <div class="col-6 pl-3">
                                        <label class="d-block text-muted text-uppercase mb-1">Niveau</label>
                                        <span class="font-weight-bold small text-dark">{{ $demande->niveau_etude ?? 'N/A' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pt-2">
                                <a href="{{ route('responsable.demande.show', $demande) }}" class="btn btn-action-main">
                                    <span>Consulter le dossier</span>
                                    <i class="fas fa-chevron-right ml-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="empty-state">
                        <div class="empty-icon mb-3">
                            <i class="fas fa-folder-open"></i>
                        </div>
                        <h5 class="text-muted font-weight-light">Aucune demande reçu pour le moment</h5>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    /* Structure & Scroll */
    .dashboard-container {
        height: calc(100vh - 60px);
        display: flex;
        flex-direction: column;
        background-color: #f4f7f9;
        overflow: hidden;
    }
    .main-scroll-area {
        flex-grow: 1;
        overflow-y: auto;
        scrollbar-width: thin;
    }

    /* Typographie */
    .ls-1 { letter-spacing: 0.5px; }
    
    /* Composants Header */
    .user-pill {
        border-radius: 100px;
        border: 1px solid #e1e8ed !important;
    }
    .status-indicator {
        width: 8px;
        height: 8px;
        background-color: #2ecc71;
        border-radius: 50%;
        box-shadow: 0 0 0 3px rgba(46, 204, 113, 0.2);
    }

    /* Stat Cards */
    .stat-card {
        border-radius: 16px;
        transition: transform 0.3s ease;
    }
    .icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
    }
    .bg-primary-soft { background-color: #eef2ff; color: #4f46e5; }
    .bg-warning-soft { background-color: #fffbeb; color: #d97706; }

    /* Card Demande */
    .card-modern {
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .card-modern:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1);
    }

    .avatar-styled {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #1a5a45 0%, #34d399 100%);
        color: white;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(26, 90, 69, 0.2);
    }

    .info-grid {
        background-color: #f8fafc;
        border: 1px solid #edf2f7;
    }
    .info-grid label {
        font-size: 0.65rem;
        font-weight: 800;
        letter-spacing: 0.05em;
    }

    /* Badges */
    .badge-dot {
        font-size: 0.75rem;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 6px;
    }
    .s-pending { background-color: #fef3c7; color: #92400e; }
    .s-success { background-color: #dcfce7; color: #166534; }
    .s-danger  { background-color: #fee2e2; color: #991b1b; }
    .s-info    { background-color: #e0f2fe; color: #075985; }

    /* Boutons */
    .btn-action-main {
        background-color: transparent;
        color: #1a5a45;
        border: 1px solid #1a5a45;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 20px;
        border-radius: 10px;
        transition: all 0.2s;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .btn-action-main:hover {
        background-color: #1a5a45;
        color: white;
        text-decoration: none;
    }

    /* Empty State */
    .empty-icon {
        font-size: 4rem;
        color: #e2e8f0;
    }
</style>
@endsection
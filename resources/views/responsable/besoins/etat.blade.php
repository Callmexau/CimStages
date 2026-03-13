@extends('layouts.adminlte')

@section('content')
<div class="container-fluid pt-5" style="background: #f4f7f6; min-height: 90vh;">
    <div class="row justify-content-center">
        <div class="col-xl-9">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="font-weight-bold text-dark mb-1">Tableau de Bord</h2>
                    <p class="text-muted small"><i class="fas fa-home mr-1"></i> Gestion / <span class="text-primary font-weight-bold">Suivi Demande</span></p>
                </div>
                @if($besoin)
                    <span class="badge badge-white shadow-sm border px-3 py-2 text-muted">
                        Réf: #{{ str_pad($besoin->id, 5, '0', STR_PAD_LEFT) }}
                    </span>
                @endif
            </div>

            @if($besoin)
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                            <div class="card-body p-4">
                                <h5 class="font-weight-bold mb-4">Détails de l'affectation</h5>
                                
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="p-3 border rounded-lg bg-light-custom">
                                            <small class="text-muted d-block mb-1">DÉPARTEMENT</small>
                                            <span class="h6 font-weight-bold">{{ $besoin->departement }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="p-3 border rounded-lg bg-light-custom">
                                            <small class="text-muted d-block mb-1">SERVICE</small>
                                            <span class="h6 font-weight-bold">{{ $besoin->service }}</span>
                                        </div>
                                    </div>
                                </div>

                                <h5 class="font-weight-bold mt-2 mb-4">Progression du dossier</h5>
                                <div class="position-relative mb-5 mt-4">
                                    <div class="progress" style="height: 6px;">
                                        @php
                                            $progression = ['en_attente' => 50, 'valide' => 100, 'refuse' => 100];
                                            $colorProg = $besoin->statut == 'refuse' ? 'bg-danger' : 'bg-success';
                                            $width = $progression[$besoin->statut] ?? 50;
                                        @endphp
                                        <div class="progress-bar {{ $colorProg }}" style="width: {{ $width }}%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-3">
                                        <div class="text-center">
                                            <div class="step-dot bg-success"></div>
                                            <small class="font-weight-bold d-block mt-2">Soumis</small>
                                        </div>
                                        <div class="text-center">
                                            <div class="step-dot {{ $width >= 50 ? ($besoin->statut == 'refuse' ? 'bg-danger' : 'bg-success') : 'bg-secondary' }}"></div>
                                            <small class="font-weight-bold d-block mt-2">Examen</small>
                                        </div>
                                        <div class="text-center">
                                            <div class="step-dot {{ $width == 100 ? ($besoin->statut == 'refuse' ? 'bg-danger' : 'bg-success') : 'bg-secondary' }}"></div>
                                            <small class="font-weight-bold d-block mt-2">Décision</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card border-0 shadow-sm text-center mb-4" style="border-radius: 15px; background: linear-gradient(145deg, #ffffff, #f8f9fa);">
                            <div class="card-body p-4">
                                @php
                                    $config = [
                                        'en_attente' => ['color' => 'warning', 'icon' => 'fa-spinner fa-spin', 'label' => 'En attente'],
                                        'valide'     => ['color' => 'success', 'icon' => 'fa-check-double', 'label' => 'Approuvé'],
                                        'refuse'     => ['color' => 'danger', 'icon' => 'fa-ban', 'label' => 'Refusé'],
                                    ];
                                    $current = $config[$besoin->statut] ?? $config['en_attente'];
                                @endphp
                                
                                <div class="mb-3 mt-2">
                                    <span class="display-4 text-{{ $current['color'] }}">
                                        <i class="fas {{ $current['icon'] }}"></i>
                                    </span>
                                </div>
                                <h3 class="font-weight-bold">{{ $current['label'] }}</h3>
                                <p class="text-muted px-3">Le statut a été mis à jour le {{ $besoin->updated_at->translatedFormat('d M Y à H:i') }}</p>
                                
                                <hr>

                                <div class="stat-box mb-3">
                                    <h2 class="mb-0 font-weight-bold text-primary">{{ $besoin->nombre_stagiaires }}</h2>
                                    <small class="text-muted font-weight-bold">STAGIAIRES DEMANDÉS</small>
                                </div>

                                <button class="btn btn-primary btn-block rounded-pill py-2 shadow-sm">
                                    <i class="fas fa-print mr-2"></i> Imprimer le Bon
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <div class="card border-0 shadow-sm text-center py-5" style="border-radius: 15px;">
                    <div class="card-body">
                        <h3 class="font-weight-bold">Aucune activité récente</h3>
                        <p class="text-muted mb-4">Il semble que vous n'ayez pas encore soumis de besoin pour votre service.</p>
                        <a href="{{ route('responsable.besoins.create') }}" class="btn btn-primary px-5 rounded-pill shadow-lg">Emmétre un besoin</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Custom Design Tokens */
    .bg-light-custom { background-color: #f9fbfd; border-color: #edf2f9 !important; }
    
    .step-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        border: 2px solid #fff;
        box-shadow: 0 0 0 2px #e9ecef;
    }

    .btn-primary { background-color: #4e73df; border: none; }
    .btn-primary:hover { background-color: #2e59d9; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(78, 115, 223, 0.35); }

    .card { transition: all 0.3s ease; }
    .badge-white { background: #fff; color: #6c757d; font-weight: 600; }

    /* Animation pour l'icône de chargement */
    .fa-spin { animation: fa-spin 2s infinite linear; }

    @media (max-width: 768px) {
        .display-4 { font-size: 2.5rem; }
    }
</style>
@endsection
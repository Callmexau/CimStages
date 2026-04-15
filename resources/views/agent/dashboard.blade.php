@extends('layouts.adminlte')

@section('content')
<div class="container-fluid pt-2">

    {{-- Bannière compacte --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="welcome-banner bg-white shadow-sm rounded p-3 border-left border-info d-flex align-items-center justify-content-between flex-wrap">
                <div class="d-flex align-items-center">
                    <div class="icon-circle mr-3 d-flex align-items-center justify-content-center"
                         style="width:50px;height:50px;border-radius:50%;background:#e0f3ff;">
                        <i class="fas fa-user-shield text-info"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold">
                            Bienvenue, {{ auth()->user()->name ?? 'Agent RH' }}
                        </h5>

                        <small class="text-muted d-block">
                            <span class="badge badge-warning px-2 py-1">
                                <i class="fas fa-hourglass-half mr-1"></i>
                                {{ $stats['demandes_en_attente'] ?? 0 }}
                            </span>
                            demandes à traiter
                        </small>

                        <small class="text-muted d-block mt-2">
                            <span class="badge badge-primary px-2 py-1">
                                <i class="fas fa-clipboard-list mr-1"></i>
                                {{ $stats['besoins_en_attente'] ?? 0 }} en attente
                            </span>

                            <span class="badge badge-success px-2 py-1 ml-2">
                                <i class="fas fa-check mr-1"></i>
                                {{ $stats['besoins_valides'] ?? 0 }} validés
                            </span>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Small boxes --}}
    <div class="row d-flex flex-wrap">
        @php
            $boxes = [
                [
                    'label' => 'Demandes en attente',
                    'val'   => $stats['demandes_en_attente'] ?? 0,
                    'bg'    => 'bg-warning',
                    'icon'  => 'fa-hourglass-half',
                    'route' => 'agent.demande.index'
                ],
                [
                    'label' => 'Demandes validées',
                    'val'   => $stats['demandes_validees'] ?? 0,
                    'bg'    => 'bg-success',
                    'icon'  => 'fa-check-double',
                    'route' => 'agent.demande.index'
                ],
                [
                    'label' => 'Demandes rejetées',
                    'val'   => $stats['demandes_rejetees'] ?? 0,
                    'bg'    => 'bg-danger',
                    'icon'  => 'fa-times-circle',
                    'route' => 'agent.demande.index'
                ],
                [
                    'label' => 'Besoins en attente',
                    'val'   => $stats['besoins_en_attente'] ?? 0,
                    'bg'    => 'bg-primary',
                    'icon'  => 'fa-clipboard-list',
                    'route' => 'agent.besoins.index'
                ],
                [
                    'label' => 'Besoins validés',
                    'val'   => $stats['besoins_valides'] ?? 0,
                    'bg'    => 'bg-success',
                    'icon'  => 'fa-clipboard-check',
                    'route' => 'agent.besoins.index'
                ],
            ];
        @endphp

        @foreach($boxes as $box)
        <div class="box-flex mb-3 px-2">
            <div class="small-box {{ $box['bg'] }} shadow-sm hover-up {{ $box['val'] > 0 && str_contains($box['label'], 'attente') ? 'box-alert' : '' }}">
                <div class="inner p-2">
                    <h4 class="font-weight-bold mb-0">{{ $box['val'] }}</h4>
                    <small>{{ $box['label'] }}</small>
                </div>

                <div class="icon">
                    <i class="fas {{ $box['icon'] }}"></i>
                </div>

                <a href="{{ route($box['route']) }}" class="small-box-footer py-1">
                    Gérer <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Cartes actions --}}
    <div class="row mt-2">
        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-users-cog text-info mr-2"></i>
                        <strong>Demandes de Stage</strong>
                    </div>
                    <small class="text-muted d-block mb-3">
                        Examinez, validez et gérez les candidatures.
                    </small>
                    <a href="{{ route('agent.demande.index') }}"
                       class="btn btn-info btn-sm btn-block">
                        Accéder
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-clipboard-check text-secondary mr-2"></i>
                        <strong>Besoins Internes</strong>
                    </div>
                    <small class="text-muted d-block mb-3">
                        Consultez les besoins en attente et les besoins déjà validés.
                    </small>
                    <a href="{{ route('agent.besoins.index') }}"
                       class="btn btn-secondary btn-sm btn-block">
                        Consulter
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
.hover-up {
    transition: 0.25s ease;
    border-radius: 10px;
}

.hover-up:hover {
    transform: translateY(-4px) scale(1.01);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}

.small-box {
    border-radius: 10px;
    margin-bottom: 0;
}

.small-box .icon {
    font-size: 45px;
    top: 5px;
    right: 10px;
}

.welcome-banner {
    border-left-width: 4px !important;
}

.box-alert {
    border: 2px solid rgba(255, 193, 7, 0.75);
    box-shadow: 0 0 0 4px rgba(255, 193, 7, 0.15);
}

.box-flex {
    flex: 0 0 20%;
    max-width: 20%;
}

@media (max-width: 1199.98px) {
    .box-flex {
        flex: 0 0 25%;
        max-width: 25%;
    }
}

@media (max-width: 991.98px) {
    .box-flex {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (max-width: 575.98px) {
    .box-flex {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
</style>
@endsection
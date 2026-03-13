@extends('layouts.adminlte')

@section('content')
<div class="container-fluid pt-2">

    {{-- Bannière compacte --}}
    <div class="row mb-2">
        <div class="col-12">
            <div class="welcome-banner bg-white shadow-sm rounded p-3 border-left border-info d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center">
                    <div class="icon-circle mr-3 d-flex align-items-center justify-content-center"
                         style="width:50px;height:50px;border-radius:50%;background:#e0f3ff;">
                        <i class="fas fa-user-shield text-info"></i>
                    </div>
                    <div>
                        <h5 class="mb-0 font-weight-bold">
                            Bienvenue, {{ auth()->user()->name ?? 'Agent RH' }}
                        </h5>
                        <small class="text-muted">
                            <span class="badge badge-warning">
                                {{ $stats['demandes_en_attente'] ?? 0 }}
                            </span> demandes à traiter
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Small boxes compactes --}}
    <div class="row">
        @php
            $boxes = [
                ['label'=>'En attente','val'=>$stats['demandes_en_attente'] ?? 0,'bg'=>'bg-warning','icon'=>'fa-hourglass-half','route'=>'agent.demande.index'],
                ['label'=>'Validées','val'=>$stats['demandes_validees'] ?? 0,'bg'=>'bg-success','icon'=>'fa-check-double','route'=>'agent.demande.index'],
                ['label'=>'Rejetées','val'=>$stats['demandes_rejetees'] ?? 0,'bg'=>'bg-danger','icon'=>'fa-times-circle','route'=>'agent.demande.index'],
                ['label'=>'Besoins','val'=>$stats['besoins'] ?? 0,'bg'=>'bg-primary','icon'=>'fa-building','route'=>'agent.besoins.index'],
            ];
        @endphp

        @foreach($boxes as $box)
        <div class="col-lg-3 col-6">
            <div class="small-box {{ $box['bg'] }} shadow-sm hover-up">
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

    {{-- Cartes actions compactes --}}
    <div class="row mt-2">
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-users-cog text-info mr-2"></i>
                        <strong>Demandes de Stage</strong>
                    </div>
                    <small class="text-muted">
                        Examinez, validez et gérez les candidatures.
                    </small>
                    <a href="{{ route('agent.demande.index') }}"
                       class="btn btn-info btn-sm btn-block mt-2">
                        Accéder
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center mb-2">
                        <i class="fas fa-clipboard-check text-secondary mr-2"></i>
                        <strong>Besoins Internes</strong>
                    </div>
                    <small class="text-muted">
                        Consultez les demandes des départements.
                    </small>
                    <a href="{{ route('agent.besoins.index') }}"
                       class="btn btn-secondary btn-sm btn-block mt-2">
                        Consulter
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>

<style>
.hover-up { transition: 0.2s; border-radius: 10px; }
.hover-up:hover { transform: translateY(-3px); }
.small-box { border-radius: 10px; }
.small-box .icon { font-size: 45px; top: 5px; right: 10px; }
.welcome-banner { border-left-width: 4px !important; }
</style>
@endsection
@extends('layouts.adminlte')

@section('content')

<section class="content-wrapper-premium" style="background:#f4f7fa; padding: 2.5rem 1.5rem;">
    <div class="container-fluid">

        {{-- Header --}}
        <div class="row mb-5">
            <div class="col-md-12">
                @php $user = Auth::user(); @endphp
                <h1 class="h3 font-weight-bold text-dark mb-1">
                    Bonjour, <span class="text-gradient">{{ $user->prenom }} {{ $user->nom }}</span> 👋
                </h1>
                <p class="text-muted" style="font-size: 1.1rem; letter-spacing: -0.01em;">
                    Gestionnaire RH <span class="mx-2 text-silver">|</span> Suivi des besoins de stages
                </p>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="row mb-5">
            @php
                $cards = [
                    ['label' => 'Stagiaires acceptés', 'value' => $stats['stagiaires'], 'icon' => 'fa-user-graduate', 'color' => '#3b82f6', 'bg' => 'rgba(59, 130, 246, 0.1)'],
                    ['label' => 'Responsables', 'value' => $stats['responsables'], 'icon' => 'fa-user-tie', 'color' => '#10b981', 'bg' => 'rgba(16, 185, 129, 0.1)'],
                    ['label' => 'Agents RH', 'value' => $stats['agents'], 'icon' => 'fa-user-cog', 'color' => '#f59e0b', 'bg' => 'rgba(245, 158, 11, 0.1)']
                ];
            @endphp

            @foreach($cards as $card)
            <div class="col-lg-4">
                <div class="stat-card shadow-sm border-0">
                    <div class="icon-box" style="background: {{ $card['bg'] }}; color: {{ $card['color'] }};">
                        <i class="fas {{ $card['icon'] }}"></i>
                    </div>
                    <div class="stat-content">
                        <span class="stat-label">{{ $card['label'] }}</span>
                        <h2 class="stat-value">{{ $card['value'] }}</h2>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Tableau demandes --}}
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 16px;">
                    <div class="card-header bg-white py-4 border-0">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="mb-0 font-weight-bold text-dark" style="font-size: 1.25rem;">
                                <i class="fas fa-list-ul mr-2 text-primary"></i>
                                Besoins en attente de traitement
                            </h4>
                            <span class="badge badge-soft-primary px-3 py-2">{{ count($besoins) }} demande(s)</span>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th class="pl-4">REF. ID</th>
                                        <th>RESPONSABLE STRUCTURE</th>
                                        <th>DÉPARTEMENT</th>
                                        <th>DEMANDEUR</th>
                                        <th class="text-right pr-4">ACTIONS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($besoins as $besoin)
                                    <tr>
                                        <td class="pl-4 text-muted font-weight-bold">#{{ $besoin->id }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm mr-2">{{ substr($besoin->responsable_nom, 0, 1) }}</div>
                                                <span class="font-weight-600 text-dark">{{ $besoin->responsable_nom }}</span>
                                            </div>
                                        </td>
                                        <td><span class="dept-tag">{{ $besoin->departement }}</span></td>
                                        <td><span class="text-dark">{{ $besoin->poste }}</span></td>
                                        <td class="text-right pr-4">
                                            <div class="btn-group-action">
                                                {{-- Voir détails --}}
                                                <a href="{{ route('darh.besoins.show', $besoin) }}" class="btn btn-action btn-view" title="Voir détails">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                {{-- Valider --}}
                                                <form action="{{ route('darh.besoins.valider', $besoin) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-action btn-approve" title="Valider">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>

                                                {{-- Rejeter --}}
                                                <form action="{{ route('darh.besoins.rejeter', $besoin) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button class="btn btn-action btn-reject" title="Rejeter">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="mb-3 opacity-50" alt="Empty">
                                            <p class="text-muted">Aucune nouvelle demande à traiter pour le moment.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
/* TYPOGRAPHIE & COULEURS */
.text-gradient { background: linear-gradient(135deg, #1e40af, #3b82f6); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.text-silver { color: #cbd5e1; }
.font-weight-600 { font-weight: 600; }

/* CARDS STATISTIQUES */
.stat-card { background: #ffffff; padding: 1.5rem; border-radius: 16px; display: flex; align-items: center; gap: 1.25rem; transition: all 0.3s ease; }
.stat-card:hover { transform: translateY(-5px); }
.icon-box { width: 56px; height: 56px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; }
.stat-label { color: #64748b; font-size: 0.9rem; font-weight: 500; display: block; }
.stat-value { margin: 0; font-size: 1.75rem; font-weight: 800; color: #1e293b; }

/* TABLEAU PERSONNALISÉ */
.table-custom thead th { background: #f8fafc; border-top: none; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.05em; color: #64748b; padding: 1rem 0.75rem; }
.table-custom tbody td { vertical-align: middle; padding: 1.1rem 0.75rem; border-bottom: 1px solid #f1f5f9; color: #475569; }
.table-custom tbody tr:hover { background-color: #fbfcfe; }

/* AVATAR & TAGS */
.avatar-sm { width: 32px; height: 32px; background: #e2e8f0; color: #475569; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 0.8rem; }
.dept-tag { background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 6px; font-size: 0.85rem; font-weight: 500; }

/* BOUTONS D'ACTION */
.btn-group-action { display: flex; gap: 8px; justify-content: flex-end; }
.btn-action { width: 36px; height: 36px; border-radius: 10px; border: none; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
.btn-view { background: #3b82f6; color: white; }
.btn-view:hover { background: #2563eb; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
.btn-approve { background: #10b981; color: white; }
.btn-approve:hover { background: #059669; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
.btn-reject { background: #ef4444; color: white; }
.btn-reject:hover { background: #dc2626; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3); }

.badge-soft-primary { background: #e0e7ff; color: #4338ca; font-weight: 600; }
</style>

@endsection
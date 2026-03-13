@extends('layouts.adminlte')

@section('content')

<div class="container-fluid pt-5" style="background: #f4f7f6; min-height: 100vh;">
    
    <div class="row mb-4">
        <div class="col-md-7">
            <h2 class="font-weight-bold text-dark">
                <i class="fas fa-file-signature text-primary mr-2"></i>
                Gestion des besoins
            </h2>
        </div>
        <div class="col-md-5 text-md-right">
            <div class="btn-group shadow-sm">
                <button class="btn btn-white border font-weight-bold">
                    <i class="fas fa-print mr-2"></i>Exporter la session
                </button>
            </div>
        </div>
    </div>

    <ul class="nav nav-pills mb-4 custom-tabs" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="pill" href="#pills-pending">
                <i class="fas fa-clock mr-2"></i>À Valider / Transférer 
                <span class="badge badge-warning ml-2">
                    {{ $besoins->where('statut', 'en_attente_validation')->count() }}
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="pill" href="#pills-validated">
                <i class="fas fa-check-circle mr-2"></i>Besoins Validés
                <span class="badge badge-success ml-2">
                    {{ $besoins->where('statut', 'valide')->count() }}
                </span>
            </a>
        </li>
    </ul>

    <div class="tab-content shadow-lg-soft rounded-xl bg-white">
        
        {{-- ================= EN ATTENTE ================= --}}
        <div class="tab-pane fade show active p-4" id="pills-pending">
            <div class="table-responsive">
                <table class="table table-align-middle border-0">
                    <thead class="text-muted small uppercase">
                        <tr>
                            <th>Service émetteur</th>
                            <th>Demandeur</th>
                            <th class="text-center">Effectif demandé</th>
                            <th>Soumis le</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($besoins->whereIn('statut', ['en_attente', 'en_attente_validation']) as $besoin)
                            <tr class="hover-row-light">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-warning-soft text-warning mr-3">
                                            <i class="fas fa-hourglass-start"></i>
                                        </div>
                                        <span class="font-weight-bold text-dark">
                                            {{ $besoin->service }}
                                        </span>
                                    </div>
                                </td>

                                <td class="text-muted font-italic">
                                    {{ $besoin->profil_recherche ?? $besoin->poste }}
                                </td>

                                <td class="text-center">
                                    <span class="badge badge-dark px-3 py-2 rounded-pill">
                                        {{ $besoin->nombre_stagiaires }}
                                    </span>
                                </td>

                                <td>
                                    {{ $besoin->created_at->format('d/m/Y') }}
                                </td>

                                <td class="text-right">
                                    <div class="d-flex justify-content-end align-items-center">

                                        <a href="{{ route('agent.besoins.show', $besoin->id) }}"
                                           class="btn btn-light btn-sm mr-2 shadow-none border rounded-lg">
                                            <i class="fas fa-eye text-primary"></i> Détails
                                        </a>

                                        <form action="{{ route('agent.besoins.transfer', $besoin->id) }}"
                                              method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit"
                                                    class="btn btn-primary-brand btn-sm rounded-lg px-3 shadow-sm">
                                                <i class="fas fa-paper-plane mr-2"></i>
                                                Transférer au DARH
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    Aucune demande en attente de traitement.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- ================= VALIDÉS ================= --}}
        <div class="tab-pane fade p-4" id="pills-validated">
            <div class="table-responsive">
                <table class="table table-align-middle border-0">
                    <thead class="text-muted small uppercase">
                        <tr>
                            <th>Service</th>
                            <th>Profil</th>
                            <th>Date de Validation</th>
                            <th>Statut</th>
                            <th class="text-right">Archive</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($besoins->where('statut', 'valide') as $besoin)
                            <tr class="hover-row-light opacity-80">
                                <td class="font-weight-bold text-dark">
                                    {{ $besoin->service }}
                                </td>

                                <td>
                                    {{ $besoin->profil_recherche ?? $besoin->poste }}
                                </td>

                                <td class="text-success">
                                    <i class="fas fa-check-double mr-1 small"></i>
                                    {{ $besoin->updated_at->format('d/m/Y') }}
                                </td>

                                <td>
                                    <span class="badge badge-success-soft px-3 py-2 font-weight-bold text-uppercase"
                                          style="font-size: 0.7rem;">
                                        Validé par DARH
                                    </span>
                                </td>

                                <td class="text-right">
                                    {{-- ✅ ROUTE CORRIGÉE --}}
                                    <a href="{{ route('agent.besoins.show', $besoin->id) }}"
                                       class="btn btn-outline-secondary btn-sm rounded-lg">
                                        Consulter
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    Aucun besoin validé pour le moment.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --brand-blue: #2563eb;
    --soft-blue: #eff6ff;
    --brand-warning: #f59e0b;
    --soft-warning: #fffbeb;
}

.custom-tabs .nav-link {
    border-radius: 12px;
    padding: 12px 24px;
    font-weight: 700;
    color: #64748b;
    transition: 0.3s;
    border: 1px solid transparent;
}

.custom-tabs .nav-link.active {
    background: #fff !important;
    color: var(--brand-blue) !important;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
}

.rounded-xl { border-radius: 1.25rem; }
.shadow-lg-soft { box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); }
.bg-warning-soft { background-color: var(--soft-warning); }
.badge-success-soft { background: #dcfce7; color: #166534; }

.btn-primary-brand {
    background: var(--brand-blue);
    color: #fff;
    border: none;
    transition: 0.3s;
}

.btn-primary-brand:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
}

.icon-shape {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
}

.hover-row-light:hover { background-color: #fcfdfe; }
.opacity-80 { opacity: 0.85; }
.table-align-middle td { vertical-align: middle !important; padding: 1.2rem 0.75rem; }
</style>

@endsection
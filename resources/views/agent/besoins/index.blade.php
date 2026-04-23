@extends('layouts.adminlte')

@section('content')

@php
    $activeTab = request('tab', 'pending');
@endphp

<div class="container-fluid pt-5" style="background: #f4f7f6; min-height: 100vh;">

    <div class="row mb-4">
        <div class="col-md-7">
            <h2 class="font-weight-bold text-dark mb-1">
                <i class="fas fa-file-signature text-primary mr-2"></i>
                Gestion des besoins
            </h2>
            <p class="text-muted mb-0">
                Suivi des besoins avec distinction entre éléments nouveaux et déjà consultés.
            </p>
        </div>

        <div class="col-md-5 text-md-right mt-3 mt-md-0">
            <div class="btn-group shadow-sm">
                <button class="btn btn-white border font-weight-bold">
                    <i class="fas fa-print mr-2"></i>Exporter la session
                </button>
            </div>
        </div>
    </div>

    <ul class="nav nav-pills mb-4 custom-tabs" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'pending' ? 'active' : '' }}"
               data-toggle="pill"
               href="#pills-pending"
               role="tab">
                <i class="fas fa-clock mr-2"></i>À Valider / Transférer
                <span class="badge badge-warning ml-2">
                    {{ $countEnAttente }}
                </span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $activeTab === 'validated' ? 'active' : '' }}"
               data-toggle="pill"
               href="#pills-validated"
               role="tab">
                <i class="fas fa-check-circle mr-2"></i>Besoins Validés
                <span class="badge badge-success ml-2">
                    {{ $countValides }}
                </span>

                @if($countValidesNonConsultes > 0)
                    <span class="badge badge-warning ml-1">
                        {{ $countValidesNonConsultes }}
                    </span>
                @endif
            </a>
        </li>
    </ul>

    <div class="tab-content shadow-lg-soft rounded-xl bg-white">

        {{-- ================= EN ATTENTE ================= --}}
        <div class="tab-pane fade {{ $activeTab === 'pending' ? 'show active' : '' }} p-4" id="pills-pending">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
                <h5 class="font-weight-bold text-dark mb-2 mb-md-0">
                    <i class="fas fa-hourglass-half text-warning mr-2"></i>
                    Besoins en attente de traitement
                </h5>

                <span class="badge badge-light border px-3 py-2">
                    {{ $besoinsEnAttente->total() }} résultat(s)
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-align-middle border-0 modern-table">
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
                        @forelse($besoinsEnAttente as $besoin)
                            <tr class="hover-row-light">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape bg-warning-soft text-warning mr-3">
                                            <i class="fas fa-hourglass-start"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark">
                                                {{ $besoin->service }}
                                            </div>
                                            @if($besoin->type_demande)
                                                <small class="text-muted text-uppercase">
                                                    {{ $besoin->type_demande }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td class="text-muted font-italic">
                                    {{ $besoin->profil_recherche ?? $besoin->poste ?? 'Non précisé' }}
                                </td>

                                <td class="text-center">
                                    <span class="badge badge-dark px-3 py-2 rounded-pill">
                                        {{ $besoin->nombre_stagiaires }}
                                    </span>
                                </td>

                                <td>
                                    <div class="text-dark">
                                        {{ $besoin->created_at->format('d/m/Y') }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $besoin->created_at->format('H:i') }}
                                    </small>
                                </td>

                                <td class="text-right">
                                    <div class="d-flex justify-content-end align-items-center flex-wrap">
                                        <a href="{{ route('agent.besoins.show', $besoin->id) }}"
                                           class="btn btn-light btn-sm mr-2 mb-1 mb-md-0 shadow-none border rounded-lg">
                                            <i class="fas fa-eye text-primary"></i> Détails
                                        </a>

                                        <form action="{{ route('agent.besoins.transfer', $besoin->id) }}"
                                              method="POST"
                                              style="display:inline;">
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

            @if($besoinsEnAttente->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $besoinsEnAttente->appends(array_merge(request()->except('pending_page'), ['tab' => 'pending']))->links() }}
                </div>
            @endif
        </div>

        {{-- ================= VALIDÉS ================= --}}
        <div class="tab-pane fade {{ $activeTab === 'validated' ? 'show active' : '' }} p-4" id="pills-validated">
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-3">
                <h5 class="font-weight-bold text-dark mb-2 mb-md-0">
                    <i class="fas fa-check-circle text-success mr-2"></i>
                    Besoins validés
                </h5>

                <div class="d-flex flex-wrap">
                    <span class="badge badge-warning px-3 py-2 mr-2 mb-2">
                        Non consultés : {{ $countValidesNonConsultes }}
                    </span>
                    <span class="badge badge-primary px-3 py-2 mb-2">
                        Déjà consultés : {{ $countValidesConsultes }}
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-align-middle border-0 modern-table">
                    <thead class="text-muted small uppercase">
                        <tr>
                            <th>Service</th>
                            <th>Profil</th>
                            <th>Date de validation</th>
                            <th>État</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($besoinsValides as $besoin)
                            @php
                                $isSeen = (bool) $besoin->is_seen_by_agent;
                            @endphp

                            <tr class="hover-row-light {{ !$isSeen ? 'row-unseen' : 'row-seen' }}">
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="icon-shape {{ !$isSeen ? 'bg-warning-soft text-warning' : 'bg-seen-soft text-primary' }} mr-3">
                                            <i class="fas {{ !$isSeen ? 'fa-bell' : 'fa-folder-open' }}"></i>
                                        </div>

                                        <div>
                                            <div class="font-weight-bold text-dark">
                                                {{ $besoin->service }}
                                            </div>
                                            @if($besoin->type_demande)
                                                <small class="text-muted text-uppercase">
                                                    {{ $besoin->type_demande }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <div class="font-weight-bold text-dark">
                                        {{ $besoin->profil_recherche ?? $besoin->poste ?? 'Non précisé' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="text-success font-weight-bold">
                                        <i class="fas fa-check-double mr-1 small"></i>
                                        {{ $besoin->updated_at->format('d/m/Y') }}
                                    </div>
                                    <small class="text-muted">
                                        {{ $besoin->updated_at->format('H:i') }}
                                    </small>
                                </td>

                                <td>
                                    @if(!$isSeen)
                                        <span class="badge badge-warning px-3 py-2 rounded-pill">
                                            Nouveau
                                        </span>
                                    @else
                                        <span class="badge badge-success-soft px-3 py-2 rounded-pill font-weight-bold">
                                            Déjà consulté
                                        </span>

                                        @if($besoin->seen_at)
                                            <div class="small text-muted mt-1">
                                                le {{ $besoin->seen_at->format('d/m/Y H:i') }}
                                            </div>
                                        @endif
                                    @endif
                                </td>

                                <td class="text-right">
                                    <div class="d-flex justify-content-end align-items-center flex-wrap">
                                        <a href="{{ route('agent.besoins.show', $besoin->id) }}"
                                           class="btn {{ !$isSeen ? 'btn-outline-warning' : 'btn-outline-secondary' }} btn-sm rounded-lg mr-2 mb-1 mb-md-0">
                                            <i class="fas fa-eye mr-1"></i>
                                            {{ !$isSeen ? 'Consulter' : 'Reconsulter' }}
                                        </a>

                                        @if(strtolower($besoin->type_demande) === 'renouvellement' && $besoin->demande_stage_id)
                                            <form action="{{ route('agent.besoins.renouvelerStage', $besoin->id) }}"
                                                  method="POST"
                                                  style="display:inline;">
                                                @csrf
                                                <button type="submit"
                                                        class="btn btn-success btn-sm rounded-lg"
                                                        onclick="return confirm('Confirmer le renouvellement de ce stage ?')">
                                                    <i class="fas fa-redo-alt mr-1"></i> Renouveler
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    Aucun besoin validé disponible.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($besoinsValides->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $besoinsValides->appends(array_merge(request()->except('validated_page'), ['tab' => 'validated']))->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
:root {
    --brand-blue: #2563eb;
    --soft-blue: #eff6ff;
    --brand-warning: #f59e0b;
    --soft-warning: #fffbeb;
    --soft-seen: #f8fafc;
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

.rounded-xl {
    border-radius: 1.25rem;
}

.shadow-lg-soft {
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05);
}

.bg-warning-soft {
    background-color: var(--soft-warning);
}

.bg-seen-soft {
    background-color: var(--soft-blue);
}

.badge-success-soft {
    background: #dcfce7;
    color: #166534;
}

.btn-primary-brand {
    background: var(--brand-blue);
    color: #fff;
    border: none;
    transition: 0.3s;
}

.btn-primary-brand:hover {
    background: #1d4ed8;
    transform: translateY(-1px);
    color: #fff;
}

.icon-shape {
    width: 38px;
    height: 38px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    flex-shrink: 0;
}

.hover-row-light:hover {
    background-color: #fcfdfe;
}

.opacity-80 {
    opacity: 0.85;
}

.table-align-middle td {
    vertical-align: middle !important;
    padding: 1.2rem 0.75rem;
}

.modern-table thead th {
    border-top: none !important;
    border-bottom: 1px solid #edf2f7 !important;
    font-size: 0.78rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
}

.modern-table tbody tr td {
    border-top: 1px solid #f1f5f9;
}

.row-unseen {
    background: #fffdf3;
    border-left: 4px solid #f59e0b;
}

.row-seen {
    background: #ffffff;
    opacity: 0.93;
}

.notice-box {
    border-radius: 12px;
    background: #f8fafc;
}

.pagination {
    margin-bottom: 0;
}

.pagination .page-link {
    border-radius: 10px !important;
    margin: 0 3px;
    border: 1px solid #e2e8f0;
    color: #334155;
    box-shadow: none !important;
}

.pagination .page-item.active .page-link {
    background: var(--brand-blue);
    border-color: var(--brand-blue);
    color: #fff;
}
</style>

@endsection
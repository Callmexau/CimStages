@extends('layouts.adminlte')

@section('content')
<div class="container-fluid py-4 px-lg-4">

    {{-- HEADER DYNAMIQUE --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-dark mb-1 tracking-tight">Journal d’activité</h2>
            <p class="text-secondary mb-0">Traçabilité complète des événements système et utilisateur.</p>
        </div>
        <div class="d-flex gap-2">
            <span class="badge bg-white shadow-sm border text-dark px-3 py-2 rounded-pill">
                <i class="fas fa-history me-2 text-primary"></i>{{ $logs->total() }} événements
            </span>
        </div>
    </div>

    {{-- FILTRES MODERNISÉS --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4 filter-card">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.logs.index') }}">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-uppercase text-muted">Recherche libre</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                <i class="fas fa-search"></i>
                            </span>
                            <input type="text"
                                   name="search"
                                   class="form-control bg-light border-start-0 ps-0"
                                   placeholder="Description, cible..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Type d'action</label>
                        <select name="action" class="form-select bg-light border-0 custom-select">
                            <option value="">Toutes les actions</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ ucfirst($action) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-uppercase text-muted">Opérateur</label>
                        <select name="user_id" class="form-select bg-light border-0 custom-select">
                            <option value="">Tous les utilisateurs</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->prenom }} {{ strtoupper($user->nom) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm btn-filter">
                            Appliquer
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLEAU DE LOGS --}}
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 log-table">
                <thead class="bg-faded">
                    <tr>
                        <th class="px-4 border-0">Date & Heure</th>
                        <th class="border-0">Utilisateur</th>
                        <th class="border-0 text-center">Action</th>
                        <th class="border-0" style="width: 35%;">Détails</th>
                        <th class="border-0">Adresse IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex flex-column">
                                    <span class="text-dark fw-medium">{{ $log->created_at?->format('d M Y') }}</span>
                                    <span class="text-muted small">{{ $log->created_at?->format('H:i:s') }}</span>
                                </div>
                            </td>

                            <td>
                                @if($log->user)
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="fw-bold text-dark lh-1">
                                                {{ $log->user->prenom }} {{ $log->user->nom }}
                                            </div>
                                            <span class="text-muted extra-small">{{ $log->user->email }}</span>
                                        </div>
                                    </div>
                                @else
                                    <span class="badge bg-light text-muted fw-normal">
                                        <i class="fas fa-robot me-1"></i>Système
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                @php
                                    $actionClass = match(strtolower($log->action)) {
                                        'besoin_created',
                                        'user_created',
                                        'structure_created',
                                        'demande_validated',
                                        'stage_renewed'
                                            => 'bg-success-subtle text-success',

                                        'user_updated',
                                        'structure_updated'
                                            => 'bg-info-subtle text-info',

                                        'demande_rejected',
                                        'stage_ended',
                                        'user_deleted',
                                        'structure_deleted'
                                            => 'bg-danger-subtle text-danger',

                                        'user_password_reset'
                                            => 'bg-warning text-dark',

                                        default
                                            => 'bg-primary-subtle text-primary',
                                    };
                                @endphp

                                <span class="badge {{ $actionClass }} px-3 py-2 rounded-pill fw-bold text-uppercase small-8">
                                    {{ $log->action }}
                                </span>
                            </td>

                            <td>
                                <div class="fw-semibold text-dark mb-1">{{ $log->description }}</div>

                                <div class="d-flex gap-2 align-items-center flex-wrap">
                                    <span class="text-muted small">
                                        Cible:
                                        <span class="text-dark fw-medium">
                                            {{ $log->target_type ?? '—' }}
                                            @if($log->target_id)
                                                #{{ $log->target_id }}
                                            @endif
                                        </span>
                                    </span>

                                    @if($log->properties)
                                        <button class="btn btn-xs btn-outline-secondary rounded-pill px-2 py-0"
                                                onclick='console.log(@json($log->properties))'
                                                title="Voir JSON">
                                            JSON
                                        </button>
                                    @endif
                                </div>
                            </td>

                            <td>
                                <code class="bg-light px-2 py-1 rounded small text-secondary">
                                    <i class="fas fa-network-wired me-1 small"></i>{{ $log->ip_address ?? '—' }}
                                </code>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="opacity-25 mb-3" alt="">
                                <p class="text-muted fw-medium">Aucun événement ne correspond à vos filtres.</p>
                                <a href="{{ route('admin.logs.index') }}" class="btn btn-sm btn-link text-decoration-none">
                                    Réinitialiser
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-0 py-4 d-flex justify-content-center">
            {{ $logs->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    :root {
        --primary-subtle: #eef2ff;
        --success-subtle: #ecfdf5;
        --danger-subtle: #fef2f2;
        --info-subtle: #ecfeff;
    }

    .tracking-tight { letter-spacing: -0.025em; }
    .bg-faded { background-color: #f9fafb; }
    .extra-small { font-size: 0.75rem; }
    .small-8 { font-size: 0.8rem; }

    .filter-card { border: 1px solid rgba(0,0,0,0.05) !important; }

    .custom-select {
        height: 45px;
        font-weight: 500;
        cursor: pointer;
    }

    .btn-filter {
        height: 45px;
        transition: all 0.2s;
    }

    .btn-filter:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(13,110,253,0.15);
    }

    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 0.8rem;
    }

    .log-table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        font-weight: 700;
        color: #6b7280;
    }

    .log-table tbody tr {
        transition: background 0.15s ease;
    }

    .log-table tbody tr:hover {
        background-color: #f8fafc !important;
    }

    .bg-success-subtle { background-color: var(--success-subtle) !important; }
    .bg-danger-subtle { background-color: var(--danger-subtle) !important; }
    .bg-info-subtle { background-color: var(--info-subtle) !important; }
    .bg-primary-subtle { background-color: var(--primary-subtle) !important; }

    code {
        font-family: 'Fira Code', monospace;
        font-size: 0.8rem;
    }
</style>
@endpush
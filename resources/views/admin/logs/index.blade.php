@extends('layouts.adminlte')

@section('content')
<div class="container-fluid py-4">

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Journal d’activité</h2>
            <p class="text-muted mb-0">Suivi des actions importantes effectuées dans la plateforme.</p>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.logs.index') }}">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Recherche</label>
                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Rechercher dans la description..."
                               value="{{ request('search') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Action</label>
                        <select name="action" class="form-control">
                            <option value="">Toutes</option>
                            @foreach($actions as $action)
                                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                    {{ $action }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Utilisateur</label>
                        <select name="user_id" class="form-control">
                            <option value="">Tous</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ ($user->prenom ?? '') . ' ' . ($user->nom ?? '') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <div class="w-100 d-flex gap-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-search me-1"></i> Filtrer
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4">Date</th>
                        <th>Utilisateur</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Cible</th>
                        <th>IP</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="px-4 text-muted small">
                                {{ $log->created_at?->format('d/m/Y H:i') }}
                            </td>

                            <td>
                                @if($log->user)
                                    <div class="fw-semibold text-dark">
                                        {{ ($log->user->prenom ?? '') . ' ' . ($log->user->nom ?? '') }}
                                    </div>
                                    <div class="small text-muted">{{ $log->user->email }}</div>
                                @else
                                    <span class="text-muted">Utilisateur inconnu</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge bg-primary px-3 py-2 rounded-pill">
                                    {{ $log->action }}
                                </span>
                            </td>

                            <td>
                                <div class="fw-medium text-dark">{{ $log->description }}</div>

                                @if($log->properties)
                                    <div class="small text-muted mt-1">
                                        <code>{{ json_encode($log->properties, JSON_UNESCAPED_UNICODE) }}</code>
                                    </div>
                                @endif
                            </td>

                            <td class="text-muted small">
                                {{ $log->target_type ?? '—' }}
                                @if($log->target_id)
                                    #{{ $log->target_id }}
                                @endif
                            </td>

                            <td class="text-muted small">
                                {{ $log->ip_address ?? '—' }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                Aucun log d’activité disponible.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="card-footer bg-white border-top-0 py-3">
            {{ $logs->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
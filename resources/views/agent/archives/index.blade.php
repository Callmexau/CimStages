@extends('layouts.adminlte')

@section('content')
<div class="container-fluid py-4 archive-main-container">

    {{-- HEADER DYNAMIQUE --}}
    <div class="header-glass mb-4 p-4 rounded-4 shadow-sm border-0">
        <div class="row align-items-center">
            <div class="col-md-8">
                <span class="badge bg-primary-soft text-primary text-uppercase px-3 py-2 mb-2 fw-bold tracking-wider">
                    <i class="fas fa-history me-2"></i> Système d'Archivage
                </span>
                <h2 class="fw-extrabold text-dark tracking-tight mb-1">Dossiers Stagiaires Clôturés</h2>
                <p class="text-muted opacity-75 mb-0">Consultez l'historique de performance et les détails structurels des stages passés.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <div class="stat-luxury d-inline-block p-3 rounded-4 bg-white border shadow-sm">
                    <span class="d-block text-muted small fw-bold text-uppercase">Total Archives</span>
                    <span class="h3 fw-bold text-primary mb-0">{{ $archives->total() }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- ZONE DE RECHERCHE & FILTRES --}}
    <div class="card border-0 shadow-sm rounded-4 mb-4 filter-section">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('agent.archives.index') }}">
                <div class="row g-3">
                    <div class="col-lg-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Rechercher un profil</label>
                        <div class="input-group luxury-input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-search text-primary"></i></span>
                            <input type="text" name="search" class="form-control border-0 bg-light" placeholder="Nom, email ou poste..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Établissement</label>
                        <select name="universite" class="form-select border-0 bg-light luxury-select">
                            <option value="">Toutes les universités</option>
                            @foreach($universites as $universite)
                                <option value="{{ $universite }}" {{ request('universite') == $universite ? 'selected' : '' }}>{{ $universite }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6 col-lg-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Structure</label>
                        <select name="structure_id" class="form-select border-0 bg-light luxury-select">
                            <option value="">Toutes les structures</option>
                            @foreach($structures as $structure)
                                <option value="{{ $structure->id }}" {{ request('structure_id') == $structure->id ? 'selected' : '' }}>{{ $structure->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                        <a href="{{ route('agent.archives.index') }}" class="btn btn-light text-muted fw-bold px-4 rounded-3">Réinitialiser</a>
                        <button type="submit" class="btn btn-primary fw-bold px-4 rounded-3 shadow-sm">
                            <i class="fas fa-filter me-2"></i> Appliquer les filtres
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLEAU MODERNISÉ --}}
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table luxury-table align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Stagiaire</th>
                            <th>Université</th>
                            <th>Structure</th>
                            <th>Note /20</th>
                            <th>Statut</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($archives as $demande)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center">
                                        
                                        <div>
                                            <div class="fw-bold text-dark">{{ $demande->stagiaire->prenom ?? '-' }} {{ strtoupper($demande->stagiaire->nom ?? '-') }}</div>
                                            <div class="text-muted small"><i class="far fa-envelope me-1"></i>{{ $demande->stagiaire->email ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="fw-medium text-dark">{{ $demande->universite ?? '-' }}</span></td>
                                <td><span class="badge-soft-luxury">{{ $demande->structure->name ?? '-' }}</span></td>
                                <td>
                                    @if($demande->evaluation && !is_null($demande->evaluation->note_finale))
                                        @php 
                                            $n = $demande->evaluation->note_finale;
                                            $class = ($n >= 16) ? 'success' : (($n >= 12) ? 'primary' : 'warning');
                                        @endphp
                                        <div class="d-flex align-items-center">
                                            <div class="score-dot bg-{{ $class }} me-2"></div>
                                            <span class="fw-bold text-dark">{{ number_format($n, 2) }}</span>
                                        </div>
                                    @else
                                        <span class="text-muted opacity-50 small">Non noté</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="pill-status-done">
                                        <i class="fas fa-check-circle me-1"></i> Archivé
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('agent.demande.show', $demande->id) }}"
                                    class="btn btn-sm btn-light border shadow-sm rounded-pill px-3 fw-semibold"
                                    title="Consulter le dossier">
                                        <i class="fas fa-eye me-1"></i>
                                        Consulter
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="60" class="mb-3 opacity-25" alt="Empty">
                                    <p class="text-muted">Aucune archive ne correspond à vos critères.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white border-0 p-4">
            {{ $archives->links() }}
        </div>
    </div>
</div>
@endsection

@push('css')
<style>
    /* Global Styles */
    .archive-main-container {
        background-color: #fcfcfd;
        font-family: 'Inter', system-ui, -apple-system, sans-serif;
    }

    .fw-extrabold { font-weight: 800; }
    .tracking-tight { letter-spacing: -0.025em; }
    .tracking-wider { letter-spacing: 0.05em; }

    /* Header & Filters */
    .header-glass {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border: 1px solid rgba(0,0,0,0.05) !important;
    }

    .bg-primary-soft { background-color: rgba(37, 99, 235, 0.08); }

    .luxury-input-group .form-control, .luxury-select {
        height: 48px;
        font-weight: 500;
        transition: all 0.2s;
    }

    .luxury-input-group .form-control:focus, .luxury-select:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1) !important;
    }

    /* Luxury Table */
    .luxury-table thead th {
        background-color: #f8fafc;
        text-transform: uppercase;
        font-size: 0.7rem;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.1em;
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #edf2f7;
    }

    .luxury-table tbody tr {
        transition: all 0.2s;
        cursor: pointer;
    }

    .luxury-table tbody tr:hover {
        background-color: #fdfdfd;
        transform: scale(1.002);
        box-shadow: inset 4px 0 0 #2563eb;
    }

    .luxury-table td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #f1f5f9;
    }

    /* Avatars & Badges */
    .luxury-avatar {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: #1e293b;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
    }

    .badge-soft-luxury {
        background-color: #f1f5f9;
        color: #475569;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .pill-status-done {
        background-color: #ecfdf5;
        color: #059669;
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        border: 1px solid #d1fae5;
    }

    /* Scores */
    .score-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
    }

    /* Action Buttons */
    .btn-action-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #fff;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .btn-action-circle:hover {
        background-color: #2563eb;
        color: #fff;
        border-color: #2563eb;
        transform: translateY(-2px);
    }

    /* Custom Pagination */
    .pagination .page-link {
        border-radius: 8px !important;
        margin: 0 3px;
        border: none;
        color: #64748b;
        font-weight: 600;
    }

    .page-item.active .page-link {
        background-color: #2563eb;
        color: white;
    }
</style>
@endpush
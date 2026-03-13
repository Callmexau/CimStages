@extends('layouts.adminlte')

@section('content')
<div class="d-flex flex-column" style="height: calc(100vh - 70px); overflow: hidden; background-color: #f4f7f6;">
    
    <div class="flex-shrink-0 px-4 pt-3">
        <div class="d-flex align-items-center justify-content-between bg-white p-3 shadow-sm mb-3" style="border-radius: 12px; border-left: 4px solid #1a5a45;">
            <div class="d-flex align-items-center">
                <i class="fas fa-user-circle fa-2x text-cim-green mr-3"></i>
                <div>
                    <h5 class="mb-0 font-weight-bold">{{ Auth::user()->name ?? 'Responsable' }}</h5>
                    <small class="text-muted">{{ now()->translatedFormat('d M Y') }}</small>
                </div>
            </div>
            <div class="text-right">
                <span class="badge badge-pill bg-soft-success px-3" style="color: #1a5a45; background: #e8f5e9;">En ligne</span>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm mb-0" style="border-radius: 10px;">
                    <div class="card-body py-2 px-3">
                        <small class="text-uppercase text-muted font-weight-bold">Total</small>
                        <h4 class="mb-0 font-weight-bold">{{ $demandes->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm mb-0" style="border-radius: 10px;">
                    <div class="card-body py-2 px-3">
                        <small class="text-uppercase text-muted font-weight-bold">En attente</small>
                        <h4 class="mb-0 font-weight-bold text-warning">{{ $demandes->where('statut', 'en attente')->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="flex-grow-1 px-4 pb-3" style="min-height: 0;">
        <div class="card border-0 shadow-sm h-100 d-flex flex-column" style="border-radius: 15px; overflow: hidden;">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 font-weight-bold"><i class="fas fa-stream mr-2 text-cim-green"></i>Flux des demandes</h6>
            </div>

            <div class="table-responsive flex-grow-1" style="overflow-y: auto; background: white;">
                <table class="table table-hover align-middle mb-0">
                    <thead class="sticky-top bg-light" style="z-index: 10;">
                        <tr>
                            <th class="border-0 px-4 small font-weight-bold text-muted">CANDIDAT</th>
                            <th class="border-0 small font-weight-bold text-muted">DATE</th>
                            <th class="border-0 text-center small font-weight-bold text-muted">STATUT</th>
                            <th class="border-0 text-right px-4 small font-weight-bold text-muted">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($demandes as $demande)
                            <tr>
                                <td class="px-4 py-3 font-weight-bold text-dark">
                                    {{ $demande->etudiant->name ?? 'N/A' }}
                                </td>
                                <td class="py-3 text-muted small">{{ $demande->besoin->titre ?? 'Non spécifié' }}</td>
                                <td class="py-3 text-muted small">{{ $demande->created_at->format('d/m/y') }}</td>
                                <td class="text-center py-3">
                                    @php $isAttente = ($demande->statut == 'en attente'); @endphp
                                    <span class="badge {{ $isAttente ? 'badge-warning' : 'badge-success' }} px-2 py-1" style="font-size: 9px;">
                                        {{ strtoupper($demande->statut) }}
                                    </span>
                                </td>
                                <td class="text-right px-4 py-3">
                                    <a href="#" class="btn btn-xs btn-flat" style="background-color: #1a5a45; color: white;">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">Aucune demande reçue</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-top py-2 px-4 d-flex justify-content-between align-items-center">
                <small class="text-muted font-italic">Fin de liste | CIMBURKINA</small>
                <span class="badge badge-light border text-muted">{{ $demandes->count() }} lignes</span>
            </div>
        </div>
    </div>
</div>

<style>
    /* Force le conteneur AdminLTE à ne pas scroller */
    .content-wrapper { height: 100vh !important; overflow: hidden !important; }
    body { overflow: hidden !important; }

    /* Fixe l'en-tête du tableau pendant le scroll */
    .sticky-top {
        position: sticky;
        top: 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }

    /* Scrollbar élégante pour le tableau */
    .table-responsive::-webkit-scrollbar { width: 4px; }
    .table-responsive::-webkit-scrollbar-track { background: #f1f1f1; }
    .table-responsive::-webkit-scrollbar-thumb { background: #1a5a45; border-radius: 10px; }
    
    .bg-soft-success { background-color: rgba(26, 90, 69, 0.1); }
    .text-cim-green { color: #1a5a45; }
    .btn-xs { padding: 0.25rem 0.5rem; font-size: 0.75rem; }
</style>
@endsection
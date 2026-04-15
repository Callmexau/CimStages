@extends('layouts.adminlte')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 font-weight-bold text-dark mb-1" style="letter-spacing: -0.5px;">
                Stagiaires Actifs
            </h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 small">
                    <li class="breadcrumb-item text-muted">Gestion</li>
                    <li class="breadcrumb-item active text-primary font-weight-bold">Suivi en temps réel</li>
                </ol>
            </nav>
        </div>

        <a href="{{ route('responsable.stagiaires.index') }}"
           class="btn btn-white btn-sm px-3 shadow-sm border">
            <i class="fas fa-chevron-left mr-2 small"></i> Retour
        </a>
    </div>

    {{-- SEARCH BAR --}}
    <form method="GET" class="mb-4">
        <div class="input-group search-container shadow-sm">
            <div class="input-group-prepend">
                <span class="input-group-text bg-white border-right-0">
                    <i class="fas fa-search text-muted"></i>
                </span>
            </div>

            <input type="text"
                   name="search"
                   class="form-control border-left-0 pl-0"
                   placeholder="Rechercher un stagiaire..."
                   value="{{ request('search') }}"
                   onkeyup="this.form.submit()">

            @if(request('search'))
                <div class="input-group-append">
                    <a href="{{ url()->current() }}" class="btn btn-white border-left-0 text-muted">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            @endif
        </div>
    </form>

    {{-- CONTENT --}}
    @if($stagiairesEnCours->isEmpty())
        <div class="card border-0 shadow-sm text-center py-5 mt-4">
            <div class="py-4">
                <div class="empty-state-icon mb-3">
                    <i class="fas fa-user-friends fa-2x text-muted"></i>
                </div>
                <h5 class="font-weight-bold">Aucun stagiaire actif</h5>
                <p class="text-muted small">Aucune donnée ne correspond à votre recherche actuelle.</p>
            </div>
        </div>
    @else

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead>
                        <tr>
                            <th class="px-4 text-uppercase small font-weight-bold text-muted">#</th>
                            <th class="text-uppercase small font-weight-bold text-muted">Stagiaire</th>
                            <th class="text-uppercase small font-weight-bold text-muted text-center">Période</th>
                            <th class="text-uppercase small font-weight-bold text-muted text-center">Statut</th>
                            <th class="text-uppercase small font-weight-bold text-muted text-right px-4">Progression</th>
                            <th class="text-uppercase small font-weight-bold text-muted text-center">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($stagiairesEnCours as $demande)

                            @php
                                $stagiaire = $demande->stagiaire;

                                $debut = \Carbon\Carbon::parse($demande->updated_at);
                                $fin = (clone $debut)->addMonths(2);
                                $now = now();

                                $totalDays = $debut->diffInDays($fin) ?: 1;
                                $elapsedDays = $debut->diffInDays($now);

                                $progress = min(100, max(0, round(($elapsedDays / $totalDays) * 100)));

                                if ($now > $fin) {
                                    $status = 'Terminé';
                                    $badge = 'bg-soft-danger text-danger';
                                } elseif ($now->diffInDays($fin) <= 7) {
                                    $status = 'Bientôt fini';
                                    $badge = 'bg-soft-warning text-warning';
                                } else {
                                    $status = 'En cours';
                                    $badge = 'bg-soft-success text-success';
                                }
                            @endphp

                            <tr>
                                <td class="px-4 text-muted font-weight-light">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- STAGIAIRE --}}
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle-custom mr-3">
                                            {{ strtoupper(substr($stagiaire->prenom ?? 'S', 0, 1)) }}
                                        </div>

                                        <div>
                                            <div class="font-weight-bold text-dark mb-0">
                                                {{ $stagiaire->prenom }} {{ strtoupper($stagiaire->nom) }}
                                            </div>

                                            <div class="text-muted small">
                                                <i class="far fa-envelope mr-1"></i>{{ $stagiaire->email }}
                                            </div>

                                            @if(!empty($stagiaire->telephone))
                                                <div class="text-muted small">
                                                    <i class="fas fa-phone mr-1"></i>{{ $stagiaire->telephone }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                {{-- PERIODE --}}
                                <td class="text-center">
                                    <div class="small font-weight-bold text-dark">
                                        {{ $debut->format('d M Y') }}
                                    </div>
                                    <div class="small text-muted">
                                        au {{ $fin->format('d M Y') }}
                                    </div>
                                </td>

                                {{-- STATUS --}}
                                <td class="text-center">
                                    <span class="badge badge-pill {{ $badge }} py-2 px-3">
                                        <i class="fas fa-circle mr-1 small"></i> {{ $status }}
                                    </span>

                                    @if($now > $fin)
                                        <div class="text-danger x-small mt-1 font-italic">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Dépassement
                                        </div>
                                    @endif
                                </td>

                                {{-- PROGRESSION --}}
                                <td class="text-right px-4">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <div class="progress-wrapper mr-3">
                                            <div class="progress" style="height: 6px; width: 80px; border-radius: 10px;">
                                                <div class="progress-bar"
                                                     style="width: {{ $progress }}%; border-radius: 10px;">
                                                </div>
                                            </div>
                                        </div>

                                        <span class="small font-weight-bold text-dark" style="min-width: 35px;">
                                            {{ $progress }}%
                                        </span>
                                    </div>
                                </td>

                                {{-- ACTIONS --}}
                                <td class="text-center">

                                    @if($demande->statut === 'acceptee' && $now <= $fin)

                                        <form action="{{ route('responsable.stages.terminer', $demande->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Voulez-vous vraiment mettre fin à ce stage ?')">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-stop-circle mr-1"></i>
                                                Terminer
                                            </button>

                                        </form>

                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif

                                </td>

                            </tr>

                        @endforeach
                    </tbody>

                </table>
            </div>

            {{-- FOOTER PAGINATION --}}
            <div class="card-footer bg-white border-top-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="small text-muted">
                        Affichage de
                        <strong>{{ $stagiairesEnCours->firstItem() }}</strong>
                        à
                        <strong>{{ $stagiairesEnCours->lastItem() }}</strong>
                        sur
                        {{ $stagiairesEnCours->total() }}
                    </div>

                    <div>
                        {{ $stagiairesEnCours->withQueryString()->links() }}
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>

{{-- STYLE --}}
<style>
body { background-color: #f4f6f9; }

.search-container {
    max-width: 450px;
    border-radius: 8px;
    overflow: hidden;
}

.search-container .form-control:focus {
    box-shadow: none;
}

.avatar-circle-custom {
    width: 42px;
    height: 42px;
    background: linear-gradient(135deg, #1a2a6c, #2a48ad);
    color: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
}

.table tbody tr:hover {
    background-color: #f8faff;
}

.bg-soft-success { background-color: #e8f5e9; color: #2e7d32 !important; }
.bg-soft-warning { background-color: #fff8e1; color: #f57f17 !important; }
.bg-soft-danger { background-color: #ffebee; color: #c62828 !important; }

.progress-bar {
    background: linear-gradient(90deg, #1a2a6c, #b21f1f);
}

.x-small { font-size: 0.75rem; }
</style>

@endsection
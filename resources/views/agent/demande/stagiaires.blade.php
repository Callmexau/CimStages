@extends('layouts.adminlte')

@section('content')
<div class="container-fluid py-4">
    
    {{-- HEADER & RECHERCHE --}}
    <div class="row mb-4 align-items-center">
        <div class="col-md-6">
            <h1 class="font-weight-bold text-dark mb-1" style="letter-spacing: -1px; font-size: 1.8rem;">
                Stagiaires Actifs
            </h1>
            <p class="text-muted small mb-0">Gestion et suivi des talents en mission.</p>
        </div>
        <div class="col-md-6 mt-3 mt-md-0">
            <form method="GET" class="d-flex justify-content-md-end">
                <div class="input-group shadow-sm" style="max-width: 350px; border-radius: 8px; overflow: hidden;">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0 text-muted">
                            <i class="fas fa-search"></i>
                        </span>
                    </div>
                    <input type="text" name="search" class="form-control border-left-0 pl-0" 
                           placeholder="Nom, email, filière..." value="{{ request('search') }}" 
                           style="font-size: 0.9rem; height: 42px;">
                    <div class="input-group-append">
                        <button class="btn btn-dark px-3" type="submit" style="background-color: #1a2a6c; border: none;">Filtrer</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- TABLEAU DE BORD --}}
    <div class="card border-0 shadow-sm" style="border-radius: 12px; overflow: hidden;">
        @if($stagiairesEnCours->isEmpty())
            <div class="card-body text-center py-5">
                <i class="fas fa-user-slash fa-3x text-light mb-3"></i>
                <h5 class="text-muted font-weight-light">Aucun résultat trouvé.</h5>
                @if(request('search'))
                    <a href="{{ url()->current() }}" class="btn btn-link btn-sm text-primary">Effacer la recherche</a>
                @endif
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="border-0 px-4 py-3 text-uppercase small font-weight-bold text-muted">Identité</th>
                            <th class="border-0 py-3 text-uppercase small font-weight-bold text-muted">Parcours & École</th>
                            <th class="border-0 py-3 text-uppercase small font-weight-bold text-muted text-center">Structure</th>
                            <th class="border-0 py-3 text-uppercase small font-weight-bold text-muted text-center">Période de Stage</th>
                    </thead>
                    <tbody>
                        @foreach($stagiairesEnCours as $demande)
                            <tr class="align-middle" style="transition: 0.2s;">
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-mini mr-3 shadow-sm">
                                            {{ strtoupper(substr($demande->stagiaire->prenom, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-weight-bold text-dark mb-0">
                                                {{ $demande->stagiaire->prenom }} {{ strtoupper($demande->stagiaire->nom) }}
                                            </div>
                                            <div class="text-muted small">
                                                <i class="far fa-envelope mr-1"></i> {{ $demande->stagiaire->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="font-weight-bold text-dark small">{{ $demande->universite }}</div>
                                    <span class="badge badge-pill badge-light border text-muted px-2 py-1" style="font-size: 0.65rem;">
                                        {{ $demande->filiere }}
                                    </span>
                                </td>
                                <td class="py-3 text-center">
                                    <span class="badge badge-soft-emerald px-3 py-2">
                                        {{ $demande->structure->name ?? '-' }}
                                    </span>
                                </td>

                                <td class="py-3 text-center">
                                    @php
                                        // Date d’acceptation = updated_at
                                        $dateDebut = $demande->updated_at;
                                        $dateFin = $dateDebut ? $dateDebut->copy()->addMonths(2) : null;
                                    @endphp

                                    <div class="small font-weight-bold text-dark">
                                        {{ $dateDebut ? $dateDebut->format('d/m/Y') : '-' }}
                                    </div>
                                    <div class="small font-weight-bold text-dark">
                                        au {{ $dateFin ? $dateFin->format('d/m/Y') : '-' }}
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            {{-- PAGINATION CUSTOM --}}
            <div class="card-footer bg-white border-top-0 py-3">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="small text-muted">
                        Affichage de {{ $stagiairesEnCours->firstItem() }} à {{ $stagiairesEnCours->lastItem() }} sur {{ $stagiairesEnCours->total() }} talents
                    </div>
                    <div class="pagination-monarch">
                        {{ $stagiairesEnCours->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

<style>
    /* Esthétique Monarch Executive */
    .avatar-mini {
        width: 38px; height: 38px;
        background: #1a2a6c; color: white; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-weight: bold; font-size: 0.9rem;
    }
    
    .table thead th { letter-spacing: 0.5px; background-color: #fbfbfc; }
    .table tbody tr:hover { background-color: #fbfbfc !important; }

    .badge-soft-emerald {
        background-color: #e9f5f1;
        color: #1a5a45;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.75rem;
        text-transform: uppercase;
    }

    /* Style Pagination pour éviter le look énorme par défaut */
    .pagination-monarch .pagination { margin-bottom: 0; }
    .pagination-monarch .page-link { border: none; color: #1a2a6c; font-weight: 600; padding: 0.5rem 0.85rem; }
    .pagination-monarch .page-item.active .page-link { background-color: #1a2a6c; border-radius: 6px; color: white; }

    .input-group-text { border-radius: 8px 0 0 8px; }
    .form-control:focus { box-shadow: none; border-color: #ced4da; }
</style>
@endsection
@extends('layouts.adminlte')

@section('title', 'EJ | Répertoire Structures')

@section('content')
<section class="content pt-4">
    <div class="container-fluid">
        
        <div class="d-flex justify-content-between align-items-end mb-4 pb-2 border-bottom-premium">
            <div>
                <h1 class="font-weight-black text-dark mb-0 tracking-tighter">Structures</h1>
                <p class="text-muted small text-uppercase font-weight-bold letter-spacing-1 mb-0">Organisation & Hiérarchie du système</p>
            </div>
            <a href="{{ route('admin.structures.create') }}" class="btn btn-indigo-premium rounded-pill px-4 shadow-sm">
                <i class="fas fa-plus-circle mr-2"></i> Nouvelle Structure
            </a>
        </div>

        @if(session('success'))
            <div class="custom-alert-success shadow-sm mb-4">
                <div class="icon-wrap"><i class="fas fa-check"></i></div>
                <div class="message">{{ session('success') }}</div>
                <button type="button" class="close ml-auto" data-dismiss="alert">&times;</button>
            </div>
        @endif

        <div class="card border-0 shadow-soft-lg" style="border-radius: 16px; overflow: hidden;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 premium-structured-table">
                        <thead>
                            <tr>
                                <th class="pl-4 py-3">IDENTIFICATION</th>
                                <th class="py-3">SIGLE</th>
                                <th class="py-3" style="width: 45%;">DESCRIPTION</th>
                                <th class="pr-4 py-3 text-right">GESTION</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($structures as $structure)
                            <tr class="zebra-row">
                                <td class="pl-4 align-middle border-start-highlight">
                                    <div class="d-flex align-items-center">
                                        <div class="structure-icon mr-3">
                                            <i class="fas fa-sitemap"></i>
                                        </div>
                                        <span class="font-weight-bold text-dark h6 mb-0">{{ $structure->name }}</span>
                                    </div>
                                </td>

                                <td class="align-middle">
                                    <span class="badge badge-sigle">{{ $structure->abbreviation }}</span>
                                </td>

                                <td class="align-middle">
                                    <p class="text-muted small mb-0 text-truncate-2" title="{{ $structure->description }}">
                                        {{ $structure->description ?: 'Aucune description fournie.' }}
                                    </p>
                                </td>

                                <td class="pr-4 align-middle text-right">
                                    <div class="btn-group-premium border rounded-pill p-1 bg-white shadow-sm">
                                        <a href="{{ route('admin.structures.edit', $structure->id) }}" class="btn-action edit" title="Modifier">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                        
                                        <form action="{{ route('admin.structures.destroy', $structure->id) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn-action delete" onclick="return confirm('Supprimer cette structure ?')" title="Supprimer">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-folder-open fa-3x mb-3 opacity-20"></i>
                                        <p>Aucune structure enregistrée.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* Global Brand Setup */
    .font-weight-black { font-weight: 900; }
    .tracking-tighter { letter-spacing: -1px; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .border-bottom-premium { border-bottom: 3px solid #1e293b !important; }

    /* Table & Zebra Style (Lisibilité Maximale) */
    .premium-structured-table thead th {
        background: #f8fafc;
        border-bottom: 2px solid #e2e8f0;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
    }

    .zebra-row { transition: all 0.2s; border-bottom: 1px solid #f1f5f9; }
    .zebra-row:nth-child(even) { background-color: #fcfdfe; } /* L'alternance */
    .zebra-row:hover { background-color: #f1f5f9 !important; }

    /* Indicateur de début de ligne au survol */
    .border-start-highlight { border-left: 4px solid transparent; }
    .zebra-row:hover .border-start-highlight { border-left: 4px solid #4f46e5; }

    /* Elements UI */
    .structure-icon {
        width: 36px; height: 36px; background: #e0e7ff; color: #4f46e5;
        border-radius: 10px; display: flex; align-items: center; justify-content: center;
    }

    .badge-sigle {
        background: #334155; color: #fff; padding: 6px 12px;
        border-radius: 6px; font-weight: 700; font-size: 0.75rem;
    }

    .text-truncate-2 {
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
        overflow: hidden; line-height: 1.4;
    }

    /* Action Buttons */
    .btn-action {
        width: 32px; height: 32px; border-radius: 50%;
        display: inline-flex; align-items: center; justify-content: center;
        border: none; background: transparent; transition: all 0.2s;
    }
    .btn-action.edit { color: #4f46e5; }
    .btn-action.delete { color: #ef4444; }
    .btn-action:hover { background: #f1f5f9; transform: scale(1.1); }

    .btn-indigo-premium { background: #4f46e5; color: white; font-weight: 700; border: none; }
    .btn-indigo-premium:hover { background: #4338ca; color: white; transform: translateY(-1px); }

    /* Alert Style */
    .custom-alert-success {
        background: #ecfdf5; border-left: 5px solid #10b981;
        padding: 12px 20px; border-radius: 10px; display: flex; align-items: center;
    }
    .custom-alert-success .icon-wrap { color: #10b981; margin-right: 15px; font-size: 1.2rem; }
    .custom-alert-success .message { color: #065f46; font-weight: 700; }

    .shadow-soft-lg { box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05); }
</style>
@endsection
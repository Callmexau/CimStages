@extends('layouts.adminlte')

@section('title', 'EJ | Gestion Utilisateurs')

@section('content')
@php use Illuminate\Support\Str; @endphp

<section class="content pt-4" style="background: #f4f7f6; min-height: 100vh;">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom-dark">
            <div>
                <h1 class="font-weight-black text-dark mb-0" style="letter-spacing: -1px;">Gestion des Utilisateurs</h1>
                <p class="text-muted mb-0 font-weight-bold uppercase-xs">Administration système & accès</p>
            </div>
            <a href="{{ route('admin.users.create') }}" class="btn btn-indigo shadow-sm px-4">
                <i class="fas fa-plus mr-2"></i> Ajouter un utilisateur
            </a>
        </div>

        <div class="card shadow-soft border-0" style="border-radius: 15px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 structured-table">
                        <thead>
                            <tr>
                                <th class="border-top-0 border-bottom-strong pl-4">#ID</th>
                                <th class="border-top-0 border-bottom-strong">UTILISATEUR</th>
                                <th class="border-top-0 border-bottom-strong">CONTACT</th>
                                <th class="border-top-0 border-bottom-strong">RÔLE / UNITÉ</th>
                                <th class="border-top-0 border-bottom-strong text-center">STATUT</th>
                                <th class="border-top-0 border-bottom-strong text-right pr-4">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                            <tr class="aligned-row">
                                <td class="pl-4 align-middle id-column font-weight-bold text-primary">
                                    {{ str_pad($user->id, 3, '0', STR_PAD_LEFT) }}
                                </td>

                                <td class="align-middle py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sq mr-3">{{ strtoupper(substr($user->nom ?? $user->name, 0, 1)) }}</div>
                                        <div>
                                            <span class="d-block font-weight-bold text-dark">{{ $user->nom ?? $user->name }} {{ $user->prenom }}</span>
                                            <small class="text-muted text-uppercase font-weight-bold" style="font-size: 0.65rem;">Interne</small>
                                        </div>
                                    </div>
                                </td>

                                <td class="align-middle">
                                    <span class="text-dark font-weight-medium small"><i class="far fa-envelope text-muted mr-2"></i>{{ $user->email }}</span>
                                </td>

                                <td class="align-middle">
                                    <span class="badge badge-indigo-soft mb-1">{{ $user->role ? ucfirst($user->role->name) : 'Collaborateur' }}</span>
                                    <div class="small text-muted font-weight-bold">{{ $user->structure ? $user->structure->name : '-' }}</div>
                                </td>

                                <td class="align-middle text-center">
                                    @if($user->is_active)
                                        <span class="badge-status success">ACTIF</span>
                                    @else
                                        <span class="badge-status disabled">INACTIF</span>
                                    @endif
                                </td>

                                <td class="align-middle text-right pr-4 action-cell">
                                    <div class="btn-group shadow-sm border rounded overflow-hidden bg-white">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-white btn-sm border-0" title="Modifier">
                                            <i class="fas fa-edit text-primary"></i>
                                        </a>
                                        <form action="{{ route('admin.users.reset-password', $user->id) }}" method="POST" class="d-inline border-left">
                                            @csrf
                                            <button class="btn btn-white btn-sm border-0" title="Mot de passe">
                                                <i class="fas fa-key text-warning"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline border-left">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-white btn-sm border-0" onclick="return confirm('Supprimer ?')" title="Supprimer">
                                                <i class="fas fa-trash-alt text-danger"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">Aucun utilisateur trouvé.</td>
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
    /* Structure & Grille */
    .font-weight-black { font-weight: 900; }
    .border-bottom-dark { border-bottom: 2px solid #1a1a1a !important; }
    .uppercase-xs { font-size: 0.7rem; letter-spacing: 1px; }

    /* LE SECRET DE LA LISIBILITÉ : Bordures et Zebra */
    .structured-table { border-collapse: separate; border-spacing: 0; }
    
    /* Bordure sous le header */
    .border-bottom-strong { border-bottom: 2px solid #dee2e6 !important; color: #495057; font-weight: 800; font-size: 0.75rem; text-transform: uppercase; }

    /* Bordures entre les lignes bien visibles */
    .aligned-row { border-bottom: 1px solid #e9ecef; }
    .aligned-row:last-child { border-bottom: none; }
    
    /* Alternance de couleur subtile (Zebra) */
    .aligned-row:nth-child(even) { background-color: #fbfcfd; }
    .aligned-row:hover { background-color: #f1f4f9 !important; transition: 0.2s; }

    /* Colonne ID mise en avant */
    .id-column { background-color: #f8f9fa; border-right: 1px solid #eee; width: 60px; }

    /* Composants UI */
    .btn-indigo { background: #4f46e5; color: white; border-radius: 8px; font-weight: 700; }
    .btn-indigo:hover { background: #4338ca; color: white; }

    .avatar-sq { width: 38px; height: 38px; background: #334155; color: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem; }

    .badge-indigo-soft { background: #e0e7ff; color: #4338ca; font-weight: 800; font-size: 0.7rem; padding: 4px 8px; }

    /* Status Badges "Solid" pour lecture instantanée */
    .badge-status { padding: 5px 10px; border-radius: 4px; font-size: 0.65rem; font-weight: 900; display: inline-block; min-width: 70px; }
    .badge-status.success { background: #10b981; color: white; }
    .badge-status.disabled { background: #94a3b8; color: white; }

    /* Séparation visuelle pour les actions */
    .action-cell { border-left: 1px dashed #dee2e6; }
    
    .shadow-soft { box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
    .border-left { border-left: 1px solid #dee2e6 !important; }
</style>

@if(session('success') && Str::contains(session('success'), 'Mot de passe temporaire'))
@php
    $message = session('success');
@endphp

<div id="passwordModal" class="elite-overlay">
    <div class="elite-modal shadow-2xl">
        
        <div class="mb-5">
            <div class="brand-accent mb-3"></div>
            <h2 class="font-weight-black text-dark tracking-tight mb-1" style="font-size: 1.4rem;">Accès de Sécurité</h2>
            <p class="text-muted small font-weight-bold text-uppercase tracking-widest">Identifiant Temporaire Généré</p>
        </div>

        <div class="code-container mb-4">
            <span id="tempPassword" class="password-text">{{ $message }}</span>
        </div>

        <div class="security-note mb-5">
            <i class="fas fa-lock-alt mr-2"></i>
            <span>Cette information est unique et sera détruite après fermeture.</span>
        </div>

        <button onclick="closeEliteModal()" class="btn-confirm-elite">
            J'AI NOTÉ LES ACCÈS
        </button>
    </div>
</div>

<script>
    function copyToClipboard() {
        const password = document.getElementById('tempPassword').innerText;
        navigator.clipboard.writeText(password);
        
        const btn = document.querySelector('.copy-trigger');
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.classList.add('copied');
        
        setTimeout(() => {
            btn.innerHTML = '<i class="far fa-copy"></i>';
            btn.classList.remove('copied');
        }, 2000);
    }

    function closeEliteModal() {
        const modal = document.getElementById('passwordModal');
        modal.style.opacity = '0';
        modal.style.transform = 'scale(0.98)';
        setTimeout(() => modal.remove(), 300);
    }
</script>

<style>
    /* Overlay EJ Brand - Sobriété absolue */
    .elite-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255, 255, 255, 0.95); /* Fond blanc quasi opaque pour la clarté */
        backdrop-filter: blur(10px);
        display: flex; align-items: center; justify-content: center;
        z-index: 10000;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .elite-modal {
        background: #ffffff;
        padding: 50px 60px;
        border-radius: 4px; /* Angles droits légèrement adoucis pour le sérieux */
        width: 520px;
        border: 1px solid #e2e8f0;
        text-align: left; /* Alignement à gauche pour plus de professionnalisme */
    }

    /* Ligne de marque Jackson */
    .brand-accent {
        width: 40px; height: 4px; background: #0f172a;
    }

    /* Container du mot de passe */
    .code-container {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        padding: 20px 25px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-radius: 8px;
    }

    .password-text {
        font-family: 'Monaco', 'Consolas', monospace;
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: 2px;
    }

    .copy-trigger {
        background: none; border: none; color: #94a3b8;
        font-size: 1.2rem; cursor: pointer; transition: 0.2s;
        padding: 10px;
    }
    .copy-trigger:hover { color: #4f46e5; transform: scale(1.1); }
    .copy-trigger.copied { color: #10b981; }

    /* Typographie & Alert */
    .tracking-widest { letter-spacing: 2px; font-size: 0.65rem; }
    
    .security-note {
        font-size: 0.75rem; color: #64748b;
        font-weight: 500; display: flex; align-items: center;
    }

    /* Bouton d'action Jackson */
    .btn-confirm-elite {
        width: 100%;
        background: #0f172a; /* Noir EJ */
        color: #ffffff;
        border: none;
        padding: 18px;
        font-weight: 800;
        font-size: 0.75rem;
        letter-spacing: 2px;
        cursor: pointer;
        transition: all 0.3s;
    }
    .btn-confirm-elite:hover {
        background: #334155;
        letter-spacing: 3px;
    }

    .shadow-2xl { box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1); }
</style>
@endif
@endsection
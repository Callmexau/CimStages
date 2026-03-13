@extends('layouts.adminlte')

@section('title', 'EJ | Édition Express')

@section('content')
<section class="content pt-3">
    <div class="container-fluid px-md-4">
        
        <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-3 shadow-sm rounded-xl border">
            <div class="d-flex align-items-center">
                <div class="mini-avatar mr-3">{{ strtoupper(substr($user->nom ?? $user->name, 0, 1)) }}</div>
                <div>
                    <h5 class="font-weight-black mb-0 text-dark">Modifier : {{ $user->nom }} {{ $user->prenom }}</h5>
                    <span class="badge badge-soft-primary small">ID #{{ $user->id }}</span>
                </div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm rounded-pill px-3 mr-2 border">
                    <i class="fas fa-times mr-1"></i> Annuler
                </a>
                <button form="edit-form" type="submit" class="btn btn-dark-premium btn-sm rounded-pill px-4 shadow-sm">
                    <i class="fas fa-save mr-1"></i> Sauvegarder
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-xl overflow-hidden">
            <div class="card-body bg-white p-4">
                <form id="edit-form" method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-4 border-right-light">
                            <h6 class="section-title"><i class="fas fa-id-card mr-2 text-primary"></i> Identité</h6>
                            <hr class="mt-1 mb-3">
                            
                            <div class="form-group mb-3">
                                <label class="label-xs">Nom de famille</label>
                                <input type="text" name="nom" class="form-control minimal-input @error('nom') is-invalid @enderror" 
                                       value="{{ old('nom', $user->nom) }}" required placeholder="Nom">
                                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="label-xs">Prénom</label>
                                <input type="text" name="prenom" class="form-control minimal-input @error('prenom') is-invalid @enderror" 
                                       value="{{ old('prenom', $user->prenom) }}" required placeholder="Prénom">
                                @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="col-md-4 border-right-light px-md-4">
                            <h6 class="section-title"><i class="fas fa-at mr-2 text-primary"></i> Contact</h6>
                            <hr class="mt-1 mb-3">

                            <div class="form-group mb-0">
                                <label class="label-xs">Email Professionnel</label>
                                <div class="input-group">
                                    <input type="email" name="email" class="form-control minimal-input @error('email') is-invalid @enderror" 
                                           value="{{ old('email', $user->email) }}" required placeholder="email@exemple.com">
                                </div>
                                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                <p class="text-muted mt-2 x-small"><i class="fas fa-info-circle"></i> Utilisé pour la connexion.</p>
                            </div>
                        </div>

                        <div class="col-md-4 pl-md-4">
                            <h6 class="section-title"><i class="fas fa-shield-alt mr-2 text-primary"></i> Autorisations</h6>
                            <hr class="mt-1 mb-3">

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class="label-xs">Rôle Système</label>
                                        <select name="role" class="form-control minimal-input border-indigo" required>
                                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="agent" {{ old('role', $user->role) == 'agent' ? 'selected' : '' }}>Agent</option>
                                            <option value="responsable" {{ old('role', $user->role) == 'responsable' ? 'selected' : '' }}>Responsable</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group mb-3">
                                        <label class="label-xs">État</label>
                                        <select name="is_active" class="form-control minimal-input" required>
                                            <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>Actif</option>
                                            <option value="0" {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>Suspendu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="alert alert-light border-0 py-2 x-small text-muted mb-0">
                                <i class="fas fa-lock mr-1"></i> Les modifications prennent effet immédiatement.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    /* Global Brand Tweaks */
    .font-weight-black { font-weight: 900; }
    .rounded-xl { border-radius: 12px !important; }
    
    /* Toolbar Elements */
    .mini-avatar { 
        width: 35px; height: 35px; background: #1e293b; color: white; 
        border-radius: 8px; display: flex; align-items: center; 
        justify-content: center; font-weight: 800; font-size: 0.9rem;
    }
    .badge-soft-primary { background: #e0e7ff; color: #4338ca; font-weight: 800; font-size: 0.65rem; }

    /* Form Design - Compact */
    .section-title { font-size: 0.8rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: #475569; margin-bottom: 0; }
    .label-xs { font-size: 0.65rem; font-weight: 800; text-transform: uppercase; color: #94a3b8; margin-bottom: 4px; }
    .x-small { font-size: 0.7rem; }

    .minimal-input {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 8px 12px;
        height: auto;
        transition: all 0.2s ease;
    }
    .minimal-input:focus {
        background: #fff;
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        outline: none;
    }
    .border-indigo { border-left: 3px solid #4f46e5 !important; }

    /* Layout Separators */
    .border-right-light { border-right: 1px solid #f1f5f9; }

    /* Buttons Premium */
    .btn-dark-premium { background: #0f172a; color: white; border: none; font-weight: 600; }
    .btn-dark-premium:hover { background: #1e293b; color: white; }

    /* Removes unnecessary spacing in AdminLTE content wrapper */
    .content-wrapper { background: #f4f7f6 !important; }
</style>
@endsection
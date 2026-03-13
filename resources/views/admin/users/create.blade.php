@extends('layouts.adminlte')

@section('title', 'Ajouter un utilisateur')

@section('content')
<section class="content pt-3">
    <div class="container-fluid px-md-4">
        
        <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-3 shadow-sm rounded-xl border-left-premium">
            <div>
                <h5 class="font-weight-black mb-0 text-dark text-uppercase tracking-tighter">
                    <i class="fas fa-user-plus mr-2 text-primary"></i>Ajouter un utilisateur
            </div>
            <div class="action-buttons">
                <a href="{{ route('admin.users.index') }}" class="btn btn-link text-muted btn-sm mr-3 font-weight-bold">
                    Annuler
                </a>
                <button form="create-form" type="submit" class="btn btn-indigo-premium btn-sm rounded-pill px-4 shadow-sm">
                    <i class="fas fa-check mr-1"></i> Finaliser la création
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-xl">
            <div class="card-body p-4">
                <form id="create-form" method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 border-right">
                            <h6 class="label-section"><i class="fas fa-user-circle mr-2"></i>Identité</h6>
                            <hr class="my-3">
                            
                            <div class="form-group mb-3">
                                <label class="label-xs">Nom</label>
                                <input type="text" name="nom" class="form-control premium-input @error('nom') is-invalid @enderror" 
                                       value="{{ old('nom') }}" required placeholder="Ex: Keita">
                                @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group mb-3">
                                <label class="label-xs">Prénom</label>
                                <input type="text" name="prenom" class="form-control premium-input @error('prenom') is-invalid @enderror" 
                                       value="{{ old('prenom') }}" required placeholder="Ex: Ben">
                                @error('prenom')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="label-xs">Sexe</label>
                                <div class="d-flex gap-2">
                                    <select name="sexe" class="form-control premium-input" required>
                                        <option value="">-- Choisir --</option>
                                        <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                                        <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 border-right px-md-4">
                            <h6 class="label-section"><i class="fas fa-envelope-open-text mr-2"></i>Communication</h6>
                            <hr class="my-3">

                            <div class="form-group mb-4">
                                <label class="label-xs">Email Professionnel</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-white border-right-0" style="border-radius: 10px 0 0 10px;"><i class="fas fa-at text-muted"></i></span>
                                    </div>
                                    <input type="email" name="email" class="form-control premium-input @error('email') is-invalid @enderror" 
                                           style="border-radius: 0 10px 10px 0;"
                                           value="{{ old('email') }}" required placeholder="nom.prenom@entreprise.com">
                                </div>
                                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>

                            <div class="alert alert-soft-info border-0 rounded-lg small">
                                <i class="fas fa-magic mr-1"></i> Un mot de passe temporaire sera généré automatiquement.
                            </div>
                        </div>

                        <div class="col-md-4 pl-md-4">
                            <h6 class="label-section"><i class="fas fa-sitemap mr-2"></i>Affectation</h6>
                            <hr class="my-3">

                            <div class="form-group mb-3">
                                <label class="label-xs">Rôle de l'utilisateur</label>
                                <select name="role_id" class="form-control premium-input border-left-primary" required>
                                    <option value="">-- Sélectionner un rôle --</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group mb-0">
                                <label class="label-xs">Structure / Département</label>
                                <select name="structure_id" id="structure_id" class="form-control premium-input" required>
                                    <option value="">-- Aucune structure --</option>
                                    @foreach(\App\Models\Structure::all() as $structure)
                                        <option value="{{ $structure->id }}" {{ old('structure_id') == $structure->id ? 'selected' : '' }}>
                                            {{ $structure->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('structure_id') <div class="text-danger x-small mt-1">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    /* Global Styles */
    .font-weight-black { font-weight: 900; }
    .tracking-tighter { letter-spacing: -0.5px; }
    .rounded-xl { border-radius: 15px !important; }
    .border-left-premium { border-left: 5px solid #4f46e5 !important; }

    /* Form UI */
    .label-section { font-size: 0.85rem; font-weight: 800; color: #1e293b; text-transform: uppercase; margin-bottom: 0; }
    .label-xs { font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 5px; display: block; }
    
    .premium-input {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 10px 15px;
        font-weight: 600;
        color: #334155;
        height: auto;
        transition: all 0.2s;
    }
    .premium-input:focus {
        background: #fff;
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
    }
    .border-left-primary { border-left: 4px solid #4f46e5 !important; }

    /* Buttons */
    .btn-indigo-premium { background: #4f46e5; color: white; border: none; font-weight: 700; transition: 0.3s; }
    .btn-indigo-premium:hover { background: #4338ca; transform: translateY(-1px); box-shadow: 0 5px 15px rgba(79, 70, 229, 0.3); color: white; }

    /* Utilities */
    .alert-soft-info { background: #f0f7ff; color: #0369a1; font-weight: 500; }
    .x-small { font-size: 0.75rem; }
    .gap-2 { gap: 0.5rem; }
</style>
@endsection
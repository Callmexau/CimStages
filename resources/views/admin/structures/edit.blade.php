@extends('layouts.adminlte')

@section('title', 'EJ | Éditer Structure')

@section('content')
<section class="content pt-3">
    <div class="container-fluid px-md-4">
        
        <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-3 shadow-sm rounded-xl border-left-premium">
            <div class="d-flex align-items-center">
                <div class="structure-avatar-mini mr-3">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h5 class="font-weight-black mb-0 text-dark">Modifier une Structure</h5>
                    <span class="text-muted small">ID unique : #STR-{{ $structure->id }}</span>
                </div>
            </div>
            <div class="action-buttons">
                <a href="{{ route('admin.structures.index') }}" class="btn btn-link text-muted btn-sm mr-3 font-weight-bold">
                    Annuler
                </a>
                <button form="edit-structure-form" type="submit" class="btn btn-dark-premium btn-sm rounded-pill px-4 shadow-sm">
                    <i class="fas fa-save mr-1"></i> Mettre à jour
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-xl">
            <div class="card-body p-4">
                <form id="edit-structure-form" method="POST" action="{{ route('admin.structures.update', $structure->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-5 border-right">
                            <h6 class="label-section mb-3">Informations de base</h6>
                            
                            <div class="form-group mb-4">
                                <label class="label-xs">Nom complet de l'entité</label>
                                <input type="text" name="name" 
                                       class="form-control premium-input @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $structure->name) }}" 
                                       required placeholder="Ex: Direction des Ressources Humaines">
                                @error('name') <div class="invalid-feedback font-weight-bold">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="label-xs">Sigle / Abréviation</label>
                                <div class="input-group">
                                    <input type="text" name="abbreviation" 
                                           class="form-control premium-input @error('abbreviation') is-invalid @enderror" 
                                           value="{{ old('abbreviation', $structure->abbreviation) }}"
                                           placeholder="Ex: DRH">
                                </div>
                                @error('abbreviation') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                                <p class="text-muted mt-2 x-small font-italic">Sera utilisé pour les affichages compacts dans les tableaux.</p>
                            </div>
                        </div>

                        <div class="col-md-7 pl-md-4">
                            <h6 class="label-section mb-3">Rôle & Mission</h6>
                            
                            <div class="form-group mb-0">
                                <label class="label-xs">Description détaillée</label>
                                <textarea name="description" 
                                          class="form-control premium-input @error('description') is-invalid @enderror" 
                                          rows="5" 
                                          style="resize: none;"
                                          placeholder="Décrivez brièvement les responsabilités de cette structure...">{{ old('description', $structure->description) }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mt-4 p-3 rounded-lg bg-light d-flex align-items-center">
                                <i class="fas fa-info-circle text-primary mr-3 fa-lg"></i>
                                <span class="small text-dark font-weight-medium">
                                    Cette structure est actuellement rattachée à <strong>{{ $structure->users_count ?? 0 }} utilisateur(s)</strong>.
                                </span>
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
    .rounded-xl { border-radius: 12px !important; }
    .border-left-premium { border-left: 5px solid #10b981 !important; } /* Vert Succès pour la modif */

    /* UI Components */
    .structure-avatar-mini {
        width: 40px; height: 40px; background: #f0fdf4; color: #10b981;
        border-radius: 10px; display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem; border: 1px solid #dcfce7;
    }

    .label-section { font-size: 0.85rem; font-weight: 800; color: #1e293b; text-transform: uppercase; letter-spacing: 0.5px; }
    .label-xs { font-size: 0.7rem; font-weight: 800; color: #64748b; text-transform: uppercase; margin-bottom: 6px; display: block; }
    
    .premium-input {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 15px;
        font-weight: 600;
        color: #334155;
        transition: all 0.2s;
    }
    .premium-input:focus {
        background: #fff;
        border-color: #10b981;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
    }

    /* Buttons */
    .btn-dark-premium { background: #1e293b; color: white; border: none; font-weight: 700; transition: 0.3s; }
    .btn-dark-premium:hover { background: #0f172a; transform: translateY(-1px); color: white; }

    .x-small { font-size: 0.75rem; }
    .bg-light { background-color: #f1f5f9 !important; }
</style>
@endsection
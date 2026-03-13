@extends('layouts.adminlte')

@section('title', 'EJ | Nouvelle Structure')

@section('content')
<section class="content pt-3">
    <div class="container-fluid px-md-4">
        
        <div class="d-flex justify-content-between align-items-center mb-3 bg-white p-3 shadow-sm rounded-xl border-left-indigo">
            <div>
                <h5 class="font-weight-black mb-0 text-dark text-uppercase">
                    <i class="fas fa-layer-group mr-2 text-primary"></i>Ajouter une Structure
                </h5>
            </div>
            <div class="action-buttons">
                <a href="{{ route('admin.structures.index') }}" class="btn btn-link text-muted btn-sm mr-3 font-weight-bold">
                    Annuler
                </a>
                <button form="create-structure-form" type="submit" class="btn btn-indigo-premium btn-sm rounded-pill px-4 shadow-sm">
                    <i class="fas fa-plus-circle mr-1"></i> Créer la structure
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-xl overflow-hidden">
            <div class="card-body p-4">
                <form id="create-structure-form" method="POST" action="{{ route('admin.structures.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 border-right">
                            <h6 class="label-section mb-4">Identification</h6>
                            
                            <div class="form-group mb-4">
                                <label class="label-xs">Nom de la structure <span class="text-danger">*</span></label>
                                <input type="text" name="name" 
                                       class="form-control premium-input @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       required placeholder="Ex: Direction de la Communication">
                                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="form-group mb-0">
                                <label class="label-xs">Sigle / Code interne</label>
                                <input type="text" name="abbreviation" 
                                       class="form-control premium-input @error('abbreviation') is-invalid @enderror" 
                                       value="{{ old('abbreviation') }}"
                                       placeholder="Ex: DIRCOM">
                                @error('abbreviation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <small class="text-muted d-block mt-2"><i class="fas fa-info-circle mr-1"></i> Utile pour les exports et filtres rapides.</small>
                            </div>
                        </div>

                        <div class="col-md-6 pl-md-4">
                            <h6 class="label-section mb-4">Détails complémentaires</h6>
                            
                            <div class="form-group mb-0">
                                <label class="label-xs">Description de l'activité</label>
                                <textarea name="description" 
                                          class="form-control premium-input @error('description') is-invalid @enderror" 
                                          rows="5" 
                                          style="resize: none;"
                                          placeholder="Quelles sont les missions de cette entité ?">{{ old('description') }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mt-4 alert alert-soft-indigo border-0 rounded-lg small mb-0">
                                <i class="fas fa-shield-alt mr-2 text-primary"></i> Une fois créée, cette structure pourra être assignée immédiatement aux utilisateurs internes.
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<style>
    /* Global Styles Jackson Brand */
    .font-weight-black { font-weight: 900; }
    .rounded-xl { border-radius: 12px !important; }
    .border-left-indigo { border-left: 5px solid #4f46e5 !important; }

    /* UI Logic */
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
        border-color: #4f46e5;
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        outline: none;
    }

    /* Action Buttons */
    .btn-indigo-premium { background: #4f46e5; color: white; border: none; font-weight: 700; transition: 0.3s; }
    .btn-indigo-premium:hover { background: #4338ca; transform: translateY(-1px); color: white; box-shadow: 0 4px 12px rgba(79, 70, 229, 0.2); }

    .alert-soft-indigo { background: #eef2ff; color: #3730a3; }
    .border-right { border-right: 1px solid #f1f5f9; }
</style>
@endsection
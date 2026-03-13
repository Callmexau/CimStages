@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    {{-- Header avec dégradé pour un aspect plus Premium --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-white text-info rounded-circle d-flex align-items-center justify-content-center shadow-sm"
                                 style="width: 70px; height: 70px; font-size: 1.5rem;">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                        </div>
                        <div class="ml-4 text-white">
                            @auth
                                <h3 class="font-weight-bold mb-1">Ravi de vous revoir, {{ auth()->user()->name }} !</h3>
                            @endauth
                            <p class="mb-0 opacity-8" style="font-size: 1.1rem;">
                                Votre carrière commence ici. Gérez vos opportunités et vos candidatures en toute simplicité.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Action principale - Plus centrée et visuelle --}}
        <div class="col-lg-8">
            <div class="card card-outline card-primary shadow-lg border-0" style="border-radius: 12px;">
                <div class="card-header bg-transparent border-bottom-0 pt-4 px-4">
                    <h3 class="card-title font-weight-bold text-dark">
                        <i class="fas fa-paper-plane text-primary mr-2"></i> Prêt pour une nouvelle étape ?
                    </h3>
                </div>

                <div class="card-body p-4 text-center">
                    <div class="mb-4">
                        <p class="text-muted leading-relaxed">
                            Soumettez votre dossier en moins de 2 minutes. Assurez-vous d'avoir préparé :
                        </p>
                        <div class="d-flex justify-content-center gap-3">
                            <span class="badge badge-light p-2 mx-2 border"><i class="fas fa-file-pdf text-danger mr-1"></i> CV à jour</span>
                            <span class="badge badge-light p-2 mx-2 border"><i class="fas fa-id-card text-primary mr-1"></i> Pièce d'identité</span>
                        </div>
                    </div>

                    <a href="{{ route('stagiaire.demande.create') }}"
                       class="btn btn-primary btn-lg px-5 py-3 shadow-sm transition-all hover-lift"
                       style="border-radius: 50px; font-weight: 600;">
                        <i class="fas fa-plus-circle mr-2"></i> Déposer ma demande
                    </a>
                </div>
            </div>
        </div>

        {{-- Barre latérale d'informations (Aide / Rappel) --}}
        <div class="col-lg-4">
            <div class="card bg-light border-0 shadow-sm" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h5 class="font-weight-bold mb-3"><i class="fas fa-lightbulb text-warning mr-2"></i> Conseils</h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                            <span class="small text-muted">Vérifiez vos <strong>coordonnées</strong> (téléphone et email).</span>
                        </li>
                        <li class="mb-3 d-flex align-items-start">
                            <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                            <span class="small text-muted">Utilisez un format <strong>PDF</strong> pour vos documents.</span>
                        </li>
                        <li class="d-flex align-items-start">
                            <i class="fas fa-check-circle text-success mt-1 mr-2"></i>
                            <span class="small text-muted">Un CV clair augmente vos chances.</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Une petite touche de style pour l'effet "Brand" */
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .hover-lift:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .opacity-8 { opacity: 0.85; }
</style>
@endsection
@extends('layouts.adminlte')

@section('content')
<section class="content-wrapper-premium" style="background:#f4f7fa; padding:2.5rem 1.5rem;">
    <div class="container-fluid">

        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-md-12">
                <h1 class="h3 font-weight-bold text-dark mb-1">
                    Détail de la demande #{{ $besoin->id }}
                </h1>
                <p class="text-muted">Consultation du formulaire avant validation/rejet</p>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-outline card-success shadow-sm">
                    {{-- Header Card --}}
                    <div class="card-header border-bottom">
                        <div class="row align-items-center text-center">
                            <div class="col-md-4 border-right">
                                <img src="{{ asset('images/cimburkina_officiel_logo.jpg') }}" alt="CIMBURKINA" style="max-height:95px;">
                            </div>
                            <div class="col-md-4 border-right">
                                <h5 class="mb-0 font-weight-bold text-uppercase text-success">Gérer les Ressources Humaines</h5>
                                <hr class="my-1">
                                <small>FORMULAIRE DE DEMANDE DE STAGIAIRE</small>
                            </div>
                            <div class="col-md-4 text-left small">
                                Code : ENG/GRHFDS<br>
                                Rédigé le : 27/05/2024<br>
                                Révisé le : 03/07/2025<br>
                                Version : 02
                            </div>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="card-body">

                        {{-- Informations du demandeur --}}
                        <h4 class="bg-success text-white p-2 text-center text-uppercase mb-4">
                            Formulaire de Demande de Stagiaires
                        </h4>

                        <div class="card card-success card-outline mb-3">
                            <div class="card-header bg-success py-1">
                                <h6 class="card-title text-white">Information du demandeur</h6>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-6 form-group">
                                    <label>DEPARTEMENT :</label>
                                    <input type="text" class="form-control form-control-sm" value="{{ $besoin->departement ?? '' }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Demandeur :</label>
                                    <input type="text" class="form-control form-control-sm" value="{{ $besoin->poste ?? '' }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Nom du Responsable du Département :</label>
                                    <input type="text" class="form-control form-control-sm" value="{{ $besoin->responsable_nom ?? '' }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Fonction :</label>
                                    <input type="text" class="form-control form-control-sm" value="{{ $besoin->fonction ?? '' }}" readonly>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Date de la requête :</label>
                                    <input type="date" class="form-control form-control-sm" value="{{ optional($besoin->date_requete)->format('Y-m-d') ?? '' }}" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Type de demande --}}
                        <div class="card card-success card-outline mb-3">
                            <div class="card-header bg-success py-1"><h6 class="card-title text-white">Type de la demande</h6></div>
                            <div class="card-body">
                                <input type="text" class="form-control form-control-sm" value="{{ $besoin->type_demande ?? '' }}" readonly>
                            </div>
                        </div>

                        {{-- Motifs --}}
                        <div class="card card-success card-outline mb-3">
                            <div class="card-header bg-success py-1"><h6 class="card-title text-white">Motifs de la demande</h6></div>
                            <div class="card-body">
                                @if(!empty($besoin->motifs))
                                    <ul class="list-group mb-2">
                                        @foreach($besoin->motifs as $motif)
                                            <li class="list-group-item">{{ $motif }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                                <label>Autres :</label>
                                <textarea class="form-control form-control-sm" rows="2" readonly>{{ $besoin->autres_motifs ?? '' }}</textarea>
                            </div>
                        </div>

                        {{-- Service / Encadrant --}}
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card card-success card-outline h-100">
                                    <div class="card-header bg-success py-1"><h6 class="card-title text-white">Service ou section d'affectation</h6></div>
                                    <div class="card-body p-2">
                                        <input type="text" class="form-control form-control-sm" value="{{ $besoin->service ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-success card-outline h-100">
                                    <div class="card-header bg-success py-1"><h6 class="card-title text-white">Encadrant du stagiaire</h6></div>
                                    <div class="card-body p-2">
                                        <input type="text" class="form-control form-control-sm" value="{{ $besoin->encadrant ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Profil du stagiaire --}}
                        <div class="card card-success card-outline mt-3 mb-3">
                            <div class="card-header bg-success py-1"><h6 class="card-title text-white">Profil du stagiaire recherché</h6></div>
                            <div class="card-body">
                                <div class="form-group row mb-2">
                                    <label class="col-sm-3 col-form-label-sm">Domaine de formation :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{ $besoin->domaine_formation ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-sm-3 col-form-label-sm">Niveau d'études requis :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control form-control-sm" value="{{ $besoin->niveau_etudes ?? '' }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label-sm">Compétences spécifiques attendues :</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control form-control-sm" rows="2" readonly>{{ $besoin->competences ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Stage durée / nombre / période --}}
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="card card-success card-outline">
                                    <div class="card-header bg-success py-1 text-center small text-white font-weight-bold">Durée du stage</div>
                                    <div class="card-body py-2">
                                        <input type="text" class="form-control form-control-sm" value="{{ $besoin->duree ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="card card-success card-outline">
                                    <div class="card-header bg-success py-1 text-center small text-white font-weight-bold">Nombre de Stagiaires</div>
                                    <div class="card-body">
                                        <input type="text" class="form-control form-control-sm" value="{{ $besoin->nombre_stagiaires ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-success card-outline">
                                    <div class="card-header bg-success py-1 text-center small text-white font-weight-bold">Période souhaitée</div>
                                    <div class="card-body">
                                        <input type="text" class="form-control form-control-sm" value="{{ $besoin->periode ?? '' }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    {{-- Footer boutons --}}
                    <div class="card-footer text-right border-top bg-light d-flex justify-content-between">
                        <a href="{{ route('darh.besoins.index') }}" class="btn btn-secondary px-4">
                            <i class="fas fa-arrow-left"></i> Retour
                        </a>

                        <div class="btn-group">
                            <form action="{{ route('darh.besoins.valider', $besoin) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-success px-4">
                                    <i class="fas fa-check"></i> Valider
                                </button>
                            </form>

                            <form action="{{ route('darh.besoins.rejeter', $besoin) }}" method="POST" class="d-inline">
                                @csrf
                                <button class="btn btn-danger px-4">
                                    <i class="fas fa-times"></i> Rejeter
                                </button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
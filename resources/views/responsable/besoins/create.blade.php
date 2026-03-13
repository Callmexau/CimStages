@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-success shadow-lg">
                <div class="card-header border-bottom">
                    <div class="row align-items-center text-center">
                        <div class="col-md-4 border-right">
                            <img src="{{ asset('images/cimburkina_officiel_logo.jpg') }}" alt="CIMBURKINA" style="max-height: 95px;">
                        </div>
                        <div class="col-md-4 border-right">
                            <h5 class="mb-0 font-weight-bold text-uppercase">Gérer les Ressources Humaines</h5>
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

                <form method="POST" action="{{ route('responsable.besoins.store') }}">
                    @csrf
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

                                {{-- Département (automatique) --}}
                                <div class="col-md-6 form-group">
                                    <label>DEPARTEMENT :</label>
                                    <input type="text"
                                        class="form-control form-control-sm"
                                        value="{{ auth()->user()->structure?->name ?? 'Non défini' }}"
                                        readonly>

                                    <input type="hidden"
                                        name="departement"
                                        value="{{ auth()->user()->structure?->name ?? '' }}">
                                </div>

                                {{-- Demandeur (automatique) --}}
                                <div class="col-md-6 form-group">
                                    <label>Demandeur :</label>
                                    <input type="text"
                                        class="form-control form-control-sm"
                                        value="{{ auth()->user()->name }}"
                                        readonly>

                                    <input type="hidden"
                                        name="poste"
                                        value="{{ auth()->user()->name }}">
                                </div>

                                {{-- Nom du responsable du département --}}
                                <div class="col-md-6 form-group">
                                    <label>Nom du Responsable du Département :</label>
                                    <input type="text"
                                        name="responsable_dept"
                                        class="form-control form-control-sm"
                                        placeholder="Saisir le nom du responsable"
                                        required>
                                </div>

                                {{-- Fonction --}}
                                <div class="col-md-6 form-group">
                                    <label>Fonction :</label>
                                    <input type="text"
                                        name="fonction"
                                        class="form-control form-control-sm"
                                        placeholder="Saisir votre poste"
                                        value="{{ auth()->user()->fonction ?? '' }}"
                                        required>
                                </div>

                                {{-- Date --}}
                                <div class="col-md-6 form-group">
                                    <label>Date de la requête :</label>
                                    <input type="date"
                                        name="date_requete"
                                        class="form-control form-control-sm"
                                        value="{{ now()->format('Y-m-d') }}"
                                        readonly>
                                </div>

                            </div>
                        </div>

                        {{-- Type de demande --}}
                        <div class="card card-success card-outline mb-3">
                            <div class="card-header bg-success py-1"><h6 class="card-title text-white">Type de la demande</h6></div>
                            <div class="card-body d-flex justify-content-around">
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="nouvelle" name="type_demande" value="Nouvelle" checked>
                                    <label for="nouvelle" class="custom-control-label font-weight-normal">Nouvelle</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input class="custom-control-input" type="radio" id="renouvellement" name="type_demande" value="Renouvellement">
                                    <label for="renouvellement" class="custom-control-label font-weight-normal">Renouvellement</label>
                                </div>
                            </div>
                        </div>

                        {{-- Motifs --}}
                        <div class="card card-success card-outline mb-3">
                            <div class="card-header bg-success py-1"><h6 class="card-title text-white">Motif de la demande</h6></div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 border-right">
                                        <div class="custom-control custom-checkbox mb-2">
                                            <input class="custom-control-input" type="checkbox" id="appui" name="motifs[]" value="Appui formation">
                                            <label for="appui" class="custom-control-label font-weight-normal">Appui à la formation pratique</label>
                                        </div>
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" id="rse" name="motifs[]" value="Valorisation RSE">
                                            <label for="rse" class="custom-control-label font-weight-normal">Valorisation de la politique RSE</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="font-weight-normal">Autres :</label>
                                        <textarea name="autres_motifs" class="form-control form-control-sm" rows="2"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Service / Encadrant --}}
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="card card-success card-outline h-100">
                                    <div class="card-header bg-success py-1"><h6 class="card-title text-white">Service ou section d'affectation</h6></div>
                                    <div class="card-body p-2">
                                        <input type="text" name="service" class="form-control form-control-sm" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card card-success card-outline h-100">
                                    <div class="card-header bg-success py-1"><h6 class="card-title text-white">Encadrant du stagiaire</h6></div>
                                    <div class="card-body p-2">
                                        <input type="text" name="encadrant" class="form-control form-control-sm" required>
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
                                        <input type="text" name="domaine_formation" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-sm-3 col-form-label-sm">Niveau d'études requis :</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="niveau_etudes" class="form-control form-control-sm">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-12 col-form-label-sm">Compétences spécifiques attendues :</label>
                                    <div class="col-sm-12">
                                        <textarea name="competences" class="form-control form-control-sm" rows="2"></textarea>
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
                                        <div class="custom-control custom-radio small">
                                            <input class="custom-control-input" type="radio" id="1m" name="duree" value="1 mois">
                                            <label for="1m" class="custom-control-label">1 mois</label>
                                        </div>
                                        <div class="custom-control custom-radio small">
                                            <input class="custom-control-input" type="radio" id="2m" name="duree" value="2 mois">
                                            <label for="2m" class="custom-control-label">2 mois</label>
                                        </div>
                                        <div class="custom-control custom-radio small">
                                            <input class="custom-control-input" type="radio" id="3m" name="duree" value="3 mois">
                                            <label for="3m" class="custom-control-label">3 mois</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-center">
                                <div class="card card-success card-outline">
                                    <div class="card-header bg-success py-1 text-center small text-white font-weight-bold">Nombre de Stagiaires</div>
                                    <div class="card-body">
                                        <input type="number" name="nombre_stagiaires" class="form-control" min="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card card-success card-outline">
                                    <div class="card-header bg-success py-1 text-center small text-white font-weight-bold">Période souhaitée</div>
                                    <div class="card-body">
                                        <input type="text" name="periode" class="form-control form-control-sm" placeholder="Ex: Octobre 2027">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer text-right border-top bg-light">
                        <button type="submit" class="btn btn-success px-5">
                            <i class="fas fa-check-circle"></i> Enregistrer la demande
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.adminlte')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card card-outline card-success shadow-lg">
                <form method="POST" action="{{ route('evaluation.store') }}" autocomplete="off">
                    @csrf

                    <div class="card-body">
                        <h4 class="bg-success text-white p-2 text-center text-uppercase mb-4">
                            Fiche d'Évaluation du Stagiaire
                        </h4>

                        {{-- Informations générales --}}
                        <div class="table-responsive mb-4">
                            <table class="table table-bordered table-sm">
                                <thead class="bg-light">
                                    <tr>
                                        <th colspan="2" class="text-center">Informations générales</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td width="30%" class="font-weight-bold">Nom et prénom du stagiaire</td>
                                        <td><input type="text" name="nom_stagiaire" class="form-control form-control-sm border-0"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Formation / École / Université</td>
                                        <td><input type="text" name="etablissement" class="form-control form-control-sm border-0"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Département / Service d’accueil</td>
                                        <td><input type="text" name="service" class="form-control form-control-sm border-0"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Fonction occupée pendant le stage</td>
                                        <td><input type="text" name="fonction" class="form-control form-control-sm border-0"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Nom du tuteur / Maître de stage</td>
                                        <td><input type="text" name="tuteur" class="form-control form-control-sm border-0"></td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Période du stage</td>
                                        <td>
                                            <input type="text" name="periode" class="form-control form-control-sm border-0"
                                                   placeholder="ex: Du 01/01 au 31/03">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold">Date de l'évaluation</td>
                                        <td><input type="date" name="date_evaluation" class="form-control form-control-sm border-0"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        @php
                            $sections = [
                                'Comportement professionnel' => [
                                    'Ponctualité / Présence régulière',
                                    'Respect des consignes de sécurité',
                                    'Comportement général / Attitude',
                                    'Intégration dans l’équipe',
                                    'Communication avec les collègues',
                                    'Autonomie et sens des responsabilités',
                                    'Esprit d’initiative / Réactivité'
                                ],
                                'Compétences techniques et professionnelles' => [
                                    'Compréhension des consignes de travail',
                                    'Application des procédures internes',
                                    'Utilisation des équipements / outils',
                                    'Rigueur et qualité du travail',
                                    'Respect des délais et des priorités',
                                    'Capacité à proposer des améliorations'
                                ],
                                'Santé, Sécurité et Environnement (HSE)' => [
                                    'Respect des règles HSE',
                                    'Port des EPI',
                                    'Réaction face aux situations à risque',
                                    'Participation aux briefings sécurité'
                                ]
                            ];
                        @endphp

                        {{-- Sections d’évaluation --}}
                        @foreach($sections as $sectionTitle => $criteres)
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-sm text-center">
                                    <thead class="bg-light">
                                        <tr>
                                            <th colspan="5" class="text-center">{{ $sectionTitle }}</th>
                                        </tr>
                                        <tr class="small font-weight-bold">
                                            <th class="text-left" width="40%">Critères</th>
                                            <th width="15%">Très Satisfaisant</th>
                                            <th width="15%">Satisfaisant</th>
                                            <th width="15%">À améliorer</th>
                                            <th width="15%">Insuffisant</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($criteres as $critere)
                                            @php $key = \Illuminate\Support\Str::slug($critere); @endphp
                                            <tr>
                                                <td class="text-left small">{{ $critere }}</td>
                                                <td><input type="radio" name="eval[{{ $key }}]" value="4" required></td>
                                                <td><input type="radio" name="eval[{{ $key }}]" value="3"></td>
                                                <td><input type="radio" name="eval[{{ $key }}]" value="2"></td>
                                                <td><input type="radio" name="eval[{{ $key }}]" value="1"></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endforeach

                        {{-- Appréciation --}}
                        <div class="card card-success card-outline">
                            <div class="card-header py-1 font-weight-bold">
                                Appréciation globale du stage
                            </div>
                            <div class="card-body p-2">
                                <label class="small">Commentaires du tuteur / maître de stage :</label>
                                <textarea name="commentaires" class="form-control" rows="3"></textarea>
                            </div>
                        </div>

                        {{-- Recommandation --}}
                        <div class="card card-success card-outline mt-3">
                            <div class="card-header py-1 font-weight-bold">
                                Recommandation finale
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach(['Très bonne performance', 'Bon stage', 'Moyenne', 'Insuffisant'] as $recom)
                                        <div class="col-md-3">
                                            <div class="custom-control custom-radio">
                                                <input class="custom-control-input"
                                                       type="radio"
                                                       id="recom_{{ $loop->index }}"
                                                       name="recommandation"
                                                       value="{{ $recom }}"
                                                       required>
                                                <label for="recom_{{ $loop->index }}"
                                                       class="custom-control-label small font-weight-normal">
                                                    {{ $recom }}
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- Signatures --}}
                        <div class="row mt-4 border py-3">
                            <div class="col-md-4 text-center border-right">
                                <label class="font-weight-bold">Tuteur / Maître de stage</label>
                                <input type="text" name="signature_tuteur" class="form-control form-control-sm mt-2"
                                       placeholder="Nom et prénom">
                            </div>

                            <div class="col-md-4 text-center border-right">
                                <label class="font-weight-bold">Responsable RH</label>
                                <input type="text" name="signature_rh" class="form-control form-control-sm mt-2"
                                       placeholder="Nom et prénom">
                            </div>

                            <div class="col-md-4 text-center">
                                <label class="font-weight-bold">Stagiaire</label>
                                <input type="text" name="signature_stagiaire" class="form-control form-control-sm mt-2"
                                       placeholder="Nom et prénom">
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-center">
                        <button type="submit" class="btn btn-success px-5">
                            Valider l'Évaluation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

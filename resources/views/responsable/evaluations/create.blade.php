@extends('layouts.adminlte')

@section('content')
<div class="container py-4">

@php
    $evaluation = $demande->evaluation ?? null;

    $ratings = [
        'Très satisfaisant' => 4,
        'Satisfaisant' => 3,
        'À améliorer' => 2,
        'Insuffisant' => 1
    ];

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

    $scoresExistants = $evaluation?->scores ?? [];
@endphp

<form action="{{ route('responsable.evaluations.store') }}" method="POST" id="evaluationForm">
    @csrf

    <input type="hidden" name="demande_id" value="{{ $demande->id }}">
    <input type="hidden" name="note_finale" id="note_finale" value="{{ old('note_finale', $evaluation->note_finale ?? '') }}">

    <div class="card shadow-sm">
        <div class="card-body p-0">

            {{-- TITRE --}}
            <h4 class="text-center bg-success text-white py-2 m-0 fw-bold">
                FICHE D’ÉVALUATION DU STAGIAIRE
            </h4>

            {{-- INFOS AUTO --}}
            <table class="table table-bordered mb-0">
                <tr class="table-secondary text-center fw-bold">
                    <td colspan="2">Informations générales</td>
                </tr>

                <tr>
                    <td class="fw-semibold">Nom et prénom du stagiaire</td>
                    <td>{{ $demande->stagiaire->prenom }} {{ strtoupper($demande->stagiaire->nom) }}</td>
                </tr>

                <tr>
                    <td class="fw-semibold">Email</td>
                    <td>{{ $demande->stagiaire->email }}</td>
                </tr>

                <tr>
                    <td class="fw-semibold">Formation / École / Université</td>
                    <td>{{ $demande->universite ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="fw-semibold">Structure / Service</td>
                    <td>{{ $demande->structure->name ?? '-' }}</td>
                </tr>

                <tr>
                    <td class="fw-semibold">Fonction pendant le stage</td>
                    <td>
                        <input type="text"
                               name="poste"
                               class="form-control"
                               placeholder="Ex: Ingénieur Logiciel, Assistant RH..."
                               value="{{ old('poste', $evaluation->poste ?? $demande->poste) }}"
                               {{ $evaluation ? 'readonly' : '' }}>
                    </td>
                </tr>

                <tr>
                    <td class="fw-semibold">Période du stage</td>
                    <td>
                        @php
                            $dateDebut = \Carbon\Carbon::parse($demande->date_acceptation ?? $demande->updated_at);
                            $dateFin = $dateDebut->copy()->addMonths(2);
                        @endphp

                        Du {{ $dateDebut->format('d/m/Y') }}
                        au {{ $dateFin->format('d/m/Y') }}
                    </td>
                </tr>

                <tr>
                    <td class="fw-semibold">Date de l’évaluation</td>
                    <td>{{ $evaluation ? $evaluation->created_at->format('d/m/Y') : now()->format('d/m/Y') }}</td>
                </tr>
            </table>

            {{-- SECTIONS --}}
            @foreach($sections as $title => $criteria)
            <table class="table table-bordered mb-0">
                <tr class="table-secondary text-center fw-bold">
                    <td colspan="{{ count($ratings) + 1 }}">{{ $title }}</td>
                </tr>

                <tr class="text-center fw-bold">
                    <td>Critères</td>
                    @foreach(array_keys($ratings) as $rating)
                        <td>{{ $rating }}</td>
                    @endforeach
                </tr>

                @foreach($criteria as $criterion)
                    @php
                        $slug = \Illuminate\Support\Str::slug($criterion, '_');
                        $oldOrSaved = old("scores.$slug", $scoresExistants[$slug] ?? null);
                    @endphp
                    <tr>
                        <td>{{ $criterion }}</td>
                        @foreach($ratings as $label => $value)
                        <td class="text-center">
                            <input type="radio"
                                   name="scores[{{ $slug }}]"
                                   value="{{ $value }}"
                                   class="score-radio"
                                   {{ (string)$oldOrSaved === (string)$value ? 'checked' : '' }}
                                   {{ $evaluation ? 'disabled' : 'required' }}>
                        </td>
                        @endforeach
                    </tr>
                @endforeach
            </table>
            @endforeach

            {{-- COMMENTAIRES --}}
            <table class="table table-bordered mb-0">
                <tr class="table-secondary text-center fw-bold">
                    <td>Appréciation globale du stage</td>
                </tr>
                <tr>
                    <td>
                        <textarea name="commentaires"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Donnez une appréciation globale du stagiaire (points forts, axes d'amélioration, comportement, etc.)"
                                  {{ $evaluation ? 'readonly' : '' }}>{{ old('commentaires', $evaluation->commentaires ?? '') }}</textarea>
                    </td>
                </tr>
            </table>

            {{-- RECOMMANDATION --}}
            <table class="table table-bordered mb-0">
                <tr class="table-secondary text-center fw-bold">
                    <td>Recommandation finale</td>
                </tr>
                <tr>
                    <td>
                        @foreach(['Très bonne performance', 'Bon stage', 'Moyenne', 'Insuffisant'] as $rec)
                            <div>
                                <input type="radio"
                                       name="recommandation"
                                       value="{{ $rec }}"
                                       {{ old('recommandation', $evaluation->recommandation ?? '') === $rec ? 'checked' : '' }}
                                       {{ $evaluation ? 'disabled' : '' }}>
                                {{ $rec }}
                            </div>
                        @endforeach
                    </td>
                </tr>
            </table>

        </div>
    </div>

    <div class="text-center mt-3">
        @if($evaluation)
            <div class="d-inline-block px-4 py-2 bg-success text-white fw-bold rounded shadow-sm">
                Note finale : {{ number_format((float)$evaluation->note_finale, 2, ',', ' ') }}/20
            </div>
        @else
            <button type="submit" class="btn btn-success px-4" id="submitBtn">
                Enregistrer l’évaluation
            </button>
        @endif
    </div>

</form>

</div>

@if(!$evaluation)
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('evaluationForm');
    const noteInput = document.getElementById('note_finale');

    function calculerNoteSur20() {
        const radios = document.querySelectorAll('.score-radio:checked');
        let total = 0;
        let count = 0;

        radios.forEach(radio => {
            total += parseInt(radio.value, 10);
            count++;
        });

        if (count === 0) {
            return 0;
        }

        return ((total / (count * 4)) * 20).toFixed(2);
    }

    form.addEventListener('submit', function () {
        noteInput.value = calculerNoteSur20();
    });
});
</script>
@endif
@endsection
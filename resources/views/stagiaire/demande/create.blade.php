@extends('layouts.adminlte')

@section('title', 'Soumettre ma Candidature')

@section('content')
<div class="row justify-content-center">
    <div class="col-xl-10 col-lg-9 col-md-11">

        <div class="card card-outline card-info shadow-lg">
            <div class="card-header border-0 pt-4">
                <div class="text-center">
                    <div class="bg-info d-inline-block p-3 rounded-circle mb-3 shadow-sm">
                        <i class="fas fa-user-graduate fa-2x text-white"></i>
                    </div>
                    <h3 class="font-weight-bold text-dark w-100">
                        Soumettre ma Candidature
                    </h3>
                    <p class="text-muted small">
                        Veuillez remplir les informations ci-dessous pour postuler à un stage.
                    </p>
                </div>
            </div>

            <form action="{{ route('stagiaire.demande.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card-body px-lg-5">

                    {{-- Niveau + Filière --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-secondary">
                                    <i class="fas fa-graduation-cap mr-1"></i> Niveau d’étude
                                </label>
                                <select name="niveau_etude" class="form-control form-control-border border-width-2" required>
                                    <option value="" disabled selected>— Choisir —</option>
                                    <option value="BEP">BEP</option>
                                    <option value="CAP">CAP</option>
                                    <option value="BAC">BAC</option>
                                    <option value="Licence">Licence</option>
                                    <option value="Master">Master</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-secondary">
                                    <i class="fas fa-book mr-1"></i> Filière / Spécialité
                                </label>
                                <input
                                    type="text"
                                    name="filiere"
                                    class="form-control form-control-border border-width-2"
                                    placeholder="Ex : Informatique"
                                    required
                                >
                            </div>
                        </div>
                    </div>

                    {{-- Université + Structure --}}
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-secondary">
                                    <i class="fas fa-university mr-1"></i> Université / Établissement
                                </label>
                                <input
                                    type="text"
                                    name="universite"
                                    class="form-control form-control-border border-width-2"
                                    placeholder="Ex : Université Joseph Ki-Zerbo"
                                    required
                                >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-secondary">
                                    <i class="fas fa-building mr-1"></i> Département de stage souhaitée
                                </label>
                                <select
                                    name="structure_id"
                                    class="form-control form-control-border border-width-2"
                                    required
                                >
                                    <option value="" disabled selected>— Choisir une structure —</option>
                                    @foreach ($structures as $structure)
                                        <option value="{{ $structure->id }}">
                                            {{ $structure->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Type de stage --}}
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-secondary">
                                    <i class="fas fa-layer-group mr-1"></i> Type de stage
                                </label>
                                <select name="type_stage" class="form-control form-control-border border-width-2" required>
                                    <option value="" disabled selected>— Choisir —</option>
                                    <option value="soutenance">Stage de soutenance</option>
                                    <option value="perfectionnement">Stage de perfectionnement</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    {{-- Expérience + Téléphone --}}
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-secondary">
                                    <i class="fas fa-briefcase mr-1"></i> Expérience professionnelle
                                </label>
                                <select
                                    name="experience_professionnelle"
                                    class="form-control form-control-border border-width-2"
                                    required
                                >
                                    <option value="" disabled selected>— Sélectionner —</option>
                                    <option value="0 mois">0 mois</option>
                                    <option value="2 mois">2 mois</option>
                                    <option value="3 mois">3 mois</option>
                                    <option value="4 mois">4 mois</option>
                                    <option value="6 mois">6 mois</option>
                                    <option value="1 an">1 an</option>
                                    <option value="2 ans">2 ans</option>
                                    <option value="3 ans">3 ans</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telephone" class="text-secondary">
                                    <i class="fas fa-phone mr-1"></i> Numéro de téléphone
                                </label>
                                <input
                                    type="tel"
                                    name="telephone"
                                    id="telephone"
                                    class="form-control form-control-border border-width-2"
                                    placeholder="Ex: +226 70 XX XX XX"
                                    required
                                >
                                <small class="text-muted">
                                    Numéro joignable pour le suivi de votre dossier.
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Documents --}}
                    <div class="mt-4 mb-3 border-bottom pb-2 text-info font-weight-bold">
                        <i class="fas fa-paperclip mr-1"></i> Documents requis (PDF/Images)
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-secondary">CV (Curriculum Vitae)</label>
                                <div class="custom-file">
                                    <input type="file" name="cv" class="custom-file-input" id="customFileCv" accept="application/pdf" required>
                                    <label class="custom-file-label" for="customFileCv">Choisir le PDF...</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="text-secondary">Pièce d'identité (CNIB / Passeport)</label>
                                <div class="custom-file">
                                    <input type="file" name="cnib" class="custom-file-input" id="customFileId" accept=".pdf,.jpg,.jpeg,.png" required>
                                    <label class="custom-file-label" for="customFileId">Scan de la pièce...</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="card-footer bg-white border-0 text-center pb-5">
                    <button type="submit" class="btn btn-info btn-lg px-5 shadow-sm rounded-pill">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Valider ma demande
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('change', function (e) {
    if (e.target && e.target.classList.contains('custom-file-input')) {
        let fileInput = e.target;
        let fileName = fileInput.files.length > 0 ? fileInput.files[0].name : "Choisir un fichier...";
        let label = fileInput.nextElementSibling;
        if (label && label.classList.contains('custom-file-label')) {
            label.innerText = fileName;
        }
    }
});
</script>
@endpush

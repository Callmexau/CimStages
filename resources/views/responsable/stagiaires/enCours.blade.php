@extends('layouts.adminlte')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Stagiaires en cours</h1>

    @if($stagiairesEnCours->isEmpty())
        <div class="alert alert-info">Aucun stagiaire en cours pour le moment.</div>
    @else
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nom complet</th>
                    <th>Email</th>
                    <th>Date début</th>
                    <th>Date fin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stagiairesEnCours as $stagiaire)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $stagiaire->name }}</td>
                        <td>{{ $stagiaire->email }}</td>
                        <td>{{ \Carbon\Carbon::parse($stagiaire->debut_stage)->format('d/m/Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($stagiaire->fin_stage)->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('responsable.stagiaires.index') }}" class="btn btn-secondary mt-3">Retour au menu</a>
</div>
@endsection

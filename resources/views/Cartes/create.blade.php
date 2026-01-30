@extends('layouts.app')

@section('title', 'Créer une carte')

@section('content')
<div class="container mt-4">
    <h2>Créer une carte</h2>

    <form action="{{ route('cartes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Étudiant</label>
            <select name="etudiant_id" class="form-control" required>
                @foreach($etudiants as $etudiant)
                    <option value="{{ $etudiant->id }}">{{ $etudiant->nom }} {{ $etudiant->prenom }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-success">Créer</button>
        <a href="{{ route('cartes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection

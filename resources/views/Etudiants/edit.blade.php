@extends('layouts.app')

@section('title', 'Modifier un étudiant')

@section('content')
<div class="container mt-4">
    <h2>Modifier un étudiant</h2>

    <!-- Affichage des erreurs -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('etudiants.update', $etudiant->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" value="{{ $etudiant->nom }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" value="{{ $etudiant->prenom }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">INE</label>
            <input type="text" name="ine" class="form-control" value="{{ $etudiant->ine }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Filière</label>
            <input type="text" name="filiere" class="form-control" value="{{ $etudiant->filiere }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Niveau</label>
            <input type="text" name="niveau" class="form-control" value="{{ $etudiant->niveau }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Année académique</label>
            <input type="text" name="annee_academique" class="form-control" value="{{ $etudiant->annee_academique }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
            @if($etudiant->photo)
                <p class="mt-2">Photo actuelle :</p>
                <img src="{{ asset('storage/'.$etudiant->photo) }}" alt="Photo étudiant" width="100" class="rounded">
            @endif
        </div>

        <button type="submit" class="btn btn-success">Mettre à jour</button>
        <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection

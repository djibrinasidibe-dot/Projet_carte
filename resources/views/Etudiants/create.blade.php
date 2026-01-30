@extends('layouts.app')

@section('title', 'Créer un étudiant')

@section('content')
<div class="container mt-4">
    <h2>Ajouter un étudiant</h2>

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

    <form action="{{ route('etudiants.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Prénom</label>
            <input type="text" name="prenom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">INE</label>
            <input type="text" name="ine" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Filière</label>
            <input type="text" name="filiere" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Niveau</label>
            <input type="text" name="niveau" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Année académique</label>
            <input type="text" name="annee_academique" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Photo</label>
            <input type="file" name="photo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Créer</button>
        <a href="{{ route('etudiants.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection

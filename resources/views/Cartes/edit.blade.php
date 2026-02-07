@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Modifier la carte #{{ $carte->numero_carte }}</h2>

    <form action="{{ route('cartes.update', $carte->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Étudiant</label>
            <input type="text" class="form-control" value="{{ $carte->etudiant->nom }} {{ $carte->etudiant->prenom }}" disabled>
        </div>

        <div class="mb-3">
            <label for="statut">Statut</label>
            <select name="statut" id="statut" class="form-control" required>
                <option value="active" {{ $carte->statut == 'active' ? 'selected' : '' }}>Active</option>
                <option value="suspendue" {{ $carte->statut == 'suspendue' ? 'selected' : '' }}>Suspendue</option>
                <option value="expiree" {{ $carte->statut == 'expiree' ? 'selected' : '' }}>Expirée</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_expiration">Date d'expiration</label>
            <input type="date" name="date_expiration" id="date_expiration" class="form-control"
            <input type="date" name="date_expiration" id="date_expiration" class="form-control"
             value="{{ \Carbon\Carbon::parse($carte->date_expiration)->format('Y-m-d') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Mettre à jour</button>
        <a href="{{ route('cartes.index') }}" class="btn btn-secondary">Annuler</a>
    </form>
</div>
@endsection
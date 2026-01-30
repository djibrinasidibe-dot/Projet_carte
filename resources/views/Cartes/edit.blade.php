@extends('layouts.app')

@section('title', 'Modifier une carte')

@section('content')
<div class="container mt-4">
    <h2>Modifier une carte</h2>

    <form action="{{ route('cartes.updateStatus', $carte->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label class="form-label">Statut</label>
        <select name="statut" class="form-control">
            <option value="active" {{ $carte->statut == 'active' ? 'selected' : '' }}>Active</option>
            <option value="suspendue" {{ $carte->statut == 'suspendue' ? 'selected' : '' }}>Suspendue</option>
            <option value="expiree" {{ $carte->statut == 'expiree' ? 'selected' : '' }}>Expirée</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Mettre à jour</button>
    <a href="{{ route('cartes.index') }}" class="btn btn-secondary">Annuler</a>
</form>

</div>
@endsection

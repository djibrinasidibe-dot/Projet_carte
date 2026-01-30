@extends('layouts.app')

@section('title', 'Liste des cartes')

@section('content')
<div class="container mt-4">
    <h2>Liste des cartes</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('cartes.create') }}" class="btn btn-primary mb-3">Créer une carte</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Numéro</th>
                <th>Étudiant</th>
                <th>Statut</th>
                <th>Date expiration</th>
                <th>QR Code</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($cartes as $carte)
                <tr>
                    <td>{{ $carte->id }}</td>
                    <td>{{ $carte->numero_carte }}</td>
                    <td>{{ $carte->etudiant->nom }} {{ $carte->etudiant->prenom }}</td>
                    <td>{{ $carte->statut }}</td>
                    <td>{{ $carte->date_expiration }}</td>
                    <td>
                        @if($carte->qr_code)
                            <img src="{{ asset($carte->qr_code) }}" width="80" alt="QR Code">
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('cartes.edit', $carte->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                        <form action="{{ route('cartes.destroy', $carte->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette carte ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Aucune carte trouvée</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

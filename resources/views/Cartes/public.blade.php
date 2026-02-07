<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte Étudiant</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: #f2f2f2;
        }
        .carte {
            max-width: 420px;
            margin: 40px auto;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,.15);
            background: #fff;
        }
        .carte-header {
            background: #0d6efd;
            color: white;
            padding: 15px;
            text-align: center;
            font-weight: bold;
            font-size: 18px;
        }
        .photo {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #0d6efd;
            margin-top: -60px;
            background: #fff;
        }
        .statut {
            font-weight: bold;
        }
        .active { color: green; }
        .suspendue { color: orange; }
        .expiree { color: red; }
    </style>
</head>
<body>

<div class="carte">
    <div class="carte-header">
        CARTE D'ÉTUDIANT NUMÉRIQUE
    </div>

    <div class="text-center p-3">
        <img src="{{ asset('storage/' . $carte->etudiant->photo) }}" class="photo" alt="Photo étudiant">

        <h5 class="mt-3">
            {{ $carte->etudiant->nom }} {{ $carte->etudiant->prenom }}
        </h5>

        <p class="mb-1"><strong>Filière :</strong> {{ $carte->etudiant->filiere }}</p>
        <p class="mb-1"><strong>Niveau :</strong> {{ $carte->etudiant->niveau }}</p>

        <p class="statut
            {{ $carte->statut === 'active' ? 'active' : '' }}
            {{ $carte->statut === 'suspendue' ? 'suspendue' : '' }}
            {{ $carte->statut === 'expiree' ? 'expiree' : '' }}">
            Statut : {{ strtoupper($carte->statut) }}
        </p>

        <hr>

        <img src="{{ asset('storage/' . $carte->qr_code) }}" width="160" alt="QR Code">

        <p class="mt-2 text-muted" style="font-size: 13px;">
            N° Carte : {{ $carte->numero_carte }}
        </p>
    </div>
</div>

</body>
</html>

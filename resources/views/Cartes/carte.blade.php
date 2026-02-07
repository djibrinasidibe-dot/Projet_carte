<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Carte Étudiant - {{ $carte->etudiant->prenom }} {{ $carte->etudiant->nom }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #e0e3e8;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .carte {
            background: #fff;
            width: 480px;
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0,0,0,0.25);
            overflow: hidden;
            display: flex;
            flex-direction: row;
        }

        /* Partie gauche colorée avec photo et nom */
        .left {
            background-color: #007bff; /* couleur école */
            width: 40%;
            padding: 20px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .left img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #fff;
            object-fit: cover;
            margin-bottom: 15px;
        }

        .left h2 {
            font-size: 1.2rem;
            margin: 0;
            text-align: center;
        }

        /* Partie droite avec infos et QR Code */
        .right {
            padding: 20px;
            width: 60%;
            position: relative;
        }

        .info {
            margin-bottom: 8px;
        }

        .info p {
            margin: 4px 0;
            font-size: 0.95rem;
            color: #333;
        }

        .statut {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 8px;
            color: #fff;
            display: inline-block;
            margin-top: 5px;
        }

        .statut.active { background-color: #28a745; }
        .statut.suspendue { background-color: #fd7e14; }
        .statut.expirée { background-color: #dc3545; }

        .qr-code {
            position: absolute;
            bottom: 20px;
            right: 20px;
        }

        .qr-code img {
            width: 80px;
            height: 80px;
        }

        .numero {
            font-size: 0.85rem;
            color: #666;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<div class="carte">
    <div class="left">
        <img src="{{ asset('storage/'.$carte->etudiant->photo) }}" alt="Photo">
        <h2>{{ $carte->etudiant->prenom }}<br>{{ $carte->etudiant->nom }}</h2>
    </div>
    <div class="right">
        <div class="info"><strong>INE :</strong> {{ $carte->etudiant->ine }}</div>
        <div class="info"><strong>Filière :</strong> {{ $carte->etudiant->filiere }}</div>
        <div class="info"><strong>Niveau :</strong> {{ $carte->etudiant->niveau }}</div>
        <div class="info"><strong>Année :</strong> {{ $carte->etudiant->annee_academique }}</div>

        <div class="statut {{ strtolower($carte->statut) }}">
            {{ ucfirst($carte->statut) }}
        </div>

        <div class="numero">
            Carte N° {{ $carte->numero_carte }}
        </div>

        <div class="qr-code">
            <img src="{{ asset('storage/'.$carte->qr_code) }}" alt="QR Code">
        </div>
    </div>
</div>

</body>
</html>

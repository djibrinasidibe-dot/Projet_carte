@extends('layouts.app')

@section('title', 'Liste des cartes')

@section('content')
<style>
    /* Dropdown Menu Styles */
    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        background-color: transparent;
        border: none;
        cursor: pointer;
        padding: 8px;
        font-size: 20px;
        color: #666;
        border-radius: 4px;
    }

    .dropdown-toggle:hover {
        background-color: #f0f0f0;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        right: 0;
        background-color: white;
        min-width: 160px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        border-radius: 4px;
        z-index: 1000;
        overflow: hidden;
    }

    .dropdown-menu.show {
        display: block;
    }

    .dropdown-item {
        padding: 12px 16px;
        cursor: pointer;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        font-size: 14px;
        color: #333;
        transition: background-color 0.2s;
    }

    .dropdown-item:hover {
        background-color: #f5f5f5;
    }

    .dropdown-item.activate {
        color: #28a745;
    }

    .dropdown-item.suspend {
        color: #ffc107;
    }

    .dropdown-item.expire {
        color: #dc3545;
    }

    .dropdown-divider {
        height: 1px;
        background-color: #e0e0e0;
        margin: 4px 0;
    }

    .actions-cell {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }

    .qr-code-container {
        width: 80px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .qr-code-container canvas {
        max-width: 100%;
        height: auto;
    }

    .status-active {
        color: #28a745;
        font-weight: 500;
    }

    .status-suspended {
        color: #ffc107;
        font-weight: 500;
    }

    .status-expired {
        color: #dc3545;
        font-weight: 500;
    }

    /* Card Modal Styles */
    .card-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.7);
        overflow: auto;
    }

    .card-modal.show {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-modal-content {
        background-color: #f5f5f5;
        padding: 30px;
        border-radius: 10px;
        max-width: 500px;
        width: 90%;
        position: relative;
    }

    .card-close {
        position: absolute;
        right: 15px;
        top: 15px;
        font-size: 28px;
        font-weight: bold;
        color: #666;
        cursor: pointer;
        background: none;
        border: none;
    }

    .card-close:hover {
        color: #000;
    }

    /* Student Card Design */
    .student-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        position: relative;
        overflow: hidden;
    }

    .student-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    }

    .card-header-section {
        text-align: center;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }

    .card-title {
        font-size: 20px;
        font-weight: bold;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .card-subtitle {
        font-size: 12px;
        opacity: 0.9;
        margin-top: 5px;
    }

    .card-body-section {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
    }

    .student-photo {
        width: 100px;
        height: 120px;
        border-radius: 10px;
        object-fit: cover;
        border: 3px solid rgba(255,255,255,0.3);
        background-color: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
    }

    .student-info {
        flex: 1;
    }

    .info-row {
        margin-bottom: 10px;
    }

    .info-label {
        font-size: 11px;
        opacity: 0.8;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-value {
        font-size: 16px;
        font-weight: 600;
        margin-top: 2px;
    }

    .card-footer-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 15px;
        border-top: 1px solid rgba(255,255,255,0.3);
        position: relative;
        z-index: 1;
    }

    .qr-code-display {
        background: white;
        padding: 10px;
        border-radius: 8px;
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card-number-display {
        flex: 1;
        padding-left: 15px;
    }

    .card-number-label {
        font-size: 10px;
        opacity: 0.8;
    }

    .card-number-value {
        font-size: 14px;
        font-weight: bold;
        font-family: 'Courier New', monospace;
        margin-top: 5px;
    }

    .expiry-date {
        font-size: 11px;
        opacity: 0.8;
        margin-top: 8px;
    }

    .card-actions-buttons {
        margin-top: 20px;
        display: flex;
        gap: 10px;
        justify-content: center;
    }

    .btn-card-action {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s;
    }

    .btn-print {
        background-color: #28a745;
        color: white;
    }

    .btn-print:hover {
        background-color: #218838;
        transform: translateY(-2px);
    }

    .btn-download {
        background-color: #007bff;
        color: white;
    }

    .btn-download:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    /* Print styles */
    @media print {
        body * {
            visibility: hidden;
        }
        .student-card, .student-card * {
            visibility: visible;
        }
        .student-card {
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }
        .card-actions-buttons {
            display: none !important;
        }
    }
</style>

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
                <tr data-card-id="{{ $carte->id }}">
                    <td>{{ $carte->id }}</td>
                    <td>{{ $carte->numero_carte }}</td>
                    <td>{{ $carte->etudiant->nom }} {{ $carte->etudiant->prenom }}</td>
                    <td>
                        <span class="status-{{ $carte->statut == 'active' ? 'active' : ($carte->statut == 'suspendue' ? 'suspended' : 'expired') }}">
                            {{ $carte->statut }}
                        </span>
                    </td>
                    <td>{{ $carte->date_expiration }}</td>
                    <td>
                        <div class="qr-code-container" id="qrcode-{{ $carte->id }}"></div>
                    </td>
                    <td>
                        <div class="actions-cell">
                            <button class="btn btn-info btn-sm" onclick="afficherCarte({{ $carte->id }})">
                                👁️ Voir carte
                            </button>
                            <a href="{{ route('cartes.edit', $carte->id) }}" class="btn btn-warning btn-sm">Modifier</a>
                            <form action="{{ route('cartes.destroy', $carte->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer cette carte ?')">Supprimer</button>
                            </form>
                            
                            <!-- Dropdown Menu -->
                            <div class="dropdown">
                                <button class="dropdown-toggle" onclick="toggleDropdown(event, {{ $carte->id }})">⋮</button>
                                <div class="dropdown-menu" id="dropdown-{{ $carte->id }}">
                                    <button class="dropdown-item activate" onclick="activerCarte({{ $carte->id }})">✓ Activer la carte</button>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item suspend" onclick="suspendreCarte({{ $carte->id }})">⏸ Suspendre la carte</button>
                                    <div class="dropdown-divider"></div>
                                    <button class="dropdown-item expire" onclick="expirerCarte({{ $carte->id }})">✕ Expirer la carte</button>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">Aucune carte trouvée</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal pour afficher la carte -->
<div id="cardModal" class="card-modal">
    <div class="card-modal-content">
        <button class="card-close" onclick="fermerModal()">&times;</button>
        <div id="cardDisplay"></div>
        <div class="card-actions-buttons">
            <button class="btn-card-action btn-print" onclick="imprimerCarte()">
                🖨️ Imprimer
            </button>
            <button class="btn-card-action btn-download" onclick="telechargerPDF()">
                📥 Télécharger PDF
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    // Données des cartes pour la modal
    const cartesData = {
        @foreach($cartes as $carte)
        {{ $carte->id }}: {
            id: {{ $carte->id }},
            numero: "{{ $carte->numero_carte }}",
            nom: "{{ $carte->etudiant->nom }}",
            prenom: "{{ $carte->etudiant->prenom }}",
            ine: "{{ $carte->etudiant->ine }}",
            filiere: "{{ $carte->etudiant->filiere ?? 'N/A' }}",
            niveau: "{{ $carte->etudiant->niveau ?? 'N/A' }}",
            photo: "{{ $carte->etudiant->photo ? asset($carte->etudiant->photo) : '' }}",
            date_expiration: "{{ $carte->date_expiration }}",
            statut: "{{ $carte->statut }}"
        },
        @endforeach
    };

    // Afficher la carte dans la modal
    function afficherCarte(carteId) {
        const carte = cartesData[carteId];
        if (!carte) return;

        const cardDisplay = document.getElementById('cardDisplay');
        cardDisplay.innerHTML = `
            <div class="student-card" id="printable-card">
                <div class="card-header-section">
                    <h2 class="card-title">Carte Étudiante</h2>
                    <p class="card-subtitle">Année Académique 2024-2025</p>
                </div>
                
                <div class="card-body-section">
                    <div class="student-photo">
                        ${carte.photo ? 
                            `<img src="${carte.photo}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">` : 
                            '👤'
                        }
                    </div>
                    
                    <div class="student-info">
                        <div class="info-row">
                            <div class="info-label">Nom complet</div>
                            <div class="info-value">${carte.nom} ${carte.prenom}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">INE</div>
                            <div class="info-value">${carte.ine}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Filière</div>
                            <div class="info-value">${carte.filiere}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Niveau</div>
                            <div class="info-value">${carte.niveau}</div>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer-section">
                    <div class="qr-code-display" id="modal-qr-${carteId}"></div>
                    <div class="card-number-display">
                        <div class="card-number-label">N° Carte</div>
                        <div class="card-number-value">${carte.numero}</div>
                        <div class="expiry-date">Expire le: ${carte.date_expiration}</div>
                    </div>
                </div>
            </div>
        `;

        // Générer le QR code dans la modal
        setTimeout(() => {
            const qrContainer = document.getElementById(`modal-qr-${carteId}`);
            qrContainer.innerHTML = '';
            new QRCode(qrContainer, {
                text: carte.numero,
                width: 80,
                height: 80,
                colorDark: "#000000",
                colorLight: "#ffffff",
                correctLevel: QRCode.CorrectLevel.H
            });
        }, 100);

        // Afficher la modal
        document.getElementById('cardModal').classList.add('show');
    }

    // Fermer la modal
    function fermerModal() {
        document.getElementById('cardModal').classList.remove('show');
    }

    // Fermer la modal en cliquant en dehors
    window.onclick = function(event) {
        const modal = document.getElementById('cardModal');
        if (event.target === modal) {
            fermerModal();
        }
    }

    // Imprimer la carte
    function imprimerCarte() {
        window.print();
    }

    // Télécharger en PDF
    function telechargerPDF() {
        const element = document.getElementById('printable-card');
        const opt = {
            margin: 10,
            filename: 'carte-etudiant.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }

    // Toggle dropdown menu
    function toggleDropdown(event, cardId) {
        event.stopPropagation();
        const dropdown = document.getElementById(`dropdown-${cardId}`);
        
        // Close all other dropdowns
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            if (menu.id !== `dropdown-${cardId}`) {
                menu.classList.remove('show');
            }
        });
        
        // Toggle current dropdown
        dropdown.classList.toggle('show');
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.matches('.dropdown-toggle')) {
            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });

    // Activer une carte
    function activerCarte(cardId) {
        if (confirm('Voulez-vous vraiment activer cette carte ?')) {
            fetch(`/cartes/${cardId}/activer`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Carte activée:', data);
                updateCardStatus(cardId, 'active');
                alert('Carte activée avec succès !');
                location.reload();
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'activation de la carte');
            });
        }
        
        document.getElementById(`dropdown-${cardId}`).classList.remove('show');
    }

    // Expirer une carte
    function expirerCarte(cardId) {
        if (confirm('Voulez-vous vraiment expirer cette carte ?')) {
            fetch(`/cartes/${cardId}/expirer`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Carte expirée:', data);
                updateCardStatus(cardId, 'expiree');
                alert('Carte expirée avec succès !');
                location.reload();
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de l\'expiration de la carte');
            });
        }
        
        document.getElementById(`dropdown-${cardId}`).classList.remove('show');
    }

    // Suspendre une carte
    function suspendreCarte(cardId) {
        if (confirm('Voulez-vous vraiment suspendre cette carte ?')) {
            fetch(`/cartes/${cardId}/suspendre`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log('Carte suspendue:', data);
                updateCardStatus(cardId, 'suspendue');
                alert('Carte suspendue avec succès !');
                location.reload();
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors de la suspension de la carte');
            });
        }
        
        document.getElementById(`dropdown-${cardId}`).classList.remove('show');
    }

    // Mettre à jour le statut de la carte dans l'interface
    function updateCardStatus(cardId, newStatus) {
        const row = document.querySelector(`tr[data-card-id="${cardId}"]`);
        const statusCell = row.querySelector('td:nth-child(4) span');
        
        if (newStatus === 'active') {
            statusCell.textContent = 'active';
            statusCell.className = 'status-active';
        } else if (newStatus === 'suspendue') {
            statusCell.textContent = 'suspendue';
            statusCell.className = 'status-suspended';
        } else if (newStatus === 'expiree') {
            statusCell.textContent = 'expiree';
            statusCell.className = 'status-expired';
        }
    }

    // Générer les QR Codes au chargement de la page
    window.addEventListener('DOMContentLoaded', function() {
        @foreach($cartes as $carte)
            generateQRCode('qrcode-{{ $carte->id }}', '{{ $carte->numero_carte }}');
        @endforeach
    });

    // Fonction pour générer un QR Code
    function generateQRCode(elementId, cardNumber) {
        const container = document.getElementById(elementId);
        if (!container) return;
        
        container.innerHTML = '';
        
        new QRCode(container, {
            text: cardNumber,
            width: 80,
            height: 80,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.H
        });
    }
</script>
@endsection
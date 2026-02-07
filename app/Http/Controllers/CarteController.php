<?php

namespace App\Http\Controllers;

use App\Models\Carte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class CarteController extends Controller
{
    /**
     * Affiche la liste des cartes étudiantes
     */
    public function index()
    {
        $cartes = Carte::with('etudiant')->get();
        return view('cartes.index', compact('cartes'));
    }
    
    public function edit($id)
    {
        $carte = Carte::with('etudiant')->findOrFail($id);

        return view('cartes.edit', compact('carte'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'statut' => 'required|in:active,suspendue,expiree',
            'date_expiration' => 'required|date',
        ]);

        $carte = Carte::findOrFail($id);
        $carte->update($request->only(['statut', 'date_expiration']));

        return redirect()->route('cartes.index')
            ->with('success', 'Carte mise à jour avec succès');
    }

    /**
     * Crée une nouvelle carte étudiante
     */
    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'etudiant_id' => 'required|exists:etudiants,id',
        ]);

        // Création de la carte
        $numeroCarte = uniqid('CARTE-');
        $carte = Carte::create([
            'etudiant_id'    => $validated['etudiant_id'],
            'numero_carte'   => $numeroCarte,
            'statut'         => 'active',
            'date_expiration' => now()->addYear(),
        ]);

        // Chemin du QR code
        $qrPath = 'qr/' . $numeroCarte . '.png';

        // Génération du QR code avec URL correcte
        $result = Builder::create()
            ->writer(new PngWriter())
            ->data(url('/cartes/public/' . $numeroCarte)) // ← URL complète avec IP
            ->size(300)
            ->margin(10)
            ->build();

        // Sauvegarde dans storage/app/public/qr
        Storage::disk('public')->put($qrPath, $result->getString());

        // Mise à jour de la carte avec le chemin du QR
        $carte->update(['qr_code' => 'storage/' . $qrPath]);

        return response()->json([
            'message' => 'Carte créée avec succès',
            'carte'   => $carte
        ]);
    }
    
    /**
     * Supprime une carte
     */
    public function destroy($id)
    {
        $carte = Carte::findOrFail($id);

        // Supprime le fichier QR code du storage
        if ($carte->qr_code && Storage::disk('public')->exists($carte->qr_code)) {
            Storage::disk('public')->delete($carte->qr_code);
        }

        // Supprime la carte de la base de données
        $carte->delete();

        return redirect()->route('cartes.index')
            ->with('success', 'Carte supprimée');
    }
    
    /**
     * Page publique accessible via QR code
     */
    public function publicPage($numero)
    {
        $carte = Carte::with('etudiant')->where('numero_carte', $numero)->firstOrFail();
        return view('carte.public', compact('carte'));
    }

    /**
     * Mise à jour du statut
     */
    public function updateStatus(Request $request, $id)
    {
        $carte = Carte::findOrFail($id);

        $validated = $request->validate([
            'statut' => 'required|in:active,suspendue,expiree',
        ]);

        $carte->update(['statut' => $validated['statut']]);

        return redirect()->route('cartes.index')->with('success', 'Statut mis à jour avec succès.');
    }

    /**
     * Activer une carte
     */
    public function activer($id)
    {
        try {
            $carte = Carte::findOrFail($id);
            $carte->statut = 'active';
            $carte->save();

            return response()->json([
                'success' => true,
                'message' => 'Carte activée avec succès',
                'carte' => $carte
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'activation de la carte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Expirer une carte
     */
    public function expirer($id)
    {
        try {
            $carte = Carte::findOrFail($id);
            $carte->statut = 'expiree'; // CORRECTION: changé de 'expired' à 'expiree'
            $carte->save();

            return response()->json([
                'success' => true,
                'message' => 'Carte expirée avec succès',
                'carte' => $carte
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'expiration de la carte',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Suspendre une carte
     */
    public function suspendre($id)
    {
        try {
            $carte = Carte::findOrFail($id);
            $carte->statut = 'suspendue';
            $carte->save();

            return response()->json([
                'success' => true,
                'message' => 'Carte suspendue avec succès',
                'carte' => $carte
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suspension de la carte',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
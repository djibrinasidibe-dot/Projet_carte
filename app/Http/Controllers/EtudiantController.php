<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use App\Models\Carte;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Support\Facades\Storage;

class EtudiantController extends Controller
{
    public function index()
    {
        $etudiants = Etudiant::all();
        return view('etudiants.index', compact('etudiants'));
    }

    public function create()
    {
        return view('etudiants.create');
    }

    public function store(Request $request)
    {
        // 1️⃣ Validation
        $validated = $request->validate([
            'ine' => 'required|unique:etudiants',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'filiere' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'annee_academique' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // 2️⃣ Upload photo
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        // 3️⃣ Création étudiant
        $etudiant = Etudiant::create($validated);

        // 4️⃣ Numéro de carte
        $numeroCarte = 'CARTE-' . Str::upper(Str::random(10));

        // 5️⃣ Chemin QR (RELATIF)
        $qrPath = 'qrcodes/' . $numeroCarte . '.svg';

        // 6️⃣ Génération QR (PNG recommandé)
        $result = Builder::create()
            ->writer(new SvgWriter())
            ->data(url('/carte-public/' . $numeroCarte))
            ->size(300)
            ->margin(10)
            ->build();

        // 7️⃣ Sauvegarde QR dans storage/app/public/qr
        Storage::disk('public')->put($qrPath, $result->getString());

        // 8️⃣ Création carte
        Carte::create([
            'etudiant_id' => $etudiant->id,
            'numero_carte' => $numeroCarte,
            'qr_code' => $qrPath,
            'statut' => 'active',
            'date_expiration' => now()->addYear(),
        ]);

        // 9️⃣ Redirection
        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant et carte créés avec succès !');
    }

    public function edit(string $id)
    {
        $etudiant = Etudiant::findOrFail($id);
        return view('etudiants.edit', compact('etudiant'));
    }

    public function update(Request $request, string $id)
    {
        $etudiant = Etudiant::findOrFail($id);

        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'ine' => 'required|string|unique:etudiants,ine,' . $etudiant->id,
            'filiere' => 'required|string|max:255',
            'niveau' => 'required|string|max:255',
            'annee_academique' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('photos', 'public');
        }

        $etudiant->update($validated);

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant mis à jour avec succès.');
    }

    public function destroy(string $id)
    {
        $etudiant = Etudiant::findOrFail($id);
        $etudiant->delete();

        return redirect()->route('etudiants.index')
            ->with('success', 'Étudiant supprimé avec succès.');
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\Carte;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;


class CarteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Carte::with('etudiant')->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
    {
        
    // Validation des données reçues
    $validated = $request->validate([
        'etudiant_id' => 'required|exists:etudiant,id', // vérifie que l'étudiant existe
    ]);

    // Création de la carte
    $carte = Carte::create([
        'etudiant_id'    => $validated['etudiant_id'],
        'numero_carte'   => uniqid('CARTE-'), // numéro unique
        'statut'         => 'active',
        'date_expiration'=> now()->addYear(), // expiration dans 1 an
    ]);

    // Génération et sauvegarde du QR Code
    $qrPath = 'qrcodes/' . $carte->numero_carte . '.png';
    \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
        ->size(250)
        ->generate(url('/carte/' . $carte->numero_carte), public_path($qrPath));

    // Mise à jour de la carte avec le chemin du QR Code
    $carte->update(['qr_code' => $qrPath]);

    // Réponse JSON pour Postman
    return response()->json([
        'message' => 'Carte créée avec succès',
        'carte'   => $carte
    ]);
}

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Carte::with('etudiant')->findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $carte = Carte::findOrFail($id); 
        $carte->update($request->all()); 
        return $carte;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Carte::destroy($id); 
        return response()->json(['message' => 'Carte supprimée']); 
    
    }
    public function publicPage($numero)
{
    // On récupère la carte avec son étudiant
    $carte = Carte::with('etudiant')->where('numero_carte', $numero)->firstOrFail();

    // On retourne une vue Blade
    return view('carte.public', compact('carte'));
}
public function updateStatus(Request $request, $id)
{
    $carte = Carte::findOrFail($id);

    $validated = $request->validate([
        'statut' => 'required|in:active,suspendue,expiree',
    ]);

    $carte->update(['statut' => $validated['statut']]);

    return redirect()->route('cartes.index')->with('success', 'Statut de la carte mis à jour avec succès.');
}


}


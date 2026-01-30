<?php

namespace App\Http\Controllers;

use App\Models\Etudiant;
use Illuminate\Http\Request;

class EtudiantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $etudiants = Etudiant::all(); 
        return view('etudiants.index', compact('etudiants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('etudiants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([ 
            'ine' => 'required|unique:etudiants', 
            'nom' => 'required', 
            'prenom' => 'required', 
            'filiere' => 'required', 
            'niveau' => 'required', 
            'annee_academique' => 'required', 
            'photo' => 'nullable|string', 
            ]); 
            return Etudiant::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        return Etudiant::findOrFail($id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $etudiant = Etudiant::findOrFail($id); 
        return view('etudiants.edit', compact('etudiant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
         $etudiant = Etudiant::findOrFail($id); 
         $validated = $request->validate([
             'nom' => 'required|string|max:255', 
             'prenom' => 'required|string|max:255', 
             'ine' => 'required|string|unique:etudiant,ine,' . $etudiant->id,
             'filiere' => 'required|string|max:255', 
             'niveau' => 'required|string|max:255', 
             'annee_academique' => 'required|string|max:255', 
             'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', 
             ]); 
             
             if ($request->hasFile('photo')) {
                 $validated['photo'] = $request->file('photo')->store('photos', 'public');
              } 
              
              $etudiant->update($validated); 
              return redirect()->route('etudiants.index')->with('success', 'Étudiant mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $etudiant = Etudiant::findOrFail($id); 
        $etudiant->delete(); 
        return redirect()->route('etudiants.index')->with('success', 'Étudiant supprimé avec succès.');
    }
}

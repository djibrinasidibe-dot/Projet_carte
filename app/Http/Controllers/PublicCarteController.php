<?php

namespace App\Http\Controllers;

use App\Models\Carte;
use Illuminate\Http\Request;

class PublicCarteController extends Controller
{
    public function show($numero)
    {
        $carte = Carte::where('numero_carte', $numero)
            ->with('etudiant')
            ->firstOrFail();

        return view('public.carte', compact('carte'));
    }
}

<?php

use Illuminate\Support\Facades\Route;
//use App\Http\Controllers\EtudiantController;
//use App\Http\Controllers\CarteController;


Route::get('/', function () {
    return view('welcome');
});

// Routes CRUD pour les étudiants 
//Route::resource('etudiants', EtudiantController::class); 

// Routes CRUD pour les cartes 
//Route::resource('cartes', CarteController::class); 

// Route publique pour afficher une carte via QR Code 
//Route::get('/carte/{numero}', [CarteController::class, 'publicPage']);

//Route::put('/cartes/{id}/statut', [CarteController::class, 'updateStatus'])->name('cartes.updateStatus');

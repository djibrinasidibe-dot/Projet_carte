<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\CarteController;
use App\Http\Controllers\PublicCarteController;



Route::get('/', function () {
    return view('welcome');
});

 //Routes CRUD pour les étudiants 
Route::resource('/etudiants', EtudiantController::class); 
// Routes CRUD pour les cartes 
Route::resource('/cartes', CarteController::class); 

 //Route publique pour afficher une carte via QR Code 
Route::get('/carte/{numero}', [PublicCarteController::class, 'show'])
    ->name('carte.public');


Route::put('/cartes/{id}/statut', [CarteController::class, 'updateStatus'])->name('cartes.updateStatus');
Route::post('/cartes/{id}/activer', [CarteController::class, 'activer'])->name('cartes.activer');
Route::post('/cartes/{id}/suspendre', [CarteController::class, 'suspendre'])->name('cartes.suspendre');
Route::post('/cartes/{id}/expirer', [CarteController::class, 'expirer'])->name('cartes.expirer');
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    //
    
    protected $fillable = [ 
        'ine', 
        'nom', 
        'prenom', 
        'filiere', 
        'niveau', 
        'annee_academique', 
        'photo', 
        ];
        // Relation avec la carte (1 étudiant = 1 carte) 
        public function carte() { 
            return $this->hasOne(Carte::class); 
            }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carte extends Model
{
    //
    protected $table = 'carte'; // préciser le nom singulier 
    
    protected $fillable = [ 
        'etudiant_id', 
        'numero_carte', 
        'qr_code', 
        'statut', 
        'date_expiration', 
        ]; 
        public function etudiant() { 
            return $this->belongsTo(Etudiant::class); 
            }
}

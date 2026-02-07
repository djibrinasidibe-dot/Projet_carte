<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\SvgWriter;
use Illuminate\Support\Str;

class Carte extends Model
{
    use HasFactory;

    protected $fillable = [
        'etudiant_id',
        'numero_carte',
        'qr_code',
        'statut',
        'date_expiration',
    ];

    // Relation avec étudiant
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class);
    }

    // Générer la carte avec QR automatiquement
    public static function createWithQr($etudiantId)
    {
        $numeroCarte = 'CARTE-' . Str::upper(Str::random(10));

        $qrPath = 'qr/' . $numeroCarte . '.svg';

        // Génération du QR code
        $result = Builder::create()
            ->writer(new SvgWriter()) // SVG ou PNG
            ->data(url('/carte-public/' . $numeroCarte)) // URL publique du QR
            ->size(300)
            ->margin(10)
            ->build();

        // Sauvegarder le QR dans storage/app/public/qr
        $fullPath = storage_path('app/public/' . $qrPath);
        file_put_contents($fullPath, $result->getString());

        // Créer la carte
        return self::create([
            'etudiant_id' => $etudiantId,
            'numero_carte' => $numeroCarte,
            'qr_code' => $qrPath,
            'statut' => 'active',
            'date_expiration' => now()->addYear(), // 1 an
        ]);
    }
}

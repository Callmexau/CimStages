<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'demande_id',
        'poste',
        'scores',
        'commentaires',
        'recommandation',
        'note_finale',
    ];

    protected $casts = [
        'scores' => 'array',
        'note_finale' => 'decimal:2',
    ];

    public function demande()
    {
        return $this->belongsTo(DemandeStage::class, 'demande_id');
    }
}
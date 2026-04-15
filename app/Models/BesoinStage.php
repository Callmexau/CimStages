<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BesoinStage extends Model
{
    use HasFactory;

    protected $table = 'besoins_stages';

    protected $fillable = [
        'responsable_id',  
        'structure_id',
        'departement',
        'poste', 
        'responsable_nom',
        'fonction',
        'date_requete',
        'type_demande',
        'motifs',
        'autres_motifs',
        'service',
        'encadrant',
        'domaine_formation',
        'niveau_etudes',
        'competences',
        'duree',
        'nombre_stagiaires',
        'periode',
        'statut',
        'demande_stage_id',
    ];

    protected $casts = [
        'motifs' => 'array',
        'date_requete' => 'date',
    ];

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function demandes()
    {
        return $this->hasMany(DemandeStage::class, 'besoin_id');
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function demandeStage()
    {
        return $this->belongsTo(DemandeStage::class, 'demande_stage_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'niveau_etude',
        'filiere',
        'experience_professionnelle',
        'universite',
        'structure_id',
        'telephone',
        'cv_path',
        'cnib_path',
        'statut',
    ];

    public function stagiaire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }


}

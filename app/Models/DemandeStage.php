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
        'type_stage',
        'responsable_id',
        'debut_stage',
        'fin_stage',
        'is_renewal',
        'parent_id',
    ];

    protected $casts = [
        'debut_stage' => 'datetime',
        'fin_stage' => 'datetime',
        'is_renewal' => 'boolean',
    ];

    public function stagiaire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function structure()
    {
        return $this->belongsTo(Structure::class);
    }

    public function responsable()
    {
        return $this->belongsTo(User::class, 'responsable_id');
    }

    public function evaluation()
    {
        return $this->hasOne(\App\Models\Evaluation::class, 'demande_id');
    }

    public function parent()
    {
        return $this->belongsTo(DemandeStage::class, 'parent_id');
    }

    public function renewals()
    {
        return $this->hasMany(DemandeStage::class, 'parent_id');
    }

    public function besoins()
    {
        return $this->hasMany(BesoinStage::class, 'demande_stage_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationStage extends Model
{
    use HasFactory;

    protected $table = 'evaluation_stages';

    protected $fillable = [
        'stagiaire_id',
        'responsable_id',
        'service',
        'fonction',
        'periode',
        'evaluations',
        'commentaires',
        'recommandation',
        'date_evaluation',
    ];

    protected $casts = [
        'evaluations' => 'array',
        'date_evaluation' => 'date',
    ];
}

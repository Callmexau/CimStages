<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Structure extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'abbreviation', 'description'];

    // Relation inverse : une structure a plusieurs utilisateurs
    public function users()
    {
        return $this->hasMany(User::class);
    }

}

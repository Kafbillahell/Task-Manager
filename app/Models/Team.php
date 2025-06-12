<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Project; // Import Project agar relasi bisa dipakai

class Team extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /**
     * Relasi One-to-Many ke Project
     * Satu Team punya banyak Project
     */
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}

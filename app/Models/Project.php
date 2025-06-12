<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'team_id', 'created_by'];

    // Relasi ke team
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // Relasi ke user yang buat project
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

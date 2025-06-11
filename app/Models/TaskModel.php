<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskModel extends Model
{
    //
    protected $fillable = ['title', 'description', 'project_id', 'assigned_to', 'created_by', 'status', 'order', 'likes_count'];
    protected $table = 'task';


     public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // public function comments()
    // {
    //     return $this->hasMany(TaskComment::class)->with('user')->latest();
    // }

    // public function likes()
    // {
    //     return $this->hasMany(TaskLike::class);
    // }

    public function isLikedBy($userId)
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    public function updateLikesCount()
    {
        $this->likes_count = $this->likes()->count();
        $this->save();
    }


}

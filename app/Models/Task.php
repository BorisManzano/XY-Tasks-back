<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'task', 'details', 'status'];

    protected $dates = ['completed_at'];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
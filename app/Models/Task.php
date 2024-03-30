<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'task', 'details', 'status', 'comments'];

    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }
}

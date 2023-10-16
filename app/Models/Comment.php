<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $guarded = ['id'];

    public function post()
    {
    	return $this->belongsTo(Post::class);
    }

    public function commentator()
    {
    	return $this->belongsTo(User::class, 'user_id', 'id');
    }
}

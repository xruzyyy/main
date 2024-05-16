<?php

// Comment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Posts;


class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Posts::class);
    }
    public function category()
    {
        return $this->belongsTo(Posts::class, 'posts_id');
    }

}

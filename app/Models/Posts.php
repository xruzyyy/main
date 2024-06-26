<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Posts extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'businessName',
        'description',
        'images',
        'is_active',
        'user_id',
        'user_email',
        'latitude',
        'longitude',
        'type',
        'contactNumber',
        'monday_open',
        'monday_close',
        'tuesday_open',
        'tuesday_close',
        'wednesday_open',
        'wednesday_close',
        'thursday_open',
        'thursday_close',
        'friday_open',
        'friday_close',
        'saturday_open',
        'saturday_close',
        'sunday_open',
        'sunday_close',
    ];

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($post) {
            // Example logic upon update, adjust as needed
            // For example, update associated user status
            $user = User::find($post->user_id);
            $hasActivePosts = $user->posts()->where('is_active', 1)->exists();
            $user->update(['status' => $hasActivePosts ? 1 : 0]);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'post_id');
    }
}

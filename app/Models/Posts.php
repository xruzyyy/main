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
    ];

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($category) {
            // Find the associated user
            $user = User::find($category->user_id);

            // Check if there are active categories for the user
            $hasActiveCategories = $user->categories()->where('is_active', 1)->exists();

            // Update the user's status based on active categories
            $user->update(['status' => $hasActiveCategories ? 1 : 0]);
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

    // Define the relationship with the Rating model
    public function ratings()
    {
        return $this->hasMany(Rating::class, 'post_id'); // Adjust 'post_id' to match your actual foreign key
    }

}

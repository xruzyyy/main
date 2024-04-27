<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = ['post_id', 'rating', 'user_id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($rating) {
            $post = $rating->post;
            $post->ratings_count++;
            $post->average_rating = ($post->average_rating * ($post->ratings_count - 1) + $rating->rating) / $post->ratings_count;
            $post->save();
        });

        static::deleted(function ($rating) {
            $post = $rating->post;
            if ($post->ratings_count > 0) {
                $post->ratings_count--;
                if ($post->ratings_count == 0) {
                    $post->average_rating = 0;
                } else {
                    $ratings = $post->ratings;
                    $ratingsSum = $ratings->sum('rating');
                    $post->average_rating = $ratingsSum / $post->ratings_count;
                }
                $post->save();
            }
        });
    }

    public function post()
    {
        return $this->belongsTo(Posts::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function searchCategories(Request $request)
    {
        // Retrieve search query and category from the request
        $searchQuery = $request->input('search');
        $category = $request->input('category');

        // Retrieve unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();

        // Query posts
        $postsQuery = Posts::query();

        // Apply search query
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply category filter
        if ($category) {
            $postsQuery->where('type', $category);
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select(
                        'posts.*',
                        DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'),
                        DB::raw('COUNT(ratings.id) as rating_count')
                    )
                    ->groupBy('posts.id')
                    ->orderByDesc('avg_rating')
                    ->orderByDesc('rating_count');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderByDesc('comments_count');
            }
        }

        // Paginate the results with 10 posts per page
        $posts = $postsQuery->paginate();

        // Calculate weighted score for each post
        foreach ($posts as $post) {
            $post->weighted_score = $this->calculateWeightedScore($post->avg_rating, $post->rating_count);
        }

        // Sort posts based on weighted score
        $posts = $posts->sortByDesc('weighted_score');

        // Pass the retrieved posts to the view for display
        return view('business-section.business-categories.searchResults', [
            'posts' => $posts,
            'unseenCount' => $unseenCount,
        ]);
    }

    // Function to calculate weighted score
    private function calculateWeightedScore($avgRating, $ratingCount)
    {
        // Define weights for average rating and rating count
        $avgRatingWeight = 0.7; // Adjust as needed
        $ratingCountWeight = 0.3; // Adjust as needed

        // Calculate weighted score
        $weightedScore = ($avgRating * $avgRatingWeight) + ($ratingCount * $ratingCountWeight);

        return $weightedScore;
    }
}

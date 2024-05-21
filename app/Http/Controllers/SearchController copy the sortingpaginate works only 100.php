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
                $postsQuery->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select(
                        'posts.*',
                        DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'),
                        DB::raw('COUNT(ratings.id) as rating_count')
                    )
                    ->groupBy('posts.id')
                    ->orderByRaw('COALESCE(AVG(ratings.rating), 0) DESC')
                    ->orderByRaw('COUNT(ratings.id) DESC');
            } elseif ($request->input('sort_by') == 'comments') {
                // Sorting logic for highest comments
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 posts per page
        $posts = $postsQuery->paginate(100)->appends(request()->query());

        // Calculate weighted score for each post and update the collection
        $posts->getCollection()->transform(function ($post) {
            $post->weighted_score = $this->calculateWeightedScore($post->avg_rating ?? 0, $post->rating_count ?? 0);
            return $post;
        });

        // Sort posts based on weighted score if sorting by highest rating
        if ($request->input('sort_by') == 'highest_rating') {
            $posts->setCollection($posts->getCollection()->sortByDesc('weighted_score'));
        }

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

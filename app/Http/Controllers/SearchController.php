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
                        DB::raw('COUNT(ratings.id) as rating_count'),
                        DB::raw('COALESCE(AVG(ratings.rating) * 0.7 + LEAST(COUNT(ratings.id), 100) * 0.3, 0) as weighted_score')
                    )
                    ->groupBy('posts.id')
                    ->orderByDesc('weighted_score')
                    ->orderByDesc('rating_count');
            } elseif ($request->input('sort_by') == 'comments') {
                // Sorting logic for highest comments
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 posts per page
        $posts = $postsQuery->paginate(12)->appends(request()->query());

        // Pass the retrieved posts to the view for display
        return view('business-section.business-categories.searchResults', [
            'posts' => $posts,
            'unseenCount' => $unseenCount,
        ]);
    }
}

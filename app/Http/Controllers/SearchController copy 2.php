<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function searchCategories(Request $request)
    {
        // Retrieve search query and category from the request
        $searchQuery = $request->input('search');
        $category = $request->input('category');

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

        // Sorting logic
        $sort_by = $request->input('sort_by');
        switch ($sort_by) {
            case 'highest_rating':
                $postsQuery->withCount('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', \DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), \DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('rating_count', 'desc') // Prioritize by rating count
                    ->orderBy('avg_rating', 'desc');  // Then by average rating
                break;

            case 'highest_reviews':
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
                break;
            default:
                // Default sorting logic (you can adjust this based on your requirements)
                $postsQuery->orderBy('created_at', 'desc');
        }

        // Paginate the results with 10 posts per page
        $posts = $postsQuery->paginate(10);

        // Pass the retrieved posts to the view for display
        return view('business-section.business-categories.searchResults', [
            'posts' => $posts,
        ]);
    }
}

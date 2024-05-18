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
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        // Retrieve unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();

        // Query all categories
        $postsQuery = Posts::query();

        // Apply search if search query is provided
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if sort_by is provided
        if ($request->has('sort_by') && $request->input('sort_by') == 'highest_rating') {
            $postsQuery->with('ratings')
                ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                ->select('posts.*', DB::raw('AVG(ratings.rating) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                ->groupBy('posts.id')
                ->orderBy('avg_rating', 'desc')
                ->orderBy('rating_count', 'desc');
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate();

        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.searchResults', [
            'posts' => $posts,
            'unseenCount' => $unseenCount,
        ]);
    }
}

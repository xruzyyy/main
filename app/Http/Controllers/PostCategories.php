<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostCategories extends Controller
{

    public function showAccountingCategories(Request $request)
{
    // Retrieve search query from the request
    $searchQuery = $request->input('search');

    // Retrieve unseen message count
    $unseenCount = DB::table('ch_messages')
        ->where('to_id', '=', Auth::user()->id)
        ->where('seen', '=', '0')
        ->count();

    // Query posts
    $postsQuery = Posts::where('type', 'Accounting');

    // Apply search query
    if ($searchQuery) {
        $postsQuery->where(function ($query) use ($searchQuery) {
            $query->where('businessName', 'like', '%' . $searchQuery . '%')
                ->orWhere('description', 'like', '%' . $searchQuery . '%');
        });
    }

    // Apply sorting if provided
    if ($request->has('sort_by')) {
        if ($request->input('sort_by') == 'highest_rating') {
            // Sorting logic for highest rating with weighted score
            $postsQuery->with('ratings')
                ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                ->groupBy('posts.id');
        } elseif ($request->input('sort_by') == 'comments') {
            // Sorting logic for highest comments
            $postsQuery->withCount('comments')
                ->orderBy('comments_count', 'desc');
        }
    }

    // Paginate the results with 10 posts per page
    $posts = $postsQuery->paginate(100);

    // Calculate weighted score for each post if sorting by highest rating
    if ($request->input('sort_by') == 'highest_rating') {
        $posts->getCollection()->transform(function ($post) {
            $post->weighted_score = $this->calculateWeightedScore($post->avg_rating, $post->rating_count);
            return $post;
        });

        // Sort posts based on weighted score after pagination
        $posts = $posts->setCollection($posts->getCollection()->sortByDesc('weighted_score'));
    }

    // Pass the retrieved posts to the view for display
    return view('business-section.business-categories.businessAccounting', [
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



    public function showRetailCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        // Retrieve unseen message count
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();

        // Query posts
        $postsQuery = Posts::where('type', 'Retail');

        // Apply search query
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);

        return view('business-section.business-categories.businessRetail', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showFashionCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();

        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Fashion Photography Studios');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);

        return view('business-section.business-categories.businessFashion', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }
    public function showAutomotiveCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        // Retrieve categories from the database
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();

        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Automotive');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessAutomotive', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }
    public function showApparelExportersCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        // Retrieve categories from the database
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Apparel Exporters');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessApparelExporters', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showFashionPhotographyStudiosCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Fashion Photography Studios');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessFashionPhotographyStudios', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showHealthcareCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Healthcare');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessHealthcare', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showInformationTechnologyCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Information Technology');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessInformationTechnology', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }
    public function showShoppingMallsCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Shopping Malls');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessShoppingMalls', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showTradingGoodsCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Trading Goods');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessTradingGoods', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showConsultingCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Consulting');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessConsulting', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showBarberShopsCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Barbershop');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessBarberShops', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showConstructionCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Construction');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessConstruction', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showFashionConsultancyCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Fashion Consultancy');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessFashionConsultancy', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showBeautySalonCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Beauty Salon');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessBeautySalon', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showLogisticsCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Logistics');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessLogistics', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showSportsCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Sports');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessSports', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showPharmaceuticalsCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        // Retrieve categories from the database
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Pharmaceuticals');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessPharmaceuticals', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }


    public function showPetsCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Pets');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessPets', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showEntertainmentCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Entertainment');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessEntertainment', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showAgricultureCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        // Retrieve categories from the database
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Agriculture');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessAgriculture', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showEducationCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        // Retrieve categories from the database
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Education');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessEducation', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showFinanceCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        // Retrieve categories from the database
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Finance');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessFinance', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }


    public function showCoffeeShopsCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        // Retrieve categories from the database
        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Coffee Shops');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessCoffeeShops', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showPatternMakingServicesCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Pattern Making Services');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessPatternMakingServices', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showMaintenanceCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Maintenance');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessMaintenance', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showAutomativeCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Automotive');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessAutomative', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showEnvironmentalCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Environmental');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessEnvironmental', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showFoodBeveragesCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Food & Beverage');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessFoodBeverages', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showQuickServiceRestaurantsCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Quick Service Restaurants');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessQuickServiceRestaurants', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showGarmentManufacturingCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Garment Manufacturing');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessGarmentManufacturing', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showFashionEventsManagementCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Fashion Events Management');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessFashionEventsManagement', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showRetailClothingStoresCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Retail Clothing Stores');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessRetailClothingStores', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showFashionDesignStudiosCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Fashion Design Studios');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessFashionDesignStudios', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showShoeManufacturingCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Shoe Manufacturing');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessShoeManufacturing', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showTailoringAndAlterationsCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Tailoring and Alterations');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessTailoringAndAlterations', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }



    public function showFashionAccessoriesCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Fashion Accessories');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessFashionAccessories', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showBoutiquesCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Boutiques');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessBoutiques', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showApparelRecyclingAndUpcyclingCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $postsQuery = Posts::where('type', 'Apparel Recycling and Upcycling');
        if ($searchQuery) {
            $postsQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Apply sorting if provided
        if ($request->has('sort_by')) {
            if ($request->input('sort_by') == 'highest_rating') {
                // Sorting logic for highest rating
                $postsQuery->with('ratings')
                    ->leftJoin('ratings', 'posts.id', '=', 'ratings.post_id')
                    ->select('posts.*', DB::raw('COALESCE(AVG(ratings.rating), 0) as avg_rating'), DB::raw('COUNT(ratings.id) as rating_count'))
                    ->groupBy('posts.id')
                    ->orderBy('avg_rating', 'desc')
                    ->orderBy('rating_count', 'desc');
            } elseif ($request->input('sort_by') == 'highest_reviews') {
                // Sorting logic for highest reviews
                $postsQuery->withCount('comments')
                    ->orderBy('comments_count', 'desc');
            }
        }

        // Paginate the results with 10 businesses per page
        $posts = $postsQuery->paginate(10);
        return view('business-section.business-categories.businessApparelRecyclingAndUpcycling', [
            'posts' => $posts,
            'unseenCount' => $unseenCount
        ]);
    }

    public function show($id)
{
    // Count the unseen messages
    $unseenCount = DB::table('ch_messages')
        ->where('to_id', '=', Auth::user()->id)
        ->where('seen', '=', '0')
        ->count();

    // Retrieve the specific post by its ID, including the comments count
    $post = Posts::withCount('comments')->findOrFail($id);

    // Pass the post and unseenCount to the view
    return view('business-section.business-categories.business_post', compact('post', 'unseenCount'));
}




}

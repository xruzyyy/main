<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
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

        // Query categories based on search query or retrieve all if no search query provided
        $categoriesQuery = Category::where('type', 'Accounting');
        if ($searchQuery) {
            $categoriesQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Paginate the results with 10 businesses per page
        $categories = $categoriesQuery->paginate(9);

        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessAccounting', [
            'categories' => $categories,
            'unseenCount' => $unseenCount,
        ]);
    }


    public function showRetailCategories(Request $request)
    {
        // Retrieve search query from the request
        $searchQuery = $request->input('search');

        $unseenCount = DB::table('ch_messages')
            ->where('to_id', '=', Auth::user()->id)
            ->where('seen', '=', '0')
            ->count();
        // Query categories based on search query or retrieve all if no search query provided
        $categoriesQuery = Category::where('type', 'Retail');
        if ($searchQuery) {
            $categoriesQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Paginate the results with 10 businesses per page
        $categories = $categoriesQuery->paginate(9);

        return view('business-section.business-categories.businessRetail', [
            'categories' => $categories,
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
        $categoriesQuery = Category::where('type', 'Fashion Photography Studios');
        if ($searchQuery) {
            $categoriesQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Paginate the results with 10 businesses per page
        $categories = $categoriesQuery->paginate(9);

        return view('business-section.business-categories.businessFashion', [
            'categories' => $categories,
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
        $categoriesQuery = Category::where('type', 'Automotive');
        if ($searchQuery) {
            $categoriesQuery->where(function ($query) use ($searchQuery) {
                $query->where('businessName', 'like', '%' . $searchQuery . '%')
                    ->orWhere('description', 'like', '%' . $searchQuery . '%');
            });
        }

        // Paginate the results with 10 businesses per page
        $categories = $categoriesQuery->paginate(9);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessAutomotive', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type','Apparel Exporters');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessApparelExporters', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Fashion Photography Studios');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessFashionPhotographyStudios', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Healthcare');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessHealthcare', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Information Technology');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessInformationTechnology', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Shopping Malls');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessShoppingMalls', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Trading Goods');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessTradingGoods', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Consulting');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessConsulting', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Barbershop');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessBarberShops', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Construction');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessConstruction', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type','Fashion Consultancy');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessFashionConsultancy', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Beauty Salon');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessBeautySalon', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Logistics');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessLogistics', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Sports');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessSports', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Pharmaceuticals');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessPharmaceuticals', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Pets');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessPets', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Entertainment');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessEntertainment', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Agriculture');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessAgriculture', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Education');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessEducation', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Finance');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessFinance', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Coffee Shops');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessCoffeeShops', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Pattern Making Services');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessPatternMakingServices', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Maintenance');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessMaintenance', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Automotive');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessAutomative', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Environmental');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessEnvironmental', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Food & Beverage');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessFoodBeverages', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Quick Service Restaurants');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessQuickServiceRestaurants', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Garment Manufacturing');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessGarmentManufacturing', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Fashion Events Management');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessFashionEventsManagement', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Retail Clothing Stores');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessRetailClothingStores', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Fashion Design Studios');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessFashionDesignStudios', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Shoe Manufacturing');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessShoeManufacturing', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Tailoring and Alterations');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessTailoringAndAlterations', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Fashion Accessories');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessFashionAccessories', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Boutiques');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessBoutiques', [
            'categories' => $categories,
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
      $categoriesQuery = Category::where('type', 'Apparel Recycling and Upcycling');
      if ($searchQuery) {
          $categoriesQuery->where(function ($query) use ($searchQuery) {
              $query->where('businessName', 'like', '%' . $searchQuery . '%')
                  ->orWhere('description', 'like', '%' . $searchQuery . '%');
          });
      }

      // Paginate the results with 10 businesses per page
      $categories = $categoriesQuery->paginate(9);
        return view('business-section.business-categories.businessApparelRecyclingAndUpcycling', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PostCategories extends Controller
{


    public function showRetailCategories()
    {
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        $categories = Category::where('type', 'Retail')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        return view('business-section.business-categories.businessRetail', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showFashionCategories()
    {
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        $categories = Category::where('type', 'Fashion')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        return view('business-section.business-categories.businessFashion', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }
    public function showAutomotiveCategories()
    {
        // Retrieve categories from the database
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        // Retrieve only categories with the type "Automotive"
        $categories = Category::where('type', 'Automotive')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessAutomotive', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }
    public function showApparelExportersCategories()
{
    // Retrieve categories from the database
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    // Retrieve only categories with the type "Apparel Exporters"
    $categories = Category::where('type', 'Apparel Exporters')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    // Pass the retrieved categories to the view for display
    return view('business-section.business-categories.businessApparelExporters', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

    public function showFashionPhotographyStudiosCategories()
    {
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        $categories = Category::where('type', 'FashionPhotographyStudios')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        return view('business-section.business-categories.businessFashionPhotographyStudios', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showHealthcareCategories()
    {
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        $categories = Category::where('type', 'Healthcare')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        return view('business-section.business-categories.businessHealthcare', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showInformationTechnologyCategories()
    {
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        $categories = Category::where('type', 'InformationTechnology')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        return view('business-section.business-categories.businessInformationTechnology', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }
    public function showShoppingMallsCategories()
    {
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        $categories = Category::where('type', 'ShoppingMalls')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        return view('business-section.business-categories.businessShoppingMalls', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showTradingGoodsCategories()
    {
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        $categories = Category::where('type', 'TradingGoods')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        return view('business-section.business-categories.businessTradingGoods', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showConsultingCategories()
    {
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        $categories = Category::where('type', 'Consulting')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        return view('business-section.business-categories.businessConsulting', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showBarberShopsCategories()
    {
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        $categories = Category::where('type', 'BarberShops')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        return view('business-section.business-categories.businessBarberShops', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showConstructionCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'Construction')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessConstruction', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

    public function showFashionConsultancyCategories()
    {
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        $categories = Category::where('type', 'FashionConsultancy')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        return view('business-section.business-categories.businessFashionConsultancy', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }

    public function showBeautySalonCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'BeautySalon')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessBeautySalon', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showLogisticsCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'Logistics')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessLogistics', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showSportsCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'Sports')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessSports', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showPharmaceuticalsCategories()
{
    // Retrieve categories from the database
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    // Retrieve only categories with the type "Pharmaceuticals"
    $categories = Category::where('type', 'Pharmaceuticals')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    // Pass the retrieved categories to the view for display
    return view('business-section.business-categories.businessPharmaceuticals', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}


public function showPetsCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'Pets')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessPets', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showEntertainmentCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'Entertainment')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessEntertainment', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showAgricultureCategories()
{
    // Retrieve categories from the database
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    // Retrieve only categories with the type "Agriculture"
    $categories = Category::where('type', 'Agriculture')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    // Pass the retrieved categories to the view for display
    return view('business-section.business-categories.businessAgriculture', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showEducationCategories()
{
    // Retrieve categories from the database
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    // Retrieve only categories with the type "Education"
    $categories = Category::where('type', 'Education')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    // Pass the retrieved categories to the view for display
    return view('business-section.business-categories.businessEducation', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showFinanceCategories()
{
    // Retrieve categories from the database
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    // Retrieve only categories with the type "Finance"
    $categories = Category::where('type', 'Finance')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    // Pass the retrieved categories to the view for display
    return view('business-section.business-categories.businessFinance', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}


public function showCoffeeShopsCategories()
{
    // Retrieve categories from the database
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    // Retrieve only categories with the type "CoffeeShops"
    $categories = Category::where('type', 'CoffeeShops')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    // Pass the retrieved categories to the view for display
    return view('business-section.business-categories.businessCoffeeShops', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showPatternMakingServicesCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'PatternMakingServices')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessPatternMakingServices', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showMaintenanceCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'Maintenance')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessMaintenance', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showAutomativeCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'Automative')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessAutomative', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showEnvironmentalCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'Environmental')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessEnvironmental', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showFoodBeveragesCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'FoodBeverages')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessFoodBeverages', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showGarmentManufacturingCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'GarmentManufacturing')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessGarmentManufacturing', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showFashionEventsManagementCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'FashionEventsManagement')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessFashionEventsManagement', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showRetailClothingStoresCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'RetailClothingStores')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessRetailClothingStores', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showFashionDesignStudiosCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'FashionDesignStudios')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessFashionDesignStudios', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showShoeManufacturingCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'ShoeManufacturing')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessShoeManufacturing', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showTailoringAndAlterationsCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'TailoringAndAlterations')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessTailoringAndAlterations', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showTextilePrintingAndEmbroideryCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'TextilePrintingAndEmbroidery')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessTextilePrintingAndEmbroidery', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showFashionAccessoriesCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'FashionAccessories')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessFashionAccessories', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showBoutiquesCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'Boutiques')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessBoutiques', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}

public function showApparelRecyclingAndUpcyclingCategories()
{
    $unseenCount = DB::table('ch_messages')
                ->where('to_id', '=', Auth::user()->id)
                ->where('seen', '=', '0')
                ->count();
    $categories = Category::where('type', 'ApparelRecyclingAndUpcycling')
    ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

    return view('business-section.business-categories.businessApparelRecyclingAndUpcycling', [
        'categories' => $categories,
        'unseenCount' => $unseenCount
    ]);
}


}

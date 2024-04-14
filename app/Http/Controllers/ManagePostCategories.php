<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ManagePostCategories extends Controller
{


    public function showAccountingCategories()
    {
        // Retrieve categories from the database
        $unseenCount = DB::table('ch_messages')
                    ->where('to_id', '=', Auth::user()->id)
                    ->where('seen', '=', '0')
                    ->count();
        // Retrieve only categories with the type "Accounting"
        $categories = Category::where('type', 'Accounting')
        ->get(['id', 'user_id', 'businessName', 'description', 'image', 'latitude', 'longitude', 'is_active']);

        // Pass the retrieved categories to the view for display
        return view('business-section.business-categories.businessAccounting', [
            'categories' => $categories,
            'unseenCount' => $unseenCount
        ]);
    }

}

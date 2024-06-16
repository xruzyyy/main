<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChartController extends Controller
{
    public function index()
    {
        // Fetch data for charts
        $activeUsersCount = User::where('status', 1)->count();
        $inactiveUsersCount = User::where('status', 0)->count();

        // Pass data to the view
        return view('admin.users.charts.index', compact('activeUsersCount', 'inactiveUsersCount'));
    }
}

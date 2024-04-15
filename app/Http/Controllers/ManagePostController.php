<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ManagePostController extends Controller
{

    public function index()
{
    // Fetch unseen message count
    $unseenCount = DB::table('ch_messages')
        ->where('to_id', '=', Auth::user()->id)
        ->where('seen', '=', '0')
        ->count();

    // Fetch all ManagePost with their associated users
    $ManagePost = Category::with('user')->get();

    // Pass both variables to the view
    return view('category.index', compact('ManagePost', 'unseenCount'));
}


public function create()
{
    // Fetch unseen message count
    $unseenCount = DB::table('ch_messages')
        ->where('to_id', '=', Auth::user()->id)
        ->where('seen', '=', '0')
        ->count();

    return view('category.create', compact('unseenCount'));
}

public function store(Request $request)
{
    $request->validate([
        'businessName' => 'required|max:255|string',
        'description' => 'required|max:255|string',
        'image' => 'required|mimes:jpg,jpeg,webp,png,jfif',
        'is_active' => 'sometimes' // Ensure is_active is allowed to be nullable
    ]);

    $path = ''; // Define path variable

    if ($request->has('image')) {
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();
        $filename = time() . '.' . $extension;
        $path = 'uploads/category/';
        $file->move($path, $filename);
    }

    $user = Auth::user(); // Get the authenticated user

    $category = Category::create([
        'businessName' => $request->businessName,
        'description' => $request->description,
        'image' => $path . $filename,
        'is_active' => $request->has('is_active'), // Set is_active to the provided value or default to 0
        'user_id' => $user->id, // Set the user_id to the ID of the authenticated user
        'user_email' => $user->email // Include the email of the authenticated user
    ]);

    return redirect('ManagePost/create')->with('status', 'Business Listing Created');
}


    public function edit(int $id)
{
    // Fetch unseen message count
    $unseenCount = DB::table('ch_messages')
        ->where('to_id', '=', Auth::user()->id)
        ->where('seen', '=', '0')
        ->count();

    // Fetch the category by ID
    $category = Category::findOrFail($id);

    // Pass both variables to the view
    return view('category.edit', compact('category', 'unseenCount'));
}



    public function update(Request $request, int $id)
    {
        $request->validate([
            'businessName' => 'required|max:255|string',
            'description' => 'required|max:255|string',
            'image' => 'required|mimes:jpg,jpeg,webp,png,jfif',
            // 'is_active' => 'boolean'
        ]);

        $category = Category::findOrFail($id);
        $path = ''; // Define path variable

        if ($request->has('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $path = 'uploads/category/';
            $file->move($path, $filename);

            if (File::exists($category->image)) {
                File::delete($category->image);
            }
        }

        $is_active = $request->has('is_active') ? true : false;


        $category->update([
            'businessName' => $request->businessName,
            'description' => $request->description,
            'image' => $path . $filename,
            'is_active' => $is_active,
        ]);

        return redirect()->back()->with('status', 'Business Listing Updated!');
    }

    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);
        if (File::exists($category->image)) {
            File::delete($category->image);
        }
        $category->delete();

        return redirect()->back()->with('status', 'Business Listing Successfully Deleted');
    }

    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);
        $category->update(['is_active' => !$category->is_active]);

        return redirect()->back();
    }

    public function sortTable(Request $request)
{
    $query = Category::query();

    // Sorting
    if ($request->has('sort')) {
        if ($request->input('sort') == 'newest') {
            $query->orderBy('id', 'desc');
        } elseif ($request->input('sort') == 'oldest') {
            $query->orderBy('id', 'asc');
        }
    }


    // Filtering by is_active
    if ($request->has('filter')) {
        if ($request->input('filter') == 'active') {
            $query->where('is_active', 1);
        } elseif ($request->input('filter') == 'not_active') {
            $query->where('is_active', 0);
        }
    }

    // Pagination
    $limit = $request->input('limit', 10);
    if ($limit == 'all') {
        $ManagePost = $query->get();
    } else {
        $ManagePost = $query->paginate($limit);
    }

    // Fetch unseen message count
    $unseenCount = DB::table('ch_messages')
        ->where('to_id', '=', Auth::user()->id)
        ->where('seen', '=', '0')
        ->count();

    return view('category.index', compact('ManagePost', 'unseenCount'));

}













}

<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Search;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\District;
use App\Models\Category;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
// 1. Capture all search inputs from the request
        $district = $request->input('district');
        $name = $request->input('name');
        $category = $request->input('category'); 

        // 2. Begin building the query on the User model and eager load the category
        // Eager loading ('with') prevents N+1 query performance hits
  
        $query = User::with('category')->where('verification_status', 'verified');

        // Filter by User Name if provided
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        // Filter by District relationship if provided
        if ($request->filled('district')) {
            $query->whereHas('district', function ($q) use ($district) {
                $q->where('district', '=', $district);
            });
        }

        // Filter by Category relationship if provided
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($category) {
                // Matches against the 'category' text column in your categories table
                $q->where('category', '=', $category); 
            });
        }

        // 3. Execute the query and get flat results
        $usersFlatList = $query->get();

        // 4. NEW: Group the collection dynamically by the category name attribute
        $groupedUsers = $usersFlatList->groupBy(function($user) {
            // If the user has a category, group them by its name; otherwise fallback to 'Uncategorized'
            return $user->category ? $user->category->category : 'Uncategorized';
        });

        // 5. Return the view with the grouped collection instead of the flat list
        return view('search/index', compact('groupedUsers', 'district', 'name', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     */
public function searchByCategory($id)
    {
        // 1. Find the selected category by its ID
        $category = Category::findOrFail($id);

        // 2. Fetch all users matching this category
        // (Assumes a 'category_id' column or a relationship on your User model)
        $users = User::where('category_id', $category->id)->get();

        // 3. Pass the un-grouped users list and the category title to the blade view
        // Pointing cleanly to: resources/views/search/category.blade.php
        return view('search.category', [
            'users' => $users,
            'categoryName' => $category->category
        ]);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Search $search)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Search $search)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Search $search)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Search $search)
    {
        //
    }
}

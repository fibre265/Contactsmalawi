<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Region;   // Fixed: Added missing import
use App\Models\District; // Fixed: Added missing import
use App\Models\User;     // Fixed: Added missing import for dashboard view
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function allCategories(Request $request){
       
// 1. Capture all search inputs from the request
        $district = $request->input('district');
        $name = $request->input('name');
        $category = $request->input('category'); 

        // 2. Begin building the query on the User model and eager load the category
        // Eager loading ('with') prevents N+1 query performance hits
        $query = User::with('category');

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
        return view('categories/allCategories', compact('groupedUsers', 'district', 'name', 'category'));
   
    }
    // public function categories()
    // {
    //     if (request()->ajax()) {
    //         // Fixed: Removed ->get() to pass the raw query builder instance to Yajra DataTables
    //         $categories = Category::select(['id', 'category']);
            
    //         return DataTables::of($categories)
    //             ->addColumn('action', function($category) {
    //                 return '
    //                     <div class="btn-group" role="group">
    //                         <button class="btn btn-primary btn-sm editCategory" data-id="' . $category->id . '">Edit</button>
    //                         <form action="' . route('categories.destroy', $category->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
    //                             ' . csrf_field() . '
    //                             ' . method_field('DELETE') . '
    //                             <button type="submit" class="btn btn-danger btn-sm">Delete</button>
    //                         </form>
    //                     </div>
    //                 ';
    //             })
    //             ->rawColumns(['action'])
    //             ->make(true);
    //     }

    //     // Fixed: Fetching correct data variables for your dashboard components
    //     $regions = Region::all(); 
    //     $districts = District::all(); 
    //     $categories = Category::all(); 
    //     $users = User::all(); // Fixed: Pulling genuine User data for the view context

    //     return view('dashboard', compact('regions', 'districts', 'users', 'categories'));
    // }

    //use App\Http\Controllers\CategoryController;

public function approve($id)
{
    $category = Category::findOrFail($id);
    $category->update(['approved' => true]);

    return redirect()->back()->with('success', 'Category approved successfully!');
}
public function categories()
    {
        if (request()->ajax()) {
            $categories = Category::select(['id', 'category', 'approved']);
            
            return DataTables::of($categories)
                ->addColumn('action', function($category) {
                    // Determine if we need an Approve button
                    $approveButton = '';
                    if (!$category->approved) {
                        $approveButton = '
                            <form action="' . route('categories.approve', $category->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field('PATCH') . '
                                <button type="submit" class="btn btn-success btn-sm me-1">Approve</button>
                            </form>
                        ';
                    }

                    return '
                        <div class="btn-group" role="group">
                            ' . $approveButton . '
                            <button class="btn btn-primary btn-sm editCategory me-1" data-id="' . $category->id . '">Edit</button>
                            <form action="' . route('categories.destroy', $category->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    ';
                })
                // NEW: Process status into its own column definition matching your JS config
                ->addColumn('status', function($category) {
                    if (!$category->approved) {
                        return '<span class="badge bg-warning text-dark">Pending</span>';
                    }
                    return '<span class="badge bg-success">Approved</span>';
                })
                // Clean escape for the category column so it only carries text strings
                ->editColumn('category', function($category) {
                    return e($category->category);
                })
                // Added 'status' here so that HTML badge templates compile inside the browser view
                ->rawColumns(['action', 'status', 'category'])
                ->make(true);
        }

        $regions = Region::all(); 
        $districts = District::all(); 
        $categories = Category::all(); 
        $users = User::all(); 

        return view('dashboard', compact('regions', 'districts', 'users', 'categories'));
    }
    public function create()
{
    return view('categories.create'); // Or your specific view path
}

    public function edit(Request $request, $id){
        
        $category = Category::find($id);
        return response()->json($category);
       
    }

public function store(Request $request)
{
    $request->validate([
        'category' => 'required|string|max:255',
    ]);

    // Save the new category (assumes default status is pending/unapproved)
    $category = Category::create([
        'category' => $request->category
    ]);

    // If it's an AJAX request, return the JSON setup cleanly
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    $regions = Region::all(); 
    $districts = District::all(); 
   $categories = Category::latest()->get();; // This is passed directly down to your view loop below
    $users = User::all(); 

    return view('categories/newCategoryStatus', compact('regions', 'districts', 'users', 'categories'))->with('success', 'Category created successfully!');
}
// 1. Your original method to render the view
public function pendingCategories(Request $request)
{
    $categories = Category::where('approved', '=', 0)->latest()->get();

    return view('categories/newCategoryStatus', compact('categories'))->with('success', 'Category created successfully!');
}

// 2. Add this extra method inside your controller to process the AJAX increments
public function like($id)
{
    $category = Category::findOrFail($id);
    $category->increment('likes'); // Ensure your migration from Step 1 has been executed!

    return response()->json([
        'success' => true,
        'likes' => $category->likes
    ]);
}
    public function getCategoriesData()
    {
        $categories = Category::select(['id', 'category']);
        
        return DataTables::of($categories)
            ->addColumn('actions', function($category) {
                return '
                    <button type="button" class="btn btn-primary" data-id="'.$category->id.'" data-category="'.$category->category.'" data-bs-toggle="modal" data-bs-target="#editCategoryModal">Edit</button>
                    <button type="button" class="btn btn-danger" data-id="'.$category->id.'" data-bs-toggle="modal" data-bs-target="#deleteCategoryModal">Delete</button>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    
    public function update(Request $request, $id)
    {
  

    // Validate the input
    $request->validate([
        'category' => 'required|string|max:255',
    ]);

    // Find the category and update
    $category = Category::findOrFail($id);
    $category->update([
        'category' => $request->input('category'),  // Use input() method to access the category input
    ]);

    return response()->json(['success' => true, 'category' => $category]);
}
public function delete(Request $request, $id){


    // Find and delete the category
    $category = Category::find($id);
    if ($category) {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
    return redirect()->back()->with('error', 'Category not found.');

}
    
}
<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Yajra\DataTables\Facades\DataTables;
class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
        ]);
    
        $category = Category::create([
            'category' => $request->category,  // Make sure to use 'category' to match the form field name
        ]);
    
    
        // Return success response for AJAX handling
        return response()->json(['success' => true, 'category' => $category], 200);
    }
    // public function show()
    // {
    // $categories = Category::all();
    // return view('categories/index', compact('categories'));
    // }


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
            // $request->validate([
            //     'category' => 'required|string|max:255',
            // ]);

            // Find the category and update
            $category = Category::findOrFail($id);
            $category->update([
                'category' => $request->category,
            ]);

            // Return success response for AJAX handling
            return response()->json(['success' => true, 'category' => $category], 200);
        }

    
}

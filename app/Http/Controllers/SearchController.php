<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Search;
use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\District;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $district = $request->input('district');
        $name = $request->input('name');
        $users = User::where('name', 'like', '%' . $name . '%')
        ->whereHas('district', function ($query) use ($district) {
            $query->where('district', '=', $district);
        })->get();
        return view('search/index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
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

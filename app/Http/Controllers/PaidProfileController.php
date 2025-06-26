<?php

namespace App\Http\Controllers;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PaidProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboordControler;
use Illuminate\Support\Facades\Route;
use App\Models\Region;
use App\Models\District;
use App\Models\User;
use App\Models\Category;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class PaidProfileController extends Controller
{

    public function show()
    {
        //$region_id=$id;
        // $post is automatically resolved by Laravel using the 'slug' or 'name' field

    
        //$users = User::whereNotNull('picture')->where('picture', '!=', '')->get();

        $districts = District::with('user')->get(); // Eager load the 'users' relationship
        $region = Region::all(); // Load regions as needed
        

        return view('profile.paid.search_in_regions', compact('districts','region'));
    }
    public function search_in_district_paid($id)
  
    {

        $users=User::where('district_id', '=', $id)->get();
        $districts=District::where('region_id', '=', $id)->get();
        $district=District::where('id', '=', $id)->pluck('district')->first();
  

        return view('profile.paid.search_in_districts', compact('users','districts','district'));
    }

}

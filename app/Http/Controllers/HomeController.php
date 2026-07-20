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

use Illuminate\Http\Request;

class HomeController extends Controller
{
        public function home()
    {

    $regions = Region::all(); // Fetch regions from the database
    $districts = District::all(); // Fetch districts from the database
    $categories = Category::all(); // Fetch categories from the database
    $users = User::where('is_approved', '=',0)->get(); // Fetch users from the database
    $southerndistricts = District::where('region_id', '=',1)->get(); // Fetch users from the database
    $notherndistricts = District::where('region_id', '=',3)->get(); // Fetch users from the database
    $centraldistricts = District::where('region_id', '=',2)->get(); // Fetch users from the database
    return view('welcome', compact('regions','categories','districts','users','southerndistricts','centraldistricts','notherndistricts' ));
        

        return view('welcome', compact('districts','region'));
    }
}

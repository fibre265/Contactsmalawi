<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use App\Models\Region;
use App\Models\District;
use App\Models\User;
Route::get('/search_region/{id}', [ProfileController::class, 'search_in_region'])->name('users.region');
Route::get('/search_in_district/{id}', [ProfileController::class, 'search_in_district'])->name('users.district');
Route::get('/user/{user}', [ProfileController::class, 'show'])->name('users.show');
// Route::get('/get-districts-by-region/{regionId}', function ($regionId) {
//     $districts = District::where('region_id', $regionId)->get();
//     return response()->json($districts);
// });
// Route to get districts by region
// Route::get('/districts/{region}', function ($region) {
//     $districts = District::where('region', $region)->get();
//     dd( $districts );
//     return response()->json($districts);
// });
Route::get('/', function () {
    $regions = Region::all(); // Fetch regions from the database
    $districts = District::all(); // Fetch districts from the database
    $users = User::all(); // Fetch users from the database
    return view('welcome', compact('regions','districts','users' ));
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/submit_searches', [SearchController::class, 'index'])->name('submit_searches');
require __DIR__.'/auth.php';

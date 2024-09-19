<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\DashboordControler;
use Illuminate\Support\Facades\Route;
use App\Models\Region;
use App\Models\District;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
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

Route::post('users/{id}', [DashboordControler::class, 'tikonzecontrollermethod'])->name('tikonzeroutename');
//Route::post('/update_property/{id}', [PropertyController::class, 'update_property'])->name('update_property');


Route::get('/users/{id}/edit', [DashboordControler::class, 'edit'])->name('users.edit');

Route::get('/dashboard', function () {
    $users = User::all(); 
    if (request()->ajax()) {
        $users = User::query();
        return DataTables::of($users)
            ->addColumn('action', function($user) {
                return '
                    <div class="btn-group" role="group">
                        <a href="' . route('users.edit', $user->id) . '" class="btn btn-primary btn-sm">Edit</a>
                        <form action="" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <form action="' . route('profile.destroy', $user->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to approve this user?\');">
                            ' . csrf_field() . '
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    $regions = Region::all(); // Fetch regions from the database
    $districts = District::all(); // Fetch districts from the database
    return view('dashboard', compact('regions','districts','users' ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/edit', function () {
        $user = Auth::user();
        $districts = District::all();
        //dd("shit");
        return view('profile.edit', compact('user','districts'));})->name('verification.send');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update2'])->name('profile.update2');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/submit_searches', [SearchController::class, 'index'])->name('submit_searches');
require __DIR__.'/auth.php';

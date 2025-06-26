<?php

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


Route::get('/search_region/{id}', [ProfileController::class, 'search_in_region'])->name('users.region');
Route::get('/search_in_district/{id}', [ProfileController::class, 'search_in_district'])->name('users.district');

Route::get('/paid', [PaidProfileController::class, 'show'])->name('users.paid');
Route::get('/search_in_district_paid/{id}', [PaidProfileController::class, 'search_in_district_paid'])->name('users.district');

Route::get('/user/{user}', [ProfileController::class, 'show'])->name('users.show');
Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');




Route::get('/', function () {
    $regions = Region::all(); // Fetch regions from the database
    $districts = District::all(); // Fetch districts from the database
    $users = User::all(); // Fetch users from the database
    $southerndistricts = District::where('region_id', '=',1)->get(); // Fetch users from the database
    $notherndistricts = District::where('region_id', '=',3)->get(); // Fetch users from the database
    $centraldistricts = District::where('region_id', '=',2)->get(); // Fetch users from the database
    return view('welcome', compact('regions','districts','users','southerndistricts','centraldistricts','notherndistricts' ));
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




Route::get('/categories', function () {
    $users = Category::all(); 
    if (request()->ajax()) {
        $categories = Category::select(['id', 'category'])->get();
        return DataTables::of($categories)
            ->addColumn('action', function($category) {
                return '
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary btn-sm editCategory" data-id="' . $category->id . '">Edit</button>
                        <form action="' . route('categories.destroy', $category->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    $regions = Region::all(); // Fetch regions from the database
    $districts = District::all(); // Fetch districts from the database
    $categories = Category::all(); // Fetch districts from the database
    return view('dashboard', compact('regions','districts','users','categories' ));
})->middleware(['auth', 'verified'])->name('categories');

Route::get('/categories/{id}/edit', function ($id) {
    $category = Category::find($id);
    return response()->json($category);
})->name('categories.edit');



Route::put('/categories/{id}', function (Request $request, $id) {

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
})->name('categories.update');



Route::delete('/categories/{id}', function ($id) {
    // Find and delete the category
    $category = Category::find($id);
    if ($category) {
        $category->delete();
        return redirect()->back()->with('success', 'Category deleted successfully!');
    }
    return redirect()->back()->with('error', 'Category not found.');
})->name('categories.destroy');

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

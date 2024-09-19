<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\District;
use App\Models\Region;
class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function show(User $user)
    {
        //dd($user);
        // $post is automatically resolved by Laravel using the 'slug' or 'name' field
        return view('profile.show', compact('user'));
    }
    public function search_in_region($id)
    {
        //$region_id=$id;
        // $post is automatically resolved by Laravel using the 'slug' or 'name' field

    
        $users=User::where('region_id', '=', 1)->get();
        $districts=District::where('region_id', '=', $id)->get();
        $region=Region::where('id', '=', $id)->pluck('region')->first();
        $userCount = $users->count();
        // dd($userCount);

        return view('profile.search_in_region', compact('users','districts','region'));
    }
    public function search_in_district($id)
  
    {

        $users=User::where('district_id', '=', $id)->get();
        $districts=District::where('region_id', '=', $id)->get();
        $district=District::where('id', '=', $id)->pluck('district')->first();
  

        return view('profile.search_in_district', compact('users','districts','district'));
    }

    
    public function edit(Request $request): View
    {//dd('uu');
        $districts = District::all();
        return view('profile.edit', [
            'user' => $request->user(),
            'districts' => $districts, // Pass the districts data to the view
        ]);
        // dd("shit edit");
    }

    /**
     * Update the user's profile information.
     */
    //public function update2(ProfileUpdateRequest $request): RedirectResponse
    public function update2(Request $request)
    {
     

        $validatedData = $request->validate([
            'name' => 'nullable|max:255', // Allow null values to maintain current data
            'email' => 'nullable|max:255', // Ensure email format if provided
            'township' => 'nullable|max:255', 
            'district_id' => 'nullable|integer', // Ensure it's an integer if provided
        ]);
    
        // Filter out null values to keep existing values in the database
        $filteredData = array_filter($validatedData, function ($value) {
            return $value !== null;
        });
    
        // Update user data only with provided fields
        $request->user()->fill($filteredData);
    
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        // dd("shit update");
        $request->user()->save();
    $districts=District::all();
    $user= Auth::user();
        //return Redirect::route('profile.edit')->with('status', 'profile-updated');
        return view('profile.edit', compact('districts','user'))->with('status', 'profile-updated'); 
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}

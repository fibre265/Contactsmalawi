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
        return view('profile.show', compact('user'));
    }
    public function search_in_region($id)
    {
        
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
    {
       
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
  public function update(Request $request) 
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
          //  $request->user()->email_verified_at = null;
        }
        $request->user()->save();
        $districts=District::all();
        $user= Auth::user();
        return view('profile.edit', compact('districts','user'))->with('status', 'profile-updated'); 
    }

    /**
     * Delete the user's account.
     */

    public function destroyUser($id)
{
    // Ensure an admin doesn't accidentally delete themselves
    if (auth()->id() == $id) {
        return redirect()->back()->with('error', 'You cannot delete your own account from the dashboard management page.');
    }

    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('dashboard')->with('success', 'User deleted successfully.');
}

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

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
        //dd("esh..");
        //$region_id=$id;
        // $post is automatically resolved by Laravel using the 'slug' or 'name' field

    
        $users=User::where('district_id', '=', $id)->get();
        $districts=District::where('region_id', '=', $id)->get();
        $district=District::where('id', '=', $id)->pluck('district')->first();
  

        return view('profile.search_in_district', compact('users','districts','district'));
    }

    
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

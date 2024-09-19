<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Region;
use App\Models\District;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class DashboordControler extends Controller
{
    // public function update(Request $request, User $user)
    // {
    //     dd("died");
    //     $user->update($request->only(['name', 'email', 'township']));
    //     return response()->json(['success' => 'User updated successfully.']);
    // }
    public function edit($id)
    {

        $user = User::findOrFail($id);
        $districts = District::all();
        return view('users.edituserpage', compact('user','districts')); // 'users.edit' is your blade file for the form
    }
    public function tikonzecontrollermethod(Request $request, User $user)
    {
        // Validate the request data
        $user_id=$request->user_id;
        $region_id = null;

        switch ($request->district_id) {
            case 1:
                $region_id = 1;
                break;
            case 2:
                $region_id = 1;
                break;
            case 3:
                $region_id = 1;
                break;
            case 4:
                $region_id = 1;
                break;
            case 5:
                $region_id = 3;
                break;
            case 6:
                $region_id = 2;
                break;
            case 7:
                $region_id = 2;
                break;
            case 8:
                $region_id = 3;
                break;
            case 9:
                $region_id = 2;
                break;
            case 10:
                $region_id = 3;
                break;
            case 11:
                $region_id = 2;
                break;
            case 12:
                $region_id = 1;
                break;
            case 13:
                $region_id = 1;
                break;
            case 14:
                $region_id = 2;
                break;
            case 15:
                $region_id = 1;
                break;
            case 16:
                $region_id = 1;
                break;
            case 17:
                $region_id = 3;
                break;
            case 18:
                $region_id = 1;
                break;
            case 19:
                $region_id = 3;
                break;
            case 20:
                $region_id = 2;
                break;
            case 21:
                $region_id = 1;
                break;
            case 22:
                $region_id = 2;
                break;
            case 23:
                $region_id = 2;
                break;
            case 24:
                $region_id = 1;
                break;
            case 25:
                $region_id = 3;
                break;
            case 26:
                $region_id = 2;
                break;
            case 27:
                $region_id = 1;
                break;
            case 28:
                $region_id = 1;
                break;
        }
        $id=$request->user_id;
        $user=User::find($id);
       // Validate the request data
    $request->validate([
        'password' => 'nullable|string|min:8|confirmed', // Make password nullable
        'name' => 'nullable|string|max:255',
        //'email' => 'nullable|max:255' . $user->id, // Ensure email uniqueness
        //'email' => 'nullable|max:255',
        'email' => 'nullable|max:255|unique:users,email,' . $user->id . ',id', // Ensure email uniqueness, excluding the current user
        'township' => 'nullable|string|max:255',
        'district_id' => 'nullable|exists:districts,id', // Allow district_id to be nullable
        'region_id' => 'nullable|exists:regions,id', // Allow region_id to be nullable
    ]);

    // Update user details conditionally
    if ($request->filled('name')) {
        $user->name = $request->input('name');
    }

    if ($request->filled('district_id')) {
        $user->district_id = $request->input('district_id');
    }

    if ($request->filled('region_id')) {
        $user->region_id = $request->input('region_id');
    }

    if ($request->filled('township')) {
        $user->township = $request->input('township');
    }

    if ($request->filled('email')) {
        $user->email = $request->input('email');
    }

    // Hash password only if provided
    if ($request->filled('password')) {
        $user->password = Hash::make($request->input('password'));
    }

    $user->save();


        // Redirect back with success message
        return redirect()->route('dashboard', $user->id)->with('success', 'User updated successfully.');
    }

}
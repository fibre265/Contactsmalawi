<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;
use App\Models\Region;
use App\Models\District;
use App\Models\User;
use App\Models\AboutSetting; // Imported for the about settings form!
use App\Jobs\SendBroadcastEmail;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class DashboordControler extends Controller
{
    public function dashboard()
    {
        // 1. Handle AJAX DataTables request for User Management
        if (request()->ajax()) {
            $users = User::query();
            return DataTables::of($users)
                ->editColumn('created_at', function($user) {
                    return $user->created_at ? $user->created_at->diffForHumans() : 'N/A';
                })
                ->editColumn('updated_at', function($user) {
                    return $user->updated_at ? $user->updated_at->diffForHumans() : 'N/A';
                })
                ->addColumn('action', function($user) {
                    $approveText = $user->is_approved ? 'Revoke' : 'Approve';
                    $approveClass = $user->is_approved ? 'btn-warning' : 'btn-success';
                    $confirmMessage = $user->is_approved 
                        ? 'Are you sure you want to revoke approval for this user?' 
                        : 'Are you sure you want to approve this user?';

                    return '
                        <div class="btn-group" role="group">
                            <a href="' . route('users.edit', $user->id) . '" class="btn btn-primary btn-sm">Edit</a>
                            
                            <form action="' . route('users.destroy', $user->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this user?\');">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                            
                            <form action="' . route('profile.approve', $user->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'' . $confirmMessage . '\');">
                                ' . csrf_field() . '
                                <button type="submit" class="btn ' . $approveClass . ' btn-sm">' . $approveText . '</button>
                            </form>
                        </div>
                    ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        // 2. Fetch necessary records for dropdowns & forms
        $users = User::all(); 
        $regions = Region::all(); 
        $districts = District::all(); 

        // 3. Get saved setting values so the dashboard form displays them
        $settings = AboutSetting::pluck('value', 'key')->toArray();

        return view('dashboard', compact('regions', 'districts', 'users', 'settings'));
    }

    /**
     * Update the dynamic "About" page settings from the dashboard
     */
    public function updateSettings(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.hero_description' => 'required|string',
            'settings.mission_statement' => 'required|string',
        ]);

        foreach ($request->input('settings') as $key => $value) {
            AboutSetting::updateOrCreate(
                ['key' => $key], 
                ['value' => $value] 
            );
        }

        return redirect()->back()->with('settings_success', 'About page content updated successfully!');
    }

    /**
     * Toggles the user's approval status
     */
    public function toggleApproval($id)
    {
        if (auth()->id() == $id) {
            return redirect()->back()->with('error', 'You cannot change your own approval status.');
        }

        $user = User::findOrFail($id);
        $user->is_approved = !$user->is_approved;
        $user->save();

        $statusMessage = $user->is_approved ? 'User approved successfully.' : 'User approval revoked.';
        
        return redirect()->route('dashboard')->with('success', $statusMessage);
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $districts = District::all();
        return view('users.edituserpage', compact('user', 'districts'));
    }

    public function tikonzecontrollermethod(Request $request, User $user)
    {
        $user_id = $request->user_id;
        $region_id = null;

        // Simplified mapping or switch (keeping your custom switch configuration intact)
        switch ($request->district_id) {
            case 1: case 2: case 3: case 4: case 12: case 13: case 15: case 16: case 18: case 21: case 24: case 27: case 28:
                $region_id = 1;
                break;
            case 6: case 7: case 9: case 11: case 14: case 20: case 22: case 23: case 26:
                $region_id = 2;
                break;
            case 5: case 8: case 10: case 17: case 19: case 25:
                $region_id = 3;
                break;
        }

        $id = $request->user_id;
        $user = User::find($id);

        $request->validate([
            'password' => 'nullable|string|min:8|confirmed',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|max:255|unique:users,email,' . $user->id . ',id',
            'township' => 'nullable|string|max:255',
            'district_id' => 'nullable|exists:districts,id',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        if ($request->filled('name')) $user->name = $request->input('name');
        if ($request->filled('district_id')) $user->district_id = $request->input('district_id');
        if ($request->filled('region_id')) $user->region_id = $request->input('region_id');
        if ($request->filled('township')) $user->township = $request->input('township');
        if ($request->filled('email')) $user->email = $request->input('email');
        if ($request->filled('password')) $user->password = Hash::make($request->input('password'));

        $user->save();

        return redirect()->route('dashboard', $user->id)->with('success', 'User updated successfully.');
    }

    public function destroyUser($id)
    {
        if (auth()->id() == $id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('dashboard')->with('success', 'User deleted successfully.');
    }

    public function showBroadcastingForm()
    {
        $totalSubscribers = Subscriber::count();
        return view('dashboard', compact('totalSubscribers'));
    }

    public function sendBroadcast(Request $request)
    {
        $request->validate([
            'message_body' => 'required|string',
        ]);

        $messageContent = $request->input('message_body');

        Subscriber::chunk(100, function ($subscribers) use ($messageContent) {
            foreach ($subscribers as $subscriber) {
                SendBroadcastEmail::dispatch($subscriber, $messageContent);
            }
        });

        return redirect()->back()->with('success', 'Mass broadcast processing started in the background!');
    }
}
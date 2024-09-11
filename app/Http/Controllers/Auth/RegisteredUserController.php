<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Region;
use App\Models\District;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $regions = Region::all(); // Fetch regions from the database
        $districts = District::all(); // Fetch districts from the database
        return view('auth.register', compact('regions','districts'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        //     'password' => ['required', 'confirmed', Rules\Password::defaults()],
        // ]);

        
        // dd('name:',$request->name,
        // 'phone:', $request->phonenumber,
        //   'township:',$request->township, 
        //     'passowrd:',$request->password,
        //     'region_id:',$request->region_id,
            // 'district_id:',$request->district_id);
            
        // $id = $request->id;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'district_id' => $request->district_id,
            'region_id' => $request->region_id,
            'password' => Hash::make($request->password),
            'township' => $request->township,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Region;
use App\Models\District;
use App\Models\Category;
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
        $pro = false;
        $regions = Region::all(); // Fetch regions from the database
        $districts = District::all(); // Fetch districts from the database
        $categories = Category::all(); // Fetch categories from the database
        return view('auth.register', compact('regions','districts','pro','categories'));
    }
    public function createPro(Request $request): View
    {
        //DD("KK");
        $pro = true;
        $categories = Category::all(); // Fetch categories from the database
        $regions = Region::all(); // Fetch regions from the database
        $districts = District::all(); // Fetch districts from the database
        return view('auth.register', compact('regions','districts','pro','categories'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
      

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
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('uploads/pictures', $fileName, 'public'); // Store the file in the public storage folder
        } else {
            $fileName = null; // Handle the case where no file was uploaded
        }
        
       //dd($fileName);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'district_id' => $request->district_id,
            'region_id' => $region_id,
            'category_id'=> $request->category_id,
            'password' => Hash::make($request->password),
            'township' => $request->township,
            'picture' => $fileName,
   
        ]);

    

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}

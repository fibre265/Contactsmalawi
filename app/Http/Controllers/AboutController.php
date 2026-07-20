<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use App\Models\User;
use App\Models\AboutSetting; // Make sure to import your model!
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        $totalSubscribers = Subscriber::count();
        $totalContacts = User::count(); 

        // Fetch all key-value settings from the database and turn them into an array:
        // This creates an array like: ['hero_description' => '...', 'mission_statement' => '...']
        $settings = AboutSetting::pluck('value', 'key')->toArray();

        return view('about.index', [
            'totalSubscribers' => $totalSubscribers,
            'totalContacts' => $totalContacts,
            'settings' => $settings, // Pass the array to your view
        ]);
    }
}
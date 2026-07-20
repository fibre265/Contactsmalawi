<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscriber;

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        // Custom message so users know if they are already on the list
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ], [
            'email.unique' => 'This email address is already subscribed to our newsletter!',
        ]);

        Subscriber::create([
            'email' => $request->email
        ]);

        return redirect()->back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}
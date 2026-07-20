<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function showForm()
    {
        return view('donations/donate');
    }

    public function initializePayment(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:500',
            'donor_name' => 'nullable|string|max:255',
            'email' => 'nullable|email'
        ]);

        // 1. Generate a unique, unguessable tracking string for this transaction intent
        $tx_ref = 'DON-' . Str::random(12) . '-' . time();

        // 2. Track the interaction inside your database status dashboard as pending
        $donation = Donation::create([
            'donor_name' => $request->donor_name ?? 'Anonymous',
            'email' => $request->email ?? 'anonymous@example.com',
            'amount' => $request->amount,
            'tx_ref' => $tx_ref,
            'status' => 'pending'
        ]);

        /* |--------------------------------------------------------------------------
         | API WORK FOR ANOTHER DAY: PAYCHANGU GATEWAY CONNECTOR
         |--------------------------------------------------------------------------
         | When ready, uncomment the execution block below and add your 
         | PayChangu Secret API key configuration string.
         */
        
        /*
        $secretKey = "YOUR_PAYCHANGU_SECRET_API_KEY_HERE"; // API KEY HERE

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
            'Accept' => 'application/json',
        ])->post('https://api.paychangu.com/payment', [
            'amount' => $donation->amount,
            'currency' => 'MWK',
            'email' => $donation->email,
            'first_name' => $donation->donor_name,
            'last_name' => 'Donor',
            'tx_ref' => $tx_ref,
            'callback_url' => route('donate.callback'), 
            'customization' => [
                'title' => 'ContactsMalawi Donation',
                'description' => 'System Maintenance Fund',
            ]
        ]);

        if ($response->successful()) {
            $paymentData = $response->json();
            // Redirect the user out to PayChangu's secure payment screen interface
            return redirect()->away($paymentData['data']['checkout_url']);
        }

        return redirect()->back()->with('error', 'Unable to generate payment interface right now.');
        */

        // TEMPORARY: For testing today, bypass API and simulate a redirect directly to callback
        return redirect()->route('donate.callback', ['txref' => $tx_ref]);
    }

    public function callback(Request $request)
    {
        // PayChangu automatically passes back 'txref' via the URL query parameters
        $tx_ref = $request->query('txref');

        if (!$tx_ref) {
            return redirect()->route('donate.form')->with('error', 'Transaction cancelled or reference missing.');
        }

        $donation = Donation::where('tx_ref', $tx_ref)->firstOrFail();

        /*
         |--------------------------------------------------------------------------
         | API WORK FOR ANOTHER DAY: TRANSACTION VERIFICATION VERDICT
         |--------------------------------------------------------------------------
         | In production, you never trust URL parameters alone. You hit PayChangu's 
         | verification endpoint to double-check if they actually received the cash.
         */

        /*
        $secretKey = "YOUR_PAYCHANGU_SECRET_API_KEY_HERE"; // API KEY HERE
        
        $verificationResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $secretKey,
            'Accept' => 'application/json',
        ])->get("https://api.paychangu.com/payment/{$tx_ref}/verify");

        if ($verificationResponse->successful() && $verificationResponse->json()['data']['status'] === 'success') {
             $donation->update(['status' => 'completed']);
             return view('donate_success', compact('donation'));
        }
        $donation->update(['status' => 'failed']);
        */

     // TEMPORARY: Simulate a successful mock response for your local setup
    $donation->update(['status' => 'completed']);

    // Pass the donation record variables cleanly to the view
    return view('donations.donate_success', compact('donation'));
        }
}
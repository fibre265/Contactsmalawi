<?php 
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ContactVerificationController extends Controller
{
    public function submitVote(Request $request, $id)
    {
        $request->validate([
            'vote' => 'required|in:yes,no'
        ]);

        $user = User::findOrFail($id);

        if ($request->input('vote') === 'yes') {
            $user->increment('working_votes');
        } else {
            $user->increment('not_working_votes');
        }

        // Auto-flag checking criteria
        $totalVotes = $user->working_votes + $user->not_working_votes;
        if ($user->not_working_votes >= 5 && ($user->not_working_votes / $totalVotes) >= 0.6) {
            $user->verification_status = 'pending_review';
            $user->save();
        }

        return response()->json([
            'success' => true,
            'working_votes' => $user->working_votes,
            'not_working_votes' => $user->not_working_votes
        ]);
    }
}
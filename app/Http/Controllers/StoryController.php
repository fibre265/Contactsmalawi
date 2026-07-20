<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StoryController extends Controller
{
    // Public display view
    public function index()
    {
        $stories = Story::where('approved', true)->latest()->get();
        return view('stories.index', compact('stories'));
    }

    // Public submission storage
    public function store(Request $request)
    {
        $request->validate([
            'story' => 'required|string',
            'location' => 'nullable|string|max:255',
        ]);

        Story::create([
            'story' => $request->story,
            'location' => $request->location,
            'approved' => 0, // Default to pending review
        ]);

        return redirect()->back()->with('success', 'Thank you! Your story has been submitted for approval.');
    }

    /*
     * ==========================================
     * ADMIN / DASHBOARD CONTROLLER FUNCTIONS
     * ==========================================
     */

    /**
     * AJAX endpoint to populate the DataTables dashboard
     */
    public function getStoriesData()
    {
        $stories = Story::query();

        return DataTables::of($stories)
            ->editColumn('story', function($story) {
                // Return a truncated version of the story for table scannability
                return strlen($story->story) > 60 ? substr($story->story, 0, 60) . '...' : $story->story;
            })
            ->editColumn('approved', function($story) {
                return $story->approved 
                    ? '<span class="badge bg-success text-white">Approved</span>' 
                    : '<span class="badge bg-warning text-dark">Pending</span>';
            })
            ->editColumn('created_at', function($story) {
                return $story->created_at ? $story->created_at->diffForHumans() : 'N/A';
            })
            ->addColumn('action', function($story) {
                $approveBtnText = $story->approved ? 'Reject' : 'Approve';
                $approveBtnClass = $story->approved ? 'btn-warning' : 'btn-success';

                return '
                    <div class="btn-group" role="group">
                        <button class="btn btn-primary btn-sm editStory" data-id="' . $story->id . '">Edit</button>
                        
                        <form action="' . route('admin.stories.approve', $story->id) . '" method="POST" style="display:inline;">
                            ' . csrf_field() . '
                            <button type="submit" class="btn ' . $approveBtnClass . ' btn-sm">' . $approveBtnText . '</button>
                        </form>

                        <form action="' . route('admin.stories.destroy', $story->id) . '" method="POST" style="display:inline;" onsubmit="return confirm(\'Are you sure you want to delete this story permanently?\');">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['approved', 'action'])
            ->make(true);
    }

    /**
     * Fetch raw data for the edit modal (via AJAX)
     */
    public function edit($id)
    {
        $story = Story::findOrFail($id);
        return response()->json($story);
    }

    /**
     * Update the story elements
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'story' => 'required|string',
            'location' => 'nullable|string|max:255',
        ]);

        $story = Story::findOrFail($id);
        $story->update([
            'story' => $request->story,
            'location' => $request->location,
        ]);

        return response()->json(['message' => 'Story updated successfully.']);
    }

    /**
     * Toggle approval of a story
     */
    public function approve($id)
    {
        $story = Story::findOrFail($id);
        $story->approved = !$story->approved;
        $story->save();

        $message = $story->approved ? 'Story approved successfully!' : 'Story approval status revoked!';

        return redirect()->back()->with('story_success', $message);
    }

    /**
     * Delete a story
     */
    public function destroy($id)
    {
        $story = Story::findOrFail($id);
        $story->delete();

        return redirect()->back()->with('story_success', 'Story deleted successfully!');
    }
}
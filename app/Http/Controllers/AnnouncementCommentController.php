<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementComment;
use Illuminate\Http\Request;

class AnnouncementCommentController extends Controller
{
    /** Store a new comment on an announcement */
    public function store(Request $request, Announcement $announcement)
    {
        $request->validate([
            'body' => ['required', 'string', 'max:2000'],
        ]);

        $announcement->comments()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        return back()->with('status', 'Comment posted.');
    }

    /** Delete a comment */
    public function destroy(AnnouncementComment $comment)
    {
        if (!auth()->user()->isAdmin() && $comment->user_id !== auth()->id()) {
            abort(403);
        }

        $comment->delete();

        return back()->with('status', 'Comment deleted.');
    }
}

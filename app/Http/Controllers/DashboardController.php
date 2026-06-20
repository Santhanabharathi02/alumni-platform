<?php

namespace App\Http\Controllers;

use App\Models\Alumni;
use App\Models\Announcement;
use App\Models\Donation;
use App\Models\Event;
use App\Models\JobListing;
use App\Models\Mentorship;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $stats = [
            'alumni'          => Alumni::count(),
            'events'          => Event::count(),
            'mentorships'     => Mentorship::count(),
            'donations'       => Donation::count(),
            'donation_total'  => Donation::sum('amount'),
            'jobs_open'       => JobListing::where('status', 'open')->count(),
            'unread_messages' => Message::where('is_read', false)->count(),
            'my_messages'     => $user->isAlumni() ? Message::where('from_user_id', $user->id)->count() : 0,
            'my_replies'      => $user->isAlumni() ? Message::where('from_user_id', $user->id)->whereNotNull('admin_reply')->count() : 0,
        ];

        $recentAlumni = Alumni::orderByDesc('created_at')->take(5)->get();

        $upcomingEvents = Event::where('starts_at', '>=', now())
            ->orderBy('starts_at')
            ->take(5)
            ->get();

        $latestAnnouncements = Announcement::where('is_published', true)
            ->orderByDesc('created_at')
            ->take(4)
            ->get();

        $myAlumni = ($user->isAlumni() && $user->alumni) ? $user->alumni->load(['mentorships', 'donations']) : null;

        return view('dashboard', compact('stats', 'recentAlumni', 'upcomingEvents', 'latestAnnouncements', 'myAlumni'));
    }
}

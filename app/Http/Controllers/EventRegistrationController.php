<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventRegistrationController extends Controller
{
    /** Alumni RSVPs for an event */
    public function store(Request $request, Event $event)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAlumni()) {
            abort(403);
        }

        $alumni = $user->alumni;

        if (!$alumni) {
            return back()->with('error', 'No alumni profile linked to your account.');
        }

        $existing = EventRegistration::where('event_id', $event->id)
            ->where('alumni_id', $alumni->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You have already registered for this event.');
        }

        EventRegistration::create([
            'event_id'  => $event->id,
            'alumni_id' => $alumni->id,
            'status'    => 'registered',
        ]);

        return back()->with('status', 'You have successfully registered for this event!');
    }

    /** Cancel RSVP */
    public function destroy(Event $event)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAlumni()) {
            abort(403);
        }

        $alumni = $user->alumni;

        if (!$alumni) {
            return back()->with('error', 'No alumni profile linked to your account.');
        }

        EventRegistration::where('event_id', $event->id)
            ->where('alumni_id', $alumni->id)
            ->delete();

        return back()->with('status', 'Your event registration has been cancelled.');
    }

    /** Admin: list all registrations for an event */
    public function index(Event $event)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!$user->isAdmin()) {
            abort(403);
        }

        $registrations = $event->registrations()->with('alumni')->latest()->get();
        return view('events.registrations', compact('event', 'registrations'));
    }
}

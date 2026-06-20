<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $query = Event::query();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        if ($request->filled('q')) {
            $search = $request->string('q');
            $query->where('title', 'like', "%{$search}%");
        }

        $events = $query->orderByDesc('starts_at')
            ->paginate(10)
            ->withQueryString();

        return view('events.index', compact('events'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('events.create', [
            'event' => new Event(),
        ]);
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $data = $this->validateEvent($request);
        Event::create($data);

        return redirect()->route('events.index')
            ->with('status', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $event->loadCount('registrations');
        $userHasRegistered = false;

        if (Auth::check() && Auth::user()?->role === 'alumni' && Auth::user()->alumni) {
            $userHasRegistered = $event->registrations()
                ->where('alumni_id', Auth::user()->alumni->id)
                ->exists();
        }

        return view('events.show', compact('event', 'userHasRegistered'));
    }

    public function edit(Event $event)
    {
        $this->authorizeAdmin();
        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $this->authorizeAdmin();
        $data = $this->validateEvent($request);
        $event->update($data);

        return redirect()->route('events.show', $event)
            ->with('status', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $this->authorizeAdmin();
        $event->delete();

        return redirect()->route('events.index')
            ->with('status', 'Event deleted.');
    }

    private function validateEvent(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'location' => ['nullable', 'string', 'max:255'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
            'organizer' => ['nullable', 'string', 'max:255'],
            'registration_url' => ['nullable', 'url', 'max:255'],
            'status' => ['required', 'string', 'in:planned,completed,cancelled'],
        ]);
    }

    private function authorizeAdmin(): void
    {
        if (Auth::check() && Auth::user()?->role !== 'admin') {
            abort(403);
        }
    }
}

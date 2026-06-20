@extends('layouts.app')

@section('title', 'Event Details')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ $event->title }}</h1>
            <p class="text-slate-500">{{ $event->starts_at->format('M d, Y g:i A') }} @if($event->location) · {{ $event->location }} @endif</p>
        </div>
        @if(auth()->user()->isAdmin())
            <div class="flex gap-3">
                <a href="{{ route('events.registrations', $event) }}" class="rounded-md border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:border-indigo-200 hover:text-indigo-600">Registrations ({{ $event->registrations_count }})</a>
                <a href="{{ route('events.edit', $event) }}" class="rounded-md border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:border-indigo-200 hover:text-indigo-600">Edit</a>
                <form method="POST" action="{{ route('events.destroy', $event) }}" onsubmit="return confirm('Delete this event?')">
                    @csrf
                    @method('DELETE')
                    <button class="border-0 text-sm text-rose-600 outline-none hover:text-rose-500 focus:outline-none focus:ring-0">Delete</button>
                </form>
            </div>
        @endif
    </div>

    @if(auth()->user()->isAlumni() && $event->status === 'planned')
        <div class="rounded-lg bg-white p-4 shadow-sm flex items-center justify-between">
            <div>
                <p class="font-medium">Event RSVP</p>
                <p class="text-sm text-slate-500">Reserve your spot for this event.</p>
            </div>
            @if($userHasRegistered)
                <form method="POST" action="{{ route('events.cancel-rsvp', $event) }}">
                    @csrf
                    @method('DELETE')
                    <button class="rounded-md border border-rose-200 px-4 py-2 text-sm font-medium text-rose-600 hover:bg-rose-50">Cancel RSVP</button>
                </form>
            @else
                <form method="POST" action="{{ route('events.rsvp', $event) }}">
                    @csrf
                    <button class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500">Register RSVP</button>
                </form>
            @endif
        </div>
    @endif

    <div class="rounded-lg bg-white p-6 shadow-sm">
        <div class="grid gap-4 md:grid-cols-2 text-sm">
            <div>
                <p class="text-slate-500">Status</p>
                <p class="font-medium capitalize">{{ $event->status }}</p>
            </div>
            <div>
                <p class="text-slate-500">Registrations</p>
                <p class="font-medium">{{ $event->registrations_count }}</p>
            </div>
            <div>
                <p class="text-slate-500">Organizer</p>
                <p class="font-medium">{{ $event->organizer ?? '—' }}</p>
            </div>
            <div>
                <p class="text-slate-500">End time</p>
                <p class="font-medium">{{ $event->ends_at?->format('M d, Y g:i A') ?? '—' }}</p>
            </div>
            <div>
                <p class="text-slate-500">Registration</p>
                <p class="font-medium">
                    @if($event->registration_url)
                        <a href="{{ $event->registration_url }}" class="text-indigo-600 hover:text-indigo-500" target="_blank" rel="noreferrer">Open link</a>
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>

        <div class="mt-6">
            <p class="text-slate-500">Description</p>
            <p class="mt-2 text-sm text-slate-700">{{ $event->description ?? 'No description provided.' }}</p>
        </div>
    </div>
</div>
@endsection

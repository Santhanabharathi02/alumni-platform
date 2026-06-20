@extends('layouts.app')

@section('title', 'Alumni Details')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div class="flex items-center gap-4">
            <img src="{{ $alumni->photo_url }}" alt="{{ $alumni->full_name }}" class="h-16 w-16 rounded-full object-cover border border-slate-200">
            <div>
                <h1 class="text-2xl font-semibold">{{ $alumni->full_name }}</h1>
                <p class="text-slate-500">{{ $alumni->email }} · {{ $alumni->phone ?? 'No phone on file' }}</p>
            </div>
        </div>
        @php
            $isAdmin = auth()->user()->isAdmin();
            $isOwner = auth()->user()->isAlumni() && auth()->user()->alumni && auth()->user()->alumni->id === $alumni->id;
            $hasAccount = \App\Models\User::where('email', $alumni->email)->exists();
        @endphp
        <div class="flex gap-3">
            @if($isAdmin || $isOwner)
                <a href="{{ route('alumni.edit', ['alumnus' => $alumni->id]) }}" class="rounded-md border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:border-indigo-200 hover:text-indigo-600">Edit</a>
            @endif
            @if($isAdmin)
                @if(!$hasAccount)
                    <form method="POST" action="{{ route('alumni.create-account', ['alumnus' => $alumni->id]) }}">
                        @csrf
                        <button type="submit" class="rounded-md border border-emerald-200 bg-emerald-50 px-4 py-2 text-sm font-medium text-emerald-700 hover:bg-emerald-100"
                                onclick="return confirm('Create a portal login account for {{ addslashes($alumni->full_name) }}?')">
                            Create Portal Account
                        </button>
                    </form>
                @else
                    <span class="rounded-md border border-slate-200 bg-slate-50 px-4 py-2 text-sm font-medium text-slate-400 cursor-default" title="This alumni already has a portal account">
                        ✓ Has Account
                    </span>
                @endif
                <form method="POST" action="{{ route('alumni.destroy', ['alumnus' => $alumni->id]) }}" onsubmit="return confirm('Delete this alumni profile?')">
                    @csrf
                    @method('DELETE')
                    <button class="border-0 text-sm text-rose-600 outline-none hover:text-rose-500 focus:outline-none focus:ring-0">Delete</button>
                </form>
            @endif
        </div>
    </div>

    <div class="grid gap-6 lg:grid-cols-3">
        <div class="rounded-lg bg-white p-6 shadow-sm lg:col-span-2">
            <h2 class="text-lg font-semibold">Profile</h2>
            <div class="mt-4 grid gap-4 md:grid-cols-2 text-sm">
                <div>
                    <p class="text-slate-500">Graduation Year</p>
                    <p class="font-medium">{{ $alumni->graduation_year ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Degree</p>
                    <p class="font-medium">{{ $alumni->degree ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Department</p>
                    <p class="font-medium">{{ $alumni->department ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Location</p>
                    <p class="font-medium">{{ $alumni->location ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Company</p>
                    <p class="font-medium">{{ $alumni->company ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Job Title</p>
                    <p class="font-medium">{{ $alumni->job_title ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Last Contacted</p>
                    <p class="font-medium">{{ $alumni->last_contacted_at?->format('M d, Y') ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">LinkedIn</p>
                    <p class="font-medium">
                        @if($alumni->linkedin_url)
                            <a href="{{ $alumni->linkedin_url }}" class="text-indigo-600 hover:text-indigo-500" target="_blank" rel="noreferrer">Profile</a>
                        @else
                            —
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-slate-500">Mentor Availability</p>
                    <p class="font-medium">{{ $alumni->is_mentor ? 'Yes' : 'No' }}</p>
                </div>
                <div>
                    <p class="text-slate-500">Internship Support</p>
                    <p class="font-medium">{{ $alumni->available_for_internships ? 'Yes' : 'No' }}</p>
                </div>
            </div>

            <div class="mt-6">
                <p class="text-slate-500">Bio</p>
                <p class="mt-2 text-sm text-slate-700">{{ $alumni->bio ?? 'No bio shared.' }}</p>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold">Mentorships</h2>
                <div class="mt-3 space-y-2 text-sm">
                    @forelse ($alumni->mentorships as $mentorship)
                        <div class="rounded-md border border-slate-100 p-3">
                            <p class="font-medium">{{ $mentorship->area_of_interest }}</p>
                            <p class="text-slate-500">Status: {{ ucfirst($mentorship->status) }}</p>
                        </div>
                    @empty
                        <p class="text-slate-500">No mentorships recorded.</p>
                    @endforelse
                </div>
                <a href="{{ route('mentorships.create') }}" class="mt-4 inline-flex text-sm text-indigo-600 hover:text-indigo-500">Create mentorship</a>
            </div>
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold">Donations</h2>
                <div class="mt-3 space-y-2 text-sm">
                    @forelse ($alumni->donations as $donation)
                        <div class="rounded-md border border-slate-100 p-3">
                            <p class="font-medium">{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</p>
                            <p class="text-slate-500">{{ $donation->donated_at->format('M d, Y') }}</p>
                        </div>
                    @empty
                        <p class="text-slate-500">No donations recorded.</p>
                    @endforelse
                </div>
                <a href="{{ route('donations.create') }}" class="mt-4 inline-flex text-sm text-indigo-600 hover:text-indigo-500">Log donation</a>
            </div>
            <div class="rounded-lg bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold">Event Registrations</h2>
                <div class="mt-3 space-y-2 text-sm">
                    @forelse ($alumni->eventRegistrations as $registration)
                        <div class="rounded-md border border-slate-100 p-3">
                            <p class="font-medium">{{ $registration->event->title ?? 'Event' }}</p>
                            <p class="text-slate-500">Status: {{ ucfirst($registration->status) }}</p>
                        </div>
                    @empty
                        <p class="text-slate-500">No event registrations recorded.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

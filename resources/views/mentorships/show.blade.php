@extends('layouts.app')

@section('title', 'Mentorship Details')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ $mentorship->area_of_interest }}</h1>
            <p class="text-slate-500">{{ $mentorship->alumni->full_name }} · {{ $mentorship->alumni->email }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('mentorships.edit', $mentorship) }}" class="rounded-md border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:border-indigo-200 hover:text-indigo-600">Edit</a>
            <form method="POST" action="{{ route('mentorships.destroy', $mentorship) }}" onsubmit="return confirm('Delete this mentorship?')">
                @csrf
                @method('DELETE')
                <button class="border-0 text-sm text-rose-600 outline-none hover:text-rose-500 focus:outline-none focus:ring-0">Delete</button>
            </form>
        </div>
    </div>

    <div class="rounded-lg bg-white p-6 shadow-sm">
        <div class="grid gap-4 md:grid-cols-2 text-sm">
            <div>
                <p class="text-slate-500">Status</p>
                <p class="font-medium capitalize">{{ $mentorship->status }}</p>
            </div>
            <div>
                <p class="text-slate-500">Availability</p>
                <p class="font-medium">{{ $mentorship->availability ?? '—' }}</p>
            </div>
            <div>
                <p class="text-slate-500">Start date</p>
                <p class="font-medium">{{ $mentorship->started_at?->format('M d, Y') ?? '—' }}</p>
            </div>
            <div>
                <p class="text-slate-500">End date</p>
                <p class="font-medium">{{ $mentorship->ended_at?->format('M d, Y') ?? '—' }}</p>
            </div>
        </div>

        <div class="mt-6">
            <p class="text-slate-500">Notes</p>
            <p class="mt-2 text-sm text-slate-700">{{ $mentorship->notes ?? 'No notes provided.' }}</p>
        </div>
    </div>
</div>
@endsection

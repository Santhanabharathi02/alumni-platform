@extends('layouts.app')

@section('title', 'Events')
@section('page-title', 'Events')

@section('content')
<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="page-header-title">Events</h1>
            <p class="page-header-sub">Plan reunions, networking sessions, and mentorship workshops.</p>
        </div>
        @if(auth()->user()->isAdmin())
            <a href="{{ route('events.create') }}" class="btn btn-primary">Create Event</a>
        @endif
    </div>

    <form method="GET" class="card p-5 flex flex-wrap gap-3 items-end">
        <input name="q" value="{{ request('q') }}" placeholder="Search by title" class="form-input w-full max-w-md rounded-md" style="height: 40px; padding: 8px 12px; border: 1px solid #e2e8f0;" />
        <select name="status" class="form-input rounded-md border-slate-200">
            <option value="">All status</option>
            @foreach (['planned' => 'Planned', 'completed' => 'Completed', 'cancelled' => 'Cancelled'] as $value => $label)
                <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button class="btn btn-secondary">Filter</button>
    </form>

    <div class="table-wrap">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Event</th>
                    <th class="px-4 py-3">Schedule</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">RSVPs</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($events as $event)
                    <tr>
                        <td class="px-4 py-3">
                            <p class="font-medium">{{ $event->title }}</p>
                            <p class="text-xs text-slate-500">{{ $event->location ?? 'No location' }}</p>
                        </td>
                        <td class="px-4 py-3">{{ $event->starts_at->format('M d, Y g:i A') }}</td>
                        <td class="px-4 py-3"><span class="badge {{ $event->status === 'planned' ? 'badge-indigo' : ($event->status === 'completed' ? 'badge-emerald' : 'badge-rose') }}">{{ ucfirst($event->status) }}</span></td>
                        <td class="px-4 py-3">{{ $event->registrations()->count() }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-3">
                                <a href="{{ route('events.show', $event) }}" class="text-indigo-600 hover:text-indigo-500">View</a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('events.edit', $event) }}" class="text-slate-600 hover:text-slate-500">Edit</a>
                                    <form method="POST" action="{{ route('events.destroy', $event) }}" class="inline" onsubmit="return confirm('Delete this event?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="border-0 text-rose-600 outline-none hover:text-rose-500 focus:outline-none focus:ring-0">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-slate-500">No events found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $events->links() }}
    </div>
</div>
@endsection

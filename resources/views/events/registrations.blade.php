@extends('layouts.app')
@section('title', 'Registrations – ' . $event->title)
@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-3 text-sm text-slate-500">
        <a href="{{ route('events.index') }}" class="hover:text-indigo-600">Events</a>
        <span>/</span>
        <a href="{{ route('events.show', $event) }}" class="hover:text-indigo-600">{{ $event->title }}</a>
        <span>/</span>
        <span class="text-slate-800">Registrations</span>
    </div>

    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-semibold">Event Registrations</h1>
            <p class="text-slate-500">{{ $event->title }} — {{ $registrations->count() }} registered</p>
        </div>
    </div>

    <div class="overflow-hidden rounded-lg bg-white shadow-sm">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Alumni</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Registered At</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($registrations as $reg)
                <tr>
                    <td class="px-4 py-3 font-medium">
                        <a href="{{ route('alumni.show', ['alumnus' => $reg->alumni->id]) }}" class="text-indigo-600 hover:text-indigo-500">
                            {{ $reg->alumni->full_name }}
                        </a>
                    </td>
                    <td class="px-4 py-3">{{ $reg->alumni->email }}</td>
                    <td class="px-4 py-3">
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-medium
                            @if($reg->status === 'attended') bg-emerald-100 text-emerald-700
                            @elseif($reg->status === 'cancelled') bg-red-100 text-red-600
                            @else bg-blue-100 text-blue-700 @endif">
                            {{ ucfirst($reg->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $reg->created_at->format('M d, Y g:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-slate-500">No registrations yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

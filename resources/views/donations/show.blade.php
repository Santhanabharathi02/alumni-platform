@extends('layouts.app')

@section('title', 'Donation Details')

@section('content')
<div class="space-y-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-semibold">{{ $donation->donor_name }}</h1>
            <p class="text-slate-500">{{ $donation->donated_at->format('M d, Y') }} · {{ $donation->currency }} {{ number_format($donation->amount, 2) }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('donations.edit', $donation) }}" class="rounded-md border border-slate-200 px-4 py-2 text-sm font-medium text-slate-700 hover:border-indigo-200 hover:text-indigo-600">Edit</a>
            <form method="POST" action="{{ route('donations.destroy', $donation) }}" onsubmit="return confirm('Delete this donation?')">
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
                <p class="font-medium capitalize">{{ $donation->status }}</p>
            </div>
            <div>
                <p class="text-slate-500">Donor email</p>
                <p class="font-medium">{{ $donation->donor_email ?? '—' }}</p>
            </div>
            <div>
                <p class="text-slate-500">Purpose</p>
                <p class="font-medium">{{ $donation->purpose ?? '—' }}</p>
            </div>
            <div>
                <p class="text-slate-500">Linked alumni</p>
                <p class="font-medium">
                    @if($donation->alumni)
                        <a href="{{ route('alumni.show', ['alumnus' => $donation->alumni->id]) }}" class="text-indigo-600 hover:text-indigo-500">{{ $donation->alumni->full_name }}</a>
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>

        <div class="mt-6">
            <p class="text-slate-500">Notes</p>
            <p class="mt-2 text-sm text-slate-700">{{ $donation->notes ?? 'No notes provided.' }}</p>
        </div>
    </div>
</div>
@endsection

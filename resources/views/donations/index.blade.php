@extends('layouts.app')

@section('title', 'Donations')
@section('page-title', 'Donations')

@section('content')
<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="page-header-title">Donations</h1>
            <p class="page-header-sub">Track alumni contributions, pledges, and fundraising outcomes.</p>
        </div>
        <a href="{{ route('donations.create') }}" class="btn btn-primary">Log Donation</a>
    </div>

    <form method="GET" class="card p-5 flex flex-wrap gap-3 items-end">
        <select name="status" class="form-input rounded-md border-slate-200">
            <option value="">All status</option>
            @foreach (['received' => 'Received', 'pledged' => 'Pledged'] as $value => $label)
                <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button class="btn btn-secondary">Filter</button>
    </form>

    <div class="table-wrap">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Donor</th>
                    <th class="px-4 py-3">Amount</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($donations as $donation)
                    <tr>
                        <td class="px-4 py-3">
                            <p class="font-medium">{{ $donation->donor_name }}</p>
                            <p class="text-xs text-slate-500">{{ $donation->donor_email ?? 'No email' }}</p>
                        </td>
                        <td class="px-4 py-3">{{ $donation->currency }} {{ number_format($donation->amount, 2) }}</td>
                        <td class="px-4 py-3">{{ $donation->donated_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3"><span class="badge {{ $donation->status === 'received' ? 'badge-emerald' : 'badge-amber' }}">{{ ucfirst($donation->status) }}</span></td>
                        <td class="px-4 py-3 text-right">
                            @php
                                $canManageDonation = auth()->user()->isAdmin() || (auth()->user()->isAlumni() && auth()->user()->alumni && auth()->user()->alumni->id === $donation->alumni_id);
                            @endphp
                            <div class="inline-flex items-center gap-3">
                                <a href="{{ route('donations.show', $donation) }}" class="text-indigo-600 hover:text-indigo-500">View</a>
                                @if($canManageDonation)
                                    <a href="{{ route('donations.edit', $donation) }}" class="text-slate-600 hover:text-slate-500">Edit</a>
                                    <form method="POST" action="{{ route('donations.destroy', $donation) }}" class="inline" onsubmit="return confirm('Delete this donation?')">
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
                        <td colspan="5" class="px-4 py-6 text-center text-slate-500">No donations found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $donations->links() }}
    </div>
</div>
@endsection

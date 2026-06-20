@extends('layouts.app')

@section('title', 'Mentorships')
@section('page-title', 'Mentorships')

@section('content')
<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="page-header-title">Mentorships</h1>
            <p class="page-header-sub">Track mentorship opportunities, status, and alumni participation.</p>
        </div>
        <a href="{{ route('mentorships.create') }}" class="btn btn-primary">New Mentorship</a>
    </div>

    <form method="GET" class="card p-5 flex flex-wrap gap-3 items-end">
        <select name="status" class="form-input rounded-md border-slate-200">
            <option value="">All status</option>
            @foreach (['open' => 'Open', 'active' => 'Active', 'closed' => 'Closed'] as $value => $label)
                <option value="{{ $value }}" {{ request('status') === $value ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <button class="btn btn-secondary">Filter</button>
    </form>

    <div class="table-wrap">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Alumni</th>
                    <th class="px-4 py-3">Focus</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($mentorships as $mentorship)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $mentorship->alumni->full_name }}</td>
                        <td class="px-4 py-3">{{ $mentorship->area_of_interest }}</td>
                        <td class="px-4 py-3"><span class="badge {{ $mentorship->status === 'active' ? 'badge-emerald' : ($mentorship->status === 'open' ? 'badge-indigo' : 'badge-slate') }}">{{ ucfirst($mentorship->status) }}</span></td>
                        <td class="px-4 py-3 text-right">
                            @php
                                $canManageMentorship = auth()->user()->isAdmin() || (auth()->user()->isAlumni() && auth()->user()->alumni && auth()->user()->alumni->id === $mentorship->alumni_id);
                            @endphp
                            <div class="inline-flex items-center gap-3">
                                <a href="{{ route('mentorships.show', $mentorship) }}" class="text-indigo-600 hover:text-indigo-500">View</a>
                                @if($canManageMentorship)
                                    <a href="{{ route('mentorships.edit', $mentorship) }}" class="text-slate-600 hover:text-slate-500">Edit</a>
                                    <form method="POST" action="{{ route('mentorships.destroy', $mentorship) }}" class="inline" onsubmit="return confirm('Delete this mentorship?')">
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
                        <td colspan="4" class="px-4 py-6 text-center text-slate-500">No mentorships found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $mentorships->links() }}
    </div>
</div>
@endsection

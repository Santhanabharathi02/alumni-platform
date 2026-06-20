@extends('layouts.app')

@section('title', 'Alumni Directory')
@section('page-title', 'Alumni Directory')

@section('content')
<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="page-header-title">Alumni Directory</h1>
            <p class="page-header-sub">Manage alumni contact details, career updates, and engagement preferences.</p>
        </div>
        <div class="flex gap-2">
            @if(auth()->user()->isAdmin())
                <a href="{{ route('alumni.export') }}" class="btn btn-secondary">Export CSV</a>
                <a href="{{ route('alumni.create') }}" class="btn btn-primary">Add Alumni</a>
            @endif
        </div>
    </div>

    <form method="GET" class="card p-5 flex flex-wrap gap-3 items-end">
        <input name="q" value="{{ request('q') }}" placeholder="Search by name, email, company" class="form-input w-full max-w-md rounded-md" style="height: 40px; padding: 8px 12px; display: flex; align-items: center; border: none; background-color: #f8fafc;" />
        <select name="department" class="form-input rounded-md" style="border: none; background-color: #f8fafc;">
            <option value="">All Departments</option>
            @foreach(($departments ?? []) as $department)
                <option value="{{ $department }}" {{ request('department') === $department ? 'selected' : '' }}>{{ $department }}</option>
            @endforeach
        </select>
        <select name="graduation_year" class="form-input rounded-md" style="border: none; background-color: #f8fafc;">
            <option value="">All Years</option>
            @foreach(($gradYears ?? []) as $year)
                <option value="{{ $year }}" {{ (string)request('graduation_year') === (string)$year ? 'selected' : '' }}>{{ $year }}</option>
            @endforeach
        </select>
        <label class="inline-flex items-center gap-2 text-sm text-slate-700">
            <input type="checkbox" name="mentor" value="1" class="form-check rounded border-slate-300" {{ request('mentor') ? 'checked' : '' }}>
            Mentors only
        </label>
        <div class="inline-flex items-center gap-2">
            <button class="btn btn-secondary" style="height: 40px;">Search</button>
            <a href="{{ route('alumni.index') }}" class="inline-flex h-10 items-center text-sm text-slate-500 hover:text-slate-700">Clear</a>
        </div>
    </form>

    <div class="table-wrap">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Career</th>
                    <th class="px-4 py-3">Graduation</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($alumni as $alumnus)
                    <tr>
                        <td class="px-4 py-3 font-medium">
                            <div class="flex items-center gap-3">
                                <img src="{{ $alumnus->photo_url }}" alt="{{ $alumnus->full_name }}" class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                <div>
                                    {{ $alumnus->full_name }} @if($alumnus->is_mentor)<span class="badge badge-emerald ml-2">Mentor</span>@endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">{{ $alumnus->email }}</td>
                        <td class="px-4 py-3">{{ $alumnus->job_title ?? '—' }} @if($alumnus->company) · {{ $alumnus->company }} @endif</td>
                        <td class="px-4 py-3">{{ $alumnus->graduation_year ?? '—' }}</td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-3">
                                <a href="{{ route('alumni.show', ['alumnus' => $alumnus->id]) }}" class="text-indigo-600 hover:text-indigo-500">View</a>
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('alumni.edit', ['alumnus' => $alumnus->id]) }}" class="text-slate-600 hover:text-slate-500">Edit</a>
                                    <form method="POST" action="{{ route('alumni.destroy', ['alumnus' => $alumnus->id]) }}" class="inline" onsubmit="return confirm('Delete this alumni profile?')">
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
                        <td colspan="5" class="px-4 py-6 text-center text-slate-500">No alumni found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $alumni->links() }}
    </div>
</div>
@endsection

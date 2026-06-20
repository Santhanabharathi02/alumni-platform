@extends('layouts.app')
@section('title', 'Job Board & Internships')
@section('page-title', 'Job Board & Internships')
@section('content')
<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="page-header-title">Job Board & Internships</h1>
            <p class="page-header-sub">Career opportunities shared by alumni and the institution.</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('jobs.create') }}" class="btn btn-primary">Post a Job</a>
        @endif
    </div>

    <form method="GET" style="background:#fff;border-radius:20px;box-shadow:0 1px 4px rgba(0,0,0,0.07);padding:16px 20px;">
        <div style="display:flex;flex-wrap:wrap;gap:10px;align-items:center;">
            <input name="q" value="{{ request('q') }}" placeholder="Search title, company, dept..."
                style="flex:1;min-width:200px;height:38px;padding:0 12px;border:1px solid #cbd5e1;border-radius:6px;font-size:0.875rem;background:#fff;outline:none;box-sizing:border-box;" />
            <select name="type" style="height:38px;padding:0 10px;border:1px solid #cbd5e1;border-radius:6px;font-size:0.875rem;background:#fff;outline:none;min-width:130px;">
                <option value="">All Types</option>
                <option value="full-time" @selected(request('type')=='full-time')>Full-Time</option>
                <option value="part-time" @selected(request('type')=='part-time')>Part-Time</option>
                <option value="internship" @selected(request('type')=='internship')>Internship</option>
                <option value="contract" @selected(request('type')=='contract')>Contract</option>
            </select>
            @if(auth()->user()->isAdmin())
            <select name="status" style="height:38px;padding:0 10px;border:1px solid #cbd5e1;border-radius:6px;font-size:0.875rem;background:#fff;outline:none;min-width:110px;">
                <option value="open" @selected(request('status','open')=='open')>Open</option>
                <option value="closed" @selected(request('status')=='closed')>Closed</option>
                <option value="filled" @selected(request('status')=='filled')>Filled</option>
            </select>
            @endif
            <button type="submit" style="height:38px;padding:0 20px;background:#fff;color:#374151;border:1px solid #cbd5e1;border-radius:6px;font-size:0.875rem;font-weight:600;cursor:pointer;white-space:nowrap;">Filter</button>
            <a href="{{ route('jobs.index') }}" style="height:38px;display:inline-flex;align-items:center;font-size:0.875rem;color:#64748b;text-decoration:none;white-space:nowrap;" onmouseover="this.style.color='#334155'" onmouseout="this.style.color='#64748b'">Clear</a>
        </div>
    </form>

    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($jobs as $job)
        <div class="rounded-lg bg-white shadow-sm p-5 flex flex-col justify-between">
            <div>
                <div class="flex items-start justify-between gap-2 mb-2">
                    <h3 class="font-semibold text-slate-900">{{ $job->title }}</h3>
                    <span class="shrink-0 rounded-full px-2 py-0.5 text-xs font-medium
                        @if($job->type === 'internship') bg-amber-100 text-amber-700
                        @elseif($job->type === 'full-time') bg-emerald-100 text-emerald-700
                        @else bg-slate-100 text-slate-600 @endif">
                        {{ ucfirst($job->type) }}
                    </span>
                </div>
                <p class="text-sm font-medium text-indigo-700">{{ $job->company }}</p>
                @if($job->location)
                    <p class="text-xs text-slate-500 mt-1">{{ $job->location }}</p>
                @endif
                @if($job->department)
                    <p class="text-xs text-slate-500">{{ $job->department }}</p>
                @endif
                @if($job->salary_min || $job->salary_max)
                    <p class="text-xs text-emerald-600 mt-2 font-medium">
                        @if($job->salary_min && $job->salary_max)
                            ${{ number_format($job->salary_min) }} – ${{ number_format($job->salary_max) }}
                        @elseif($job->salary_min)
                            From ${{ number_format($job->salary_min) }}
                        @else
                            Up to ${{ number_format($job->salary_max) }}
                        @endif
                    </p>
                @endif
                <p class="text-sm text-slate-600 mt-3 line-clamp-2">{{ Str::limit($job->description, 120) }}</p>
            </div>
            <div class="flex items-center justify-between mt-4 pt-3 border-t border-slate-100">
                <span class="text-xs text-slate-400">{{ $job->created_at->diffForHumans() }}</span>
                <div class="inline-flex items-center gap-3">
                    <a href="{{ route('jobs.show', $job) }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">View Details</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('jobs.edit', $job) }}" class="text-sm font-medium text-slate-600 hover:text-slate-500">Edit</a>
                        <form method="POST" action="{{ route('jobs.destroy', $job) }}" class="inline" onsubmit="return confirm('Delete this listing?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border-0 text-sm font-medium text-rose-600 outline-none hover:text-rose-500 focus:outline-none focus:ring-0">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 rounded-lg bg-white shadow-sm p-10 text-center text-slate-500">
            No job listings found. Check back soon!
        </div>
        @endforelse
    </div>

    <div>{{ $jobs->links() }}</div>
</div>
@endsection

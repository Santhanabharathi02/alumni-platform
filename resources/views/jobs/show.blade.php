@extends('layouts.app')
@section('title', $job->title . ' – Job Details')
@section('content')
<div class="space-y-6 max-w-3xl">
    <div class="flex items-center gap-3 text-sm text-slate-500">
        <a href="{{ route('jobs.index') }}" class="hover:text-indigo-600">Job Board</a>
        <span>/</span>
        <span class="text-slate-800 font-medium">{{ $job->title }}</span>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6 space-y-5">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h1 class="text-2xl font-semibold">{{ $job->title }}</h1>
                <p class="text-lg text-indigo-700 font-medium mt-1">{{ $job->company }}</p>
                <div class="flex flex-wrap gap-2 mt-2">
                    <span class="rounded-full bg-indigo-100 text-indigo-700 px-3 py-0.5 text-xs font-medium">{{ ucfirst($job->type) }}</span>
                    @if($job->location)
                        <span class="rounded-full bg-slate-100 text-slate-600 px-3 py-0.5 text-xs">{{ $job->location }}</span>
                    @endif
                    @if($job->department)
                        <span class="rounded-full bg-slate-100 text-slate-600 px-3 py-0.5 text-xs">{{ $job->department }}</span>
                    @endif
                    <span class="rounded-full px-3 py-0.5 text-xs font-medium {{ $job->status === 'open' ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-600' }}">
                        {{ ucfirst($job->status) }}
                    </span>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
            <div class="flex gap-2">
                <a href="{{ route('jobs.edit', $job) }}" class="rounded-md border border-slate-200 px-3 py-1.5 text-sm text-slate-700 hover:border-indigo-200 hover:text-indigo-600">Edit</a>
                <form method="POST" action="{{ route('jobs.destroy', $job) }}" onsubmit="return confirm('Delete this listing?')">
                    @csrf @method('DELETE')
                    <button class="border-0 text-sm text-rose-600 outline-none hover:text-rose-500 focus:outline-none focus:ring-0">Delete</button>
                </form>
            </div>
            @endif
        </div>

        @if($job->salary_min || $job->salary_max)
        <div class="rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3">
            <p class="text-sm font-medium text-emerald-800">
                Salary:
                @if($job->salary_min && $job->salary_max)
                    ${{ number_format($job->salary_min) }} – ${{ number_format($job->salary_max) }} per year
                @elseif($job->salary_min)
                    From ${{ number_format($job->salary_min) }} per year
                @else
                    Up to ${{ number_format($job->salary_max) }} per year
                @endif
            </p>
        </div>
        @endif

        <div>
            <h2 class="text-base font-semibold mb-2">Job Description</h2>
            <div class="text-sm text-slate-700 whitespace-pre-line leading-relaxed">{{ $job->description }}</div>
        </div>

        @if($job->requirements)
        <div>
            <h2 class="text-base font-semibold mb-2">Requirements</h2>
            <div class="text-sm text-slate-700 whitespace-pre-line leading-relaxed">{{ $job->requirements }}</div>
        </div>
        @endif

        <div class="border-t border-slate-100 pt-4 space-y-1 text-sm text-slate-600">
            @if($job->expires_at)
                <p>Application Deadline: <span class="font-medium">{{ $job->expires_at->format('M d, Y') }}</span></p>
            @endif
            @if($job->contact_email)
                <p>Contact: <a href="mailto:{{ $job->contact_email }}" class="text-indigo-600 hover:underline">{{ $job->contact_email }}</a></p>
            @endif
            <p class="text-xs text-slate-400">Posted {{ $job->created_at->diffForHumans() }}</p>
        </div>

        @if($job->apply_url && $job->status === 'open')
        <div>
            <a href="{{ $job->apply_url }}" target="_blank"
               class="inline-block rounded-md bg-indigo-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-indigo-500">
                Apply Now →
            </a>
        </div>
        @elseif($job->contact_email && $job->status === 'open')
        <div>
            <a href="mailto:{{ $job->contact_email }}?subject=Application: {{ $job->title }}"
               class="inline-block rounded-md bg-indigo-600 px-6 py-2.5 text-sm font-medium text-white hover:bg-indigo-500">
                Apply via Email →
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@extends('layouts.app')
@section('title', 'Announcements')
@section('page-title', 'Announcements')
@section('content')
<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="page-header-title">Announcements</h1>
            <p class="page-header-sub">Institution news, event notices, and career updates.</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('announcements.create') }}" class="btn btn-primary">New Announcement</a>
        @endif
    </div>

    <form method="GET" class="card p-5 flex flex-wrap gap-3 items-end">
        <select name="category" class="form-input rounded-md border-slate-200 text-sm">
            <option value="">All Categories</option>
            @foreach(['general','event','career','urgent'] as $cat)
                <option value="{{ $cat }}" @selected(request('category') === $cat)>{{ ucfirst($cat) }}</option>
            @endforeach
        </select>
        <button class="btn btn-secondary">Filter</button>
        <a href="{{ route('announcements.index') }}" class="text-sm text-slate-500 hover:text-slate-700 py-2">Clear</a>
    </form>

    <div class="space-y-4">
        @forelse($announcements as $ann)
        <div class="rounded-lg bg-white shadow-sm p-5
            @if($ann->category === 'urgent') border-l-4 border-red-500 @endif">
            <div class="flex flex-wrap items-start justify-between gap-3">
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2 mb-1">
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-medium
                            @if($ann->category === 'urgent') bg-red-100 text-red-700
                            @elseif($ann->category === 'event') bg-blue-100 text-blue-700
                            @elseif($ann->category === 'career') bg-emerald-100 text-emerald-700
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst($ann->category) }}
                        </span>
                        @if(!$ann->is_published)
                            <span class="rounded-full bg-amber-100 text-amber-700 px-2.5 py-0.5 text-xs font-medium">Draft</span>
                        @endif
                        <span class="text-xs text-slate-400">{{ $ann->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="font-semibold text-slate-900 text-base">{{ $ann->title }}</h3>
                    <p class="text-sm text-slate-600 mt-1 line-clamp-2">{{ Str::limit(strip_tags($ann->body), 160) }}</p>
                </div>
                <div class="inline-flex items-center gap-3">
                    <a href="{{ route('announcements.show', $ann) }}" class="text-sm text-indigo-600 hover:text-indigo-500">View</a>
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('announcements.edit', $ann) }}" class="text-sm text-slate-600 hover:text-slate-500">Edit</a>
                        <form method="POST" action="{{ route('announcements.destroy', $ann) }}" class="inline" onsubmit="return confirm('Delete this announcement?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="border-0 text-sm text-rose-600 outline-none hover:text-rose-500 focus:outline-none focus:ring-0">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="rounded-lg bg-white shadow-sm p-10 text-center text-slate-500">
            No announcements yet.
        </div>
        @endforelse
    </div>

    <div>{{ $announcements->links() }}</div>
</div>
@endsection

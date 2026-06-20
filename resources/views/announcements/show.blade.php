@extends('layouts.app')
@section('title', $announcement->title)
@section('content')
<div class="max-w-3xl space-y-6">
    <div class="flex items-center gap-3 text-sm text-slate-500">
        <a href="{{ route('announcements.index') }}" class="hover:text-indigo-600">Announcements</a>
        <span>/</span>
        <span class="text-slate-800 font-medium">{{ Str::limit($announcement->title, 40) }}</span>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center gap-2 mb-3">
            <span class="rounded-full px-2.5 py-0.5 text-xs font-medium
                @if($announcement->category === 'urgent') bg-red-100 text-red-700
                @elseif($announcement->category === 'event') bg-blue-100 text-blue-700
                @elseif($announcement->category === 'career') bg-emerald-100 text-emerald-700
                @else bg-slate-100 text-slate-600 @endif">
                {{ ucfirst($announcement->category) }}
            </span>
            <span class="text-xs text-slate-400">{{ $announcement->created_at->format('M d, Y') }}</span>
            @if($announcement->author)
                <span class="text-xs text-slate-400">by {{ $announcement->author->name }}</span>
            @endif
        </div>

        <h1 class="text-2xl font-semibold text-slate-900 mb-4">{{ $announcement->title }}</h1>
        <div class="text-slate-700 leading-relaxed whitespace-pre-line text-sm">{{ $announcement->body }}</div>

        @if($announcement->expires_at)
            <p class="mt-4 text-xs text-slate-400">Valid until {{ $announcement->expires_at->format('M d, Y') }}</p>
        @endif
    </div>

    @if(auth()->user()->isAdmin())
    <div class="flex gap-3">
        <a href="{{ route('announcements.edit', $announcement) }}"
           class="rounded-md border border-slate-200 px-4 py-2 text-sm text-slate-700 hover:border-indigo-200 hover:text-indigo-600">Edit</a>
        <form method="POST" action="{{ route('announcements.destroy', $announcement) }}" onsubmit="return confirm('Delete this announcement?')">
            @csrf @method('DELETE')
            <button class="border-0 text-sm text-rose-600 outline-none hover:text-rose-500 focus:outline-none focus:ring-0">Delete</button>
        </form>
    </div>
    @endif
</div>

{{-- ── Comments Section ── --}}
<div class="max-w-3xl mt-6 space-y-4">
    <h3 class="text-base font-semibold text-slate-800">
        Comments
        <span class="ml-2 rounded-full bg-slate-100 text-slate-600 px-2.5 py-0.5 text-xs font-medium">{{ $announcement->comments->count() }}</span>
    </h3>

    {{-- Post a comment --}}
    <div class="bg-white rounded-lg shadow-sm p-5">
        <form method="POST" action="{{ route('announcement.comments.store', $announcement) }}" class="space-y-3">
            @csrf
            <textarea name="body" rows="3" required
                placeholder="Write a comment or question..."
                class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('body') }}</textarea>
            <button type="submit" class="btn btn-primary" style="padding:7px 18px;font-size:0.85rem;">Post Comment</button>
        </form>
    </div>

    {{-- List comments --}}
    @forelse($announcement->comments as $comment)
    <div class="bg-white rounded-lg shadow-sm p-5">
        <div class="flex items-center justify-between gap-3 mb-2">
            <div class="flex items-center gap-2">
                <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,#3F00FF,#4B0082);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.75rem;font-weight:700;flex-shrink:0;">
                    {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                </div>
                <div>
                    <span class="text-sm font-semibold text-slate-800">{{ $comment->user->name }}</span>
                    @if($comment->user->isAdmin())
                        <span class="ml-1 rounded-full bg-indigo-100 text-indigo-700 px-2 py-0.5 text-xs font-medium">Admin</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-400">{{ $comment->created_at->diffForHumans() }}</span>
                @if(auth()->user()->isAdmin() || $comment->user_id === auth()->id())
                <form method="POST" action="{{ route('announcement.comments.destroy', $comment) }}" class="inline" onsubmit="return confirm('Delete comment?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="border-0 text-xs text-rose-500 outline-none hover:text-rose-700 focus:outline-none focus:ring-0">Delete</button>
                </form>
                @endif
            </div>
        </div>
        <p class="text-sm text-slate-700 whitespace-pre-line">{{ $comment->body }}</p>
    </div>
    @empty
    <div class="bg-white rounded-lg shadow-sm p-6 text-center text-sm text-slate-500">
        No comments yet. Be the first to comment!
    </div>
    @endforelse
</div>
@endsection

@extends('layouts.app')
@section('title', $message->subject)
@section('page-title', 'Message Detail')
@section('content')
<div class="max-w-2xl space-y-6">

    <div class="flex items-center gap-3 text-sm text-slate-500">
        <a href="{{ route('messages.index') }}" class="hover:text-indigo-600">Messages</a>
        <span>/</span>
        <span class="text-slate-800 font-medium">{{ Str::limit($message->subject, 50) }}</span>
    </div>

    @php $isAdminInitiated = $message->isAdminInitiated(); @endphp

    {{-- Original Message --}}
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-start justify-between gap-4 mb-4">
            <div>
                <h2 class="text-lg font-semibold text-slate-900">{{ $message->subject }}</h2>
                <p class="text-sm text-slate-500 mt-0.5">
                    From: <span class="font-medium text-slate-700">{{ $message->sender->name }}</span>
                    @if($isAdminInitiated)
                        &middot; To: <span class="font-medium text-slate-700">{{ $message->recipient->name ?? '—' }}</span>
                    @endif
                    &middot; {{ $message->created_at->format('M d, Y g:i A') }}
                </p>
            </div>
            @if($isAdminInitiated)
                @if($message->alumni_reply)
                    <span class="badge badge-emerald shrink-0">Replied</span>
                @elseif($message->is_read)
                    <span class="badge badge-amber shrink-0">Seen</span>
                @else
                    <span class="badge badge-indigo shrink-0">Sent</span>
                @endif
            @else
                @if($message->admin_reply)
                    <span class="badge badge-emerald shrink-0">Replied</span>
                @elseif($message->is_read)
                    <span class="badge badge-amber shrink-0">Seen</span>
                @else
                    <span class="badge badge-indigo shrink-0">Pending</span>
                @endif
            @endif
        </div>

        <div class="rounded-lg bg-slate-50 border border-slate-200 p-4 text-sm text-slate-700 whitespace-pre-line leading-relaxed">
            {{ $message->body }}
        </div>
    </div>

    @if($isAdminInitiated)
        {{-- Alumni reply to admin-initiated thread --}}
        @if($message->alumni_reply)
        <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-6">
            <div class="flex items-center gap-2 mb-3">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-emerald-600"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                <span class="text-sm font-semibold text-emerald-700">Alumni Reply</span>
                <span class="text-xs text-slate-400">&middot; {{ $message->alumni_replied_at->format('M d, Y g:i A') }}</span>
            </div>
            <p class="text-sm text-slate-700 whitespace-pre-line leading-relaxed">{{ $message->alumni_reply }}</p>
        </div>
        @endif

        {{-- Reply form for alumni receiving admin-initiated message --}}
        @if(!auth()->user()->isAdmin() && !$message->alumni_reply)
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4">Send Reply</h3>

            @if(session('status'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('messages.alumni-reply', $message) }}" class="space-y-4">
                @csrf
                <textarea name="alumni_reply" rows="5" required
                    placeholder="Type your reply here..."
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('alumni_reply') }}</textarea>
                <button type="submit" class="btn btn-primary">Send Reply</button>
            </form>
        </div>
        @endif

    @else
        {{-- Admin reply to alumni-sent message --}}
        @if($message->admin_reply)
        <div class="bg-indigo-50 border border-indigo-200 rounded-lg p-6">
            <div class="flex items-center gap-2 mb-3">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="text-indigo-600"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                <span class="text-sm font-semibold text-indigo-700">Admin Reply</span>
                <span class="text-xs text-slate-400">&middot; {{ $message->replied_at->format('M d, Y g:i A') }}</span>
            </div>
            <p class="text-sm text-slate-700 whitespace-pre-line leading-relaxed">{{ $message->admin_reply }}</p>
        </div>
        @endif

        {{-- Reply form (admin only, only if not replied yet) --}}
        @if(auth()->user()->isAdmin() && !$message->admin_reply)
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h3 class="text-base font-semibold text-slate-800 mb-4">Send Reply</h3>

            @if(session('status'))
            <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('messages.reply', $message) }}" class="space-y-4">
                @csrf
                <textarea name="admin_reply" rows="5" required
                    placeholder="Type your reply here..."
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('admin_reply') }}</textarea>
                <button type="submit" class="btn btn-primary">Send Reply</button>
            </form>
        </div>
        @endif
    @endif

    <div class="flex gap-3">
        <a href="{{ route('messages.index') }}" class="btn btn-secondary">← Back to Inbox</a>
        <form method="POST" action="{{ route('messages.destroy', $message) }}" class="inline" onsubmit="return confirm('Delete this message?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn" style="background:#fff;color:#dc2626;border:1.5px solid #fecaca;">Delete</button>
        </form>
    </div>
</div>
@endsection

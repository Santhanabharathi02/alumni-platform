@extends('layouts.app')
@section('title', 'Messages')
@section('page-title', 'Messages')
@section('content')
<div class="space-y-6">
    <div class="page-header">
        <div>
            <h1 class="page-header-title">
                @if(auth()->user()->isAdmin()) Message Inbox @else My Messages @endif
            </h1>
            <p class="page-header-sub">
                @if(auth()->user()->isAdmin())
                    All messages between alumni and admin.
                @else
                    Send a message to the admin or view your message history.
                @endif
            </p>
        </div>
        <a href="{{ route('messages.create') }}" class="btn btn-primary">
            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Message
        </a>
    </div>

    <div class="table-wrap">
        <table class="min-w-full divide-y divide-slate-200 text-sm">
            <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                <tr>
                    @if(auth()->user()->isAdmin())
                        <th class="px-4 py-3">From / To</th>
                    @endif
                    <th class="px-4 py-3">Subject</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($messages as $message)
                @php
                    $isAdminInitiated = $message->isAdminInitiated();
                    $unreadForAdmin = !$isAdminInitiated && !$message->is_read && auth()->user()->isAdmin();
                    $unreadAdminReply = $isAdminInitiated && $message->alumni_reply && !$message->admin_read_reply && auth()->user()->isAdmin();
                @endphp
                <tr class="{{ ($unreadForAdmin || $unreadAdminReply) ? 'bg-blue-50' : '' }}">
                    @if(auth()->user()->isAdmin())
                    <td class="px-4 py-3 font-medium">
                        @if($isAdminInitiated)
                            <span class="text-xs text-slate-400 mr-1">To:</span>{{ $message->recipient->name ?? '—' }}
                        @else
                            <span class="text-xs text-slate-400 mr-1">From:</span>{{ $message->sender->name }}
                        @endif
                    </td>
                    @endif
                    <td class="px-4 py-3 font-{{ ($unreadForAdmin || $unreadAdminReply) ? 'semibold' : 'normal' }}">
                        {{ $message->subject }}
                        @if($unreadForAdmin || $unreadAdminReply)
                            <span class="ml-2 rounded-full bg-blue-100 text-blue-700 px-2 py-0.5 text-xs font-medium">New</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        @if($isAdminInitiated)
                            @if($message->alumni_reply)
                                <span class="badge badge-emerald">Replied</span>
                            @elseif($message->is_read)
                                <span class="badge badge-amber">Seen</span>
                            @else
                                <span class="badge badge-indigo">Sent</span>
                            @endif
                        @else
                            @if($message->admin_reply)
                                <span class="badge badge-emerald">Replied</span>
                            @elseif($message->is_read)
                                <span class="badge badge-amber">Seen</span>
                            @else
                                <span class="badge badge-indigo">Pending</span>
                            @endif
                        @endif
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $message->created_at->format('M d, Y g:i A') }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="inline-flex items-center gap-3">
                            <a href="{{ route('messages.show', $message) }}" class="text-indigo-600 hover:text-indigo-500">View</a>
                            <form method="POST" action="{{ route('messages.destroy', $message) }}" class="inline" onsubmit="return confirm('Delete this message?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="border-0 text-rose-600 outline-none hover:text-rose-500 focus:outline-none focus:ring-0">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-500">No messages yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $messages->links() }}</div>
</div>
@endsection

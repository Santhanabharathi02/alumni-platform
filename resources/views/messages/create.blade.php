@extends('layouts.app')
@section('title', 'Send Message')
@section('page-title', 'Send Message')
@section('content')
<div class="max-w-2xl space-y-6">

    <div class="flex items-center gap-3 text-sm text-slate-500">
        <a href="{{ route('messages.index') }}" class="hover:text-indigo-600">Messages</a>
        <span>/</span>
        <span class="text-slate-800 font-medium">New Message</span>
    </div>

    <div class="bg-white rounded-lg shadow-sm p-6">
        @if(auth()->user()->isAdmin())
            <h2 class="text-lg font-semibold text-slate-900 mb-1">Send Message to Alumni</h2>
            <p class="text-sm text-slate-500 mb-6">Send a direct message to a specific alumni. They will be notified and can reply.</p>
        @else
            <h2 class="text-lg font-semibold text-slate-900 mb-1">Contact the Admin</h2>
            <p class="text-sm text-slate-500 mb-6">Send a message to the institution admin. You will be notified when a reply is posted.</p>
        @endif

        @if($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-4 text-sm text-red-700">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('messages.store') }}" class="space-y-5">
            @csrf

            @if(auth()->user()->isAdmin())
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">To (Alumni)</label>
                <select name="to_user_id" required
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">
                    <option value="">Select an alumni...</option>
                    @foreach($alumni as $user)
                        <option value="{{ $user->id }}" {{ old('to_user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Subject</label>
                <input type="text" name="subject" value="{{ old('subject') }}" required
                    placeholder="e.g. Internship Inquiry, Event Question..."
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Message</label>
                <textarea name="body" rows="6" required
                    placeholder="Write your message here..."
                    class="w-full rounded-lg border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm focus:border-indigo-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-100">{{ old('body') }}</textarea>
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="btn btn-primary">Send Message</button>
                <a href="{{ route('messages.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Dashboard – SMTEC Alumni Hub')
@section('page-title', 'Dashboard')

@section('content')

{{-- ── Page Header ─────────────────────────────────────────── --}}
<div class="page-header">
    <div>
        <h2 class="page-header-title">Welcome back, {{ auth()->user()->name }} 👋</h2>
        <p class="page-header-sub">Here's what's happening across the Alumni platform today.</p>
    </div>
    @if(auth()->user()->isAdmin())
        <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <a href="{{ route('alumni.create') }}" class="btn btn-primary">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Alumni
            </a>
            <a href="{{ route('events.create') }}" class="btn btn-secondary">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                New Event
            </a>
            <a href="{{ route('announcements.create') }}" class="btn btn-secondary">
                <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                Announce
            </a>
        </div>
    @endif
</div>

{{-- ── Stat Cards ──────────────────────────────────────────── --}}
<div class="stat-grid">

    <div class="stat-card">
        <div class="stat-card-top">
            <div>
                <p class="stat-label">Total Alumni</p>
                <p class="stat-value">{{ $stats['alumni'] }}</p>
            </div>
            <div class="stat-icon stat-icon-indigo">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
        </div>
        <div class="stat-card-accent" style="background:linear-gradient(90deg,#3F00FF,#4B0082);"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div>
                <p class="stat-label">Upcoming Events</p>
                <p class="stat-value">{{ $stats['events'] }}</p>
            </div>
            <div class="stat-icon stat-icon-sky">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div class="stat-card-accent" style="background:linear-gradient(90deg,#000080,#00FFFF);"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div>
                <p class="stat-label">Mentorships</p>
                <p class="stat-value">{{ $stats['mentorships'] }}</p>
            </div>
            <div class="stat-icon stat-icon-emerald">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
        </div>
        <div class="stat-card-accent" style="background:linear-gradient(90deg,#00FFFF,#E6E6FA);"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div>
                <p class="stat-label">Donations</p>
                <p class="stat-value">{{ $stats['donations'] }}</p>
            </div>
            <div class="stat-icon stat-icon-rose">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
        </div>
        <div class="stat-card-accent" style="background:linear-gradient(90deg,#FF00FF,#4B0082);"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div>
                <p class="stat-label">Total Donated</p>
                <p class="stat-value" style="font-size:1.4rem;">${{ number_format($stats['donation_total'], 0) }}</p>
            </div>
            <div class="stat-icon stat-icon-amber">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="stat-card-accent" style="background:linear-gradient(90deg,#E6E6FA,#3F00FF);"></div>
    </div>

    <div class="stat-card">
        <div class="stat-card-top">
            <div>
                <p class="stat-label">Open Jobs</p>
                <p class="stat-value">{{ $stats['jobs_open'] }}</p>
            </div>
            <div class="stat-icon stat-icon-violet">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <div class="stat-card-accent" style="background:linear-gradient(90deg,#4B0082,#000080);"></div>
    </div>

    @if(auth()->user()->isAdmin())
    <div class="stat-card">
        <div class="stat-card-top">
            <div>
                <p class="stat-label">Unread Messages</p>
                <p class="stat-value" style="{{ $stats['unread_messages'] > 0 ? 'color:#ef4444;' : '' }}">
                    {{ $stats['unread_messages'] }}
                </p>
            </div>
            <div class="stat-icon" style="background:#fef2f2;color:#ef4444;">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
        </div>
        <div class="stat-card-accent" style="background:linear-gradient(90deg,#ef4444,#f97316);"></div>
    </div>
    @else
    <div class="stat-card">
        <div class="stat-card-top">
            <div>
                <p class="stat-label">My Messages</p>
                <p class="stat-value">{{ $stats['my_messages'] }}</p>
            </div>
            <div class="stat-icon" style="background:#eff6ff;color:#3b82f6;">
                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
        </div>
        <div class="stat-card-accent" style="background:linear-gradient(90deg,#3b82f6,#6366f1);"></div>
    </div>
    @endif

</div>

{{-- ── Alumni Profile Snapshot (alumni user only) ──────────── --}}
@if(auth()->user()->isAlumni() && $myAlumni)
<div class="card" style="margin-bottom:24px;padding:22px 24px;">
    <div style="display:flex;align-items:center;gap:14px;margin-bottom:18px;">
        <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,#00FFFF,#3F00FF,#FF00FF);display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.2rem;font-weight:700;flex-shrink:0;">
            {{ strtoupper(substr($myAlumni->first_name, 0, 1)) }}
        </div>
        <div>
            <div style="font-weight:700;font-size:1rem;color:#1e293b;">{{ $myAlumni->full_name }}</div>
            <div style="font-size:0.82rem;color:#64748b;">{{ $myAlumni->job_title }} @if($myAlumni->company)· {{ $myAlumni->company }}@endif</div>
        </div>
        <a href="{{ route('alumni.edit', ['alumnus' => $myAlumni->id]) }}" class="btn btn-secondary btn-sm" style="margin-left:auto;">Edit Profile</a>
    </div>
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:12px;">
        <div style="background:#f8fafc;border-radius:8px;padding:12px 14px;">
            <div style="font-size:0.72rem;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Mentor</div>
            <div style="font-size:1rem;font-weight:700;color:#1e293b;margin-top:4px;">{{ $myAlumni->is_mentor ? '✓ Yes' : 'No' }}</div>
        </div>
        <div style="background:#f8fafc;border-radius:8px;padding:12px 14px;">
            <div style="font-size:0.72rem;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Internships</div>
            <div style="font-size:1rem;font-weight:700;color:#1e293b;margin-top:4px;">{{ $myAlumni->available_for_internships ? '✓ Available' : 'No' }}</div>
        </div>
        <div style="background:#f8fafc;border-radius:8px;padding:12px 14px;">
            <div style="font-size:0.72rem;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Mentorships</div>
            <div style="font-size:1rem;font-weight:700;color:#1e293b;margin-top:4px;">{{ $myAlumni->mentorships->count() }}</div>
        </div>
        <div style="background:#f8fafc;border-radius:8px;padding:12px 14px;">
            <div style="font-size:0.72rem;color:#64748b;font-weight:600;text-transform:uppercase;letter-spacing:.05em;">Donations</div>
            <div style="font-size:1rem;font-weight:700;color:#1e293b;margin-top:4px;">{{ $myAlumni->donations->count() }}</div>
        </div>
    </div>
</div>
@endif

{{-- ── 3-column lower panels ───────────────────────────────── --}}
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:20px;">

    {{-- Recently Added Alumni --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">
                <svg style="display:inline;vertical-align:-3px;margin-right:5px;" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Recent Alumni
            </span>
            <a href="{{ route('alumni.index') }}" class="btn btn-secondary btn-sm">View all</a>
        </div>
        <div class="card-body" style="padding:0;">
            @forelse ($recentAlumni as $alumnus)
                <div style="display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:1px solid #f1f5f9;">
                    <div style="width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#3F00FF,#4B0082);display:flex;align-items:center;justify-content:center;color:#fff;font-size:0.8rem;font-weight:700;flex-shrink:0;">
                        {{ strtoupper(substr($alumnus->first_name,0,1)) }}
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-weight:600;font-size:0.875rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $alumnus->full_name }}</p>
                        <p style="font-size:0.75rem;color:#64748b;">{{ $alumnus->email }}</p>
                    </div>
                    <a href="{{ route('alumni.show', ['alumnus' => $alumnus->id]) }}" style="font-size:0.75rem;color:#4f46e5;font-weight:600;flex-shrink:0;">View</a>
                </div>
            @empty
                <p style="padding:20px;font-size:0.875rem;color:#64748b;text-align:center;">No alumni records yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Latest Announcements --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">
                <svg style="display:inline;vertical-align:-3px;margin-right:5px;" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                Announcements
            </span>
            <a href="{{ route('announcements.index') }}" class="btn btn-secondary btn-sm">View all</a>
        </div>
        <div class="card-body" style="padding:0;">
            @forelse ($latestAnnouncements as $announcement)
                <div style="padding:13px 18px;border-bottom:1px solid #f1f5f9;">
                    <p style="font-weight:600;font-size:0.875rem;">{{ $announcement->title }}</p>
                    <div style="display:flex;align-items:center;gap:8px;margin-top:4px;">
                        <span class="badge badge-indigo">{{ ucfirst($announcement->category) }}</span>
                        <span style="font-size:0.72rem;color:#94a3b8;">{{ $announcement->created_at->format('M d, Y') }}</span>
                    </div>
                </div>
            @empty
                <p style="padding:20px;font-size:0.875rem;color:#64748b;text-align:center;">No announcements yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Upcoming Events --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title">
                <svg style="display:inline;vertical-align:-3px;margin-right:5px;" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Upcoming Events
            </span>
            <a href="{{ route('events.index') }}" class="btn btn-secondary btn-sm">View all</a>
        </div>
        <div class="card-body" style="padding:0;">
            @forelse ($upcomingEvents as $event)
                <div style="display:flex;align-items:center;gap:12px;padding:12px 18px;border-bottom:1px solid #f1f5f9;">
                    <div style="width:38px;height:38px;border-radius:8px;background:#e0f2fe;display:flex;flex-direction:column;align-items:center;justify-content:center;flex-shrink:0;">
                        <span style="font-size:0.6rem;color:#000080;font-weight:700;text-transform:uppercase;">{{ $event->starts_at->format('M') }}</span>
                        <span style="font-size:1rem;color:#3F00FF;font-weight:800;line-height:1;">{{ $event->starts_at->format('d') }}</span>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <p style="font-weight:600;font-size:0.875rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $event->title }}</p>
                        <p style="font-size:0.75rem;color:#64748b;">{{ $event->starts_at->format('g:i A') }}</p>
                    </div>
                    <a href="{{ route('events.show', $event) }}" style="font-size:0.75rem;color:#4f46e5;font-weight:600;flex-shrink:0;">Details</a>
                </div>
            @empty
                <p style="padding:20px;font-size:0.875rem;color:#64748b;text-align:center;">No upcoming events.</p>
            @endforelse
        </div>
    </div>

</div>

{{-- ── Communication Quick-Access (below main panels) ──────── --}}
<div style="margin-top:20px;" class="card">
    <div class="card-header">
        <span class="card-title">
            <svg style="display:inline;vertical-align:-3px;margin-right:5px;" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            Communication &amp; Networking
        </span>
        <a href="{{ route('messages.index') }}" class="btn btn-secondary btn-sm">
            @if(auth()->user()->isAdmin()) View Inbox @else My Messages @endif
        </a>
    </div>
    <div class="card-body" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;">

        {{-- Messages tile --}}
        <a href="{{ route('messages.index') }}" style="display:flex;flex-direction:column;gap:8px;padding:18px;border-radius:10px;background:#f8fafc;border:1.5px solid #e2e8f0;text-decoration:none;transition:border-color .2s,background .2s;" onmouseover="this.style.borderColor='#6366f1';this.style.background='#f0f0ff'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
            <div style="width:38px;height:38px;border-radius:8px;background:linear-gradient(135deg,#4f46e5,#7c3aed);display:flex;align-items:center;justify-content:center;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
            </div>
            <div>
                <div style="font-weight:700;font-size:0.875rem;color:#1e293b;">
                    @if(auth()->user()->isAdmin())
                        Message Inbox
                        @if($stats['unread_messages'] > 0)
                            <span style="margin-left:6px;padding:2px 8px;border-radius:20px;background:#ef4444;color:#fff;font-size:0.7rem;font-weight:700;">{{ $stats['unread_messages'] }} new</span>
                        @endif
                    @else
                        Contact Admin
                    @endif
                </div>
                <div style="font-size:0.78rem;color:#64748b;margin-top:2px;">
                    @if(auth()->user()->isAdmin())
                        Read and reply to alumni messages
                    @else
                        Send a message to the institution
                    @endif
                </div>
            </div>
        </a>

        {{-- Compose / New Message tile (alumni only) --}}
        @if(auth()->user()->isAlumni())
        <a href="{{ route('messages.create') }}" style="display:flex;flex-direction:column;gap:8px;padding:18px;border-radius:10px;background:#f8fafc;border:1.5px solid #e2e8f0;text-decoration:none;transition:border-color .2s,background .2s;" onmouseover="this.style.borderColor='#10b981';this.style.background='#f0fdf4'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
            <div style="width:38px;height:38px;border-radius:8px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
            </div>
            <div>
                <div style="font-weight:700;font-size:0.875rem;color:#1e293b;">New Message</div>
                <div style="font-size:0.78rem;color:#64748b;margin-top:2px;">Write a new message to admin</div>
            </div>
        </a>

        {{-- Replies received (alumni only) --}}
        <div style="display:flex;flex-direction:column;gap:8px;padding:18px;border-radius:10px;background:#f8fafc;border:1.5px solid #e2e8f0;">
            <div style="width:38px;height:38px;border-radius:8px;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
            </div>
            <div>
                <div style="font-weight:700;font-size:0.875rem;color:#1e293b;">Replies Received</div>
                <div style="font-size:1.4rem;font-weight:800;color:#d97706;">{{ $stats['my_replies'] }}</div>
            </div>
        </div>
        @endif

        {{-- Announcements tile --}}
        <a href="{{ route('announcements.index') }}" style="display:flex;flex-direction:column;gap:8px;padding:18px;border-radius:10px;background:#f8fafc;border:1.5px solid #e2e8f0;text-decoration:none;transition:border-color .2s,background .2s;" onmouseover="this.style.borderColor='#0ea5e9';this.style.background='#f0f9ff'" onmouseout="this.style.borderColor='#e2e8f0';this.style.background='#f8fafc'">
            <div style="width:38px;height:38px;border-radius:8px;background:linear-gradient(135deg,#0ea5e9,#0284c7);display:flex;align-items:center;justify-content:center;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="#fff" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
            </div>
            <div>
                <div style="font-weight:700;font-size:0.875rem;color:#1e293b;">Announcements</div>
                <div style="font-size:0.78rem;color:#64748b;margin-top:2px;">View &amp; comment on announcements</div>
            </div>
        </a>

    </div>
</div>

@endsection

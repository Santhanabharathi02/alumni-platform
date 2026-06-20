<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SMTEC Alumni Hub')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app-fallback.css') }}">
</head>
<body class="admin-body">

    {{-- ========== SIDEBAR ========== --}}
    <aside class="admin-sidebar" id="adminSidebar">
        {{-- Brand --}}
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
                <img src="{{ asset('images/smtec-logo.png') }}" alt="SMTEC Logo"
                     style="width:54px;height:54px;object-fit:contain;border-radius:50%;background:#fff;padding:2px;flex-shrink:0;">
                <div>
                    <div class="sidebar-brand-name">Alumni Hub</div>
                    <div class="sidebar-brand-sub" style="color:#87CEEB;font-weight:700;">SMTEC</div>
                </div>
            </a>
        </div>

        {{-- Navigation --}}
        <nav class="sidebar-nav">
            <span class="sidebar-section-label">Main Menu</span>

            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'is-active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </span>
                Dashboard
            </a>

            <a href="{{ route('alumni.index') }}" class="sidebar-link {{ request()->routeIs('alumni.*') ? 'is-active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </span>
                Alumni Directory
            </a>

            <a href="{{ route('events.index') }}" class="sidebar-link {{ request()->routeIs('events.*') ? 'is-active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </span>
                Events
            </a>

            <a href="{{ route('mentorships.index') }}" class="sidebar-link {{ request()->routeIs('mentorships.*') ? 'is-active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </span>
                Mentorships
            </a>

            <a href="{{ route('donations.index') }}" class="sidebar-link {{ request()->routeIs('donations.*') ? 'is-active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </span>
                Donations
            </a>

            <a href="{{ route('jobs.index') }}" class="sidebar-link {{ request()->routeIs('jobs.*') ? 'is-active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </span>
                Job Board
            </a>

            <a href="{{ route('announcements.index') }}" class="sidebar-link {{ request()->routeIs('announcements.*') ? 'is-active' : '' }}">
                <span class="sidebar-link-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </span>
                Announcements
            </a>

            @php
                $sidebarUnread = auth()->user()->isAdmin()
                    ? \App\Models\Message::where('is_read', false)->count()
                    : \App\Models\Message::where('from_user_id', auth()->id())->whereNotNull('admin_reply')->where('reply_read', false)->count();
            @endphp
            <a href="{{ route('messages.index') }}" class="sidebar-link {{ request()->routeIs('messages.*') ? 'is-active' : '' }}" style="position:relative;">
                <span class="sidebar-link-icon">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                </span>
                Messages
                @if($sidebarUnread > 0)
                    <span style="margin-left:auto;min-width:20px;height:20px;border-radius:10px;background:#ef4444;color:#fff;font-size:0.68rem;font-weight:700;display:flex;align-items:center;justify-content:center;padding:0 5px;">
                        {{ $sidebarUnread > 99 ? '99+' : $sidebarUnread }}
                    </span>
                @endif
            </a>
        </nav>

        {{-- Sidebar Footer / User --}}
        <div class="sidebar-footer">
            <div class="sidebar-user">
                <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="sidebar-user-meta">
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">
                        @if(auth()->user()->isAlumni() && auth()->user()->alumni)
                            <a href="{{ route('alumni.show', ['alumnus' => auth()->user()->alumni->id]) }}" class="sidebar-profile-link">View Profile</a>
                        @else
                            {{ ucfirst(auth()->user()->role) }}
                        @endif
                    </div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="sidebar-logout">
                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Sign Out
                </button>
            </form>
        </div>
    </aside>

    {{-- ========== MAIN AREA ========== --}}
    <div class="admin-main">

        {{-- Topbar --}}
        <header class="admin-topbar">
            <div class="topbar-title-wrap">
                <h1 class="topbar-title">{{ trim($__env->yieldContent('page-title', $__env->yieldContent('title', 'Dashboard'))) }}</h1>
                @hasSection('breadcrumb')
                    <div class="topbar-breadcrumb">@yield('breadcrumb')</div>
                @endif
            </div>
            <div class="topbar-right">
                @php
                    $unreadNotifs = auth()->user()->unreadNotifications->count();
                @endphp

                {{-- Notification Bell --}}
                <div style="position:relative;display:inline-block;" id="notifWrapper">
                    <button onclick="toggleNotifDropdown()" type="button"
                        style="position:relative;background:none;border:none;cursor:pointer;padding:6px 8px;border-radius:8px;display:flex;align-items:center;color:#64748b;transition:background 0.15s;"
                        onmouseenter="this.style.background='#f1f5f9'" onmouseleave="this.style.background='none'">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        @if($unreadNotifs > 0)
                            <span style="position:absolute;top:2px;right:2px;min-width:17px;height:17px;border-radius:99px;background:#ef4444;color:#fff;font-size:0.6rem;font-weight:800;display:flex;align-items:center;justify-content:center;padding:0 3px;border:2px solid #fff;">
                                {{ $unreadNotifs > 9 ? '9+' : $unreadNotifs }}
                            </span>
                        @endif
                    </button>

                    {{-- Dropdown Panel --}}
                    <div id="notifDropdown"
                        style="display:none;position:absolute;right:0;top:calc(100% + 8px);width:320px;background:#fff;border:1px solid #e2e8f0;border-radius:12px;box-shadow:0 10px 36px rgba(15,23,42,0.14);z-index:999;overflow:hidden;">
                        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 16px;border-bottom:1px solid #f1f5f9;">
                            <span style="font-size:0.85rem;font-weight:700;color:#0f172a;">Notifications</span>
                            @if($unreadNotifs > 0)
                                <a href="{{ route('notifications.readAll') }}"
                                    style="font-size:0.75rem;color:#2563eb;font-weight:600;text-decoration:none;">Mark all read</a>
                            @endif
                        </div>
                        <div style="max-height:320px;overflow-y:auto;">
                            @forelse(auth()->user()->notifications->take(15) as $notif)
                                @php
                                    $isUnread = is_null($notif->read_at);
                                    $ndata    = $notif->data;
                                    $ntype    = $ndata['type'] ?? '';
                                @endphp
                                <a href="{{ route('notifications.read', $notif->id) }}"
                                    style="display:flex;align-items:flex-start;gap:10px;padding:12px 16px;text-decoration:none;border-bottom:1px solid #f8fafc;background:{{ $isUnread ? '#eff6ff' : '#fff' }};transition:background 0.15s;"
                                    onmouseenter="this.style.background='#f8fafc'" onmouseleave="this.style.background='{{ $isUnread ? '#eff6ff' : '#fff' }}'">
                                    <span style="flex-shrink:0;width:34px;height:34px;border-radius:50%;display:flex;align-items:center;justify-content:center;background:{{ $ntype === 'admin_reply' ? '#dbeafe' : ($ntype === 'message_seen' ? '#fef9c3' : '#dcfce7') }};">
                                        @if($ntype === 'admin_reply')
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#2563eb" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/></svg>
                                        @elseif($ntype === 'message_seen')
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#ca8a04" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        @else
                                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="#16a34a" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
                                        @endif
                                    </span>
                                    <div style="flex:1;min-width:0;">
                                        <p style="font-size:0.8rem;font-weight:{{ $isUnread ? '700' : '500' }};color:#0f172a;margin:0;line-height:1.4;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                            @if($ntype === 'admin_reply')
                                                Admin replied to your message
                                            @elseif($ntype === 'message_seen')
                                                Admin has seen your message
                                            @else
                                                New message from {{ $ndata['from_name'] ?? 'Alumni' }}
                                            @endif
                                        </p>
                                        <p style="font-size:0.73rem;color:#64748b;margin:2px 0 0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                                            {{ $ndata['subject'] ?? '' }}
                                        </p>
                                        <p style="font-size:0.68rem;color:#94a3b8;margin:2px 0 0;">
                                            {{ $notif->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    @if($isUnread)
                                        <span style="flex-shrink:0;width:8px;height:8px;border-radius:50%;background:#3b82f6;margin-top:6px;"></span>
                                    @endif
                                </a>
                            @empty
                                <div style="padding:32px 16px;text-align:center;color:#94a3b8;font-size:0.83rem;">
                                    No notifications yet.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <span class="role-badge {{ auth()->user()->isAdmin() ? 'role-admin' : 'role-alumni' }}">
                    @if(auth()->user()->isAdmin())
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        Administrator
                    @else
                        <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                        Alumni
                    @endif
                </span>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="admin-content">
            @if (session('status'))
                <div class="flash-alert flash-success">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('status') }}
                </div>
            @endif
            @if (session('error'))
                <div class="flash-alert flash-error">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        function toggleNotifDropdown() {
            var d = document.getElementById('notifDropdown');
            d.style.display = d.style.display === 'none' ? 'block' : 'none';
        }
        document.addEventListener('click', function(e) {
            var wrapper = document.getElementById('notifWrapper');
            if (wrapper && !wrapper.contains(e.target)) {
                var d = document.getElementById('notifDropdown');
                if (d) d.style.display = 'none';
            }
        });
    </script>

</body>
</html>

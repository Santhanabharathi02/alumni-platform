<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign In – SMTEC Alumni Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
            overflow: hidden;
        }

        /* ── Left panel ── */
        .login-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 60%, #1a2e4a 100%);
            padding: 48px 40px;
            position: relative;
            overflow: hidden;
        }
        .login-left::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(135,206,235,0.12) 0%, transparent 70%);
            top: -100px; left: -100px;
        }
        .login-left::after {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(100,160,220,0.1) 0%, transparent 70%);
            bottom: -80px; right: -80px;
        }
        .college-logo {
            width: 140px; height: 140px;
            object-fit: contain;
            border-radius: 50%;
            border: 4px solid rgba(135,206,235,0.4);
            box-shadow: 0 0 40px rgba(135,206,235,0.25), 0 0 80px rgba(135,206,235,0.1);
            background: #fff;
            padding: 6px;
            margin-bottom: 28px;
            position: relative; z-index: 1;
        }
        .college-name {
            color: #87CEEB;
            font-size: 1.6rem;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            position: relative; z-index: 1;
        }
        .college-full {
            color: rgba(255,255,255,0.7);
            font-size: 0.82rem;
            font-weight: 500;
            text-align: center;
            margin-top: 8px;
            letter-spacing: 0.5px;
            line-height: 1.6;
            max-width: 260px;
            position: relative; z-index: 1;
        }
        .divider-line {
            width: 60px; height: 3px;
            background: linear-gradient(90deg, transparent, #87CEEB, transparent);
            border-radius: 2px;
            margin: 20px auto;
            position: relative; z-index: 1;
        }
        .tagline {
            color: rgba(255,255,255,0.45);
            font-size: 0.75rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: relative; z-index: 1;
        }

        /* ── Right panel ── */
        .login-right {
            width: 440px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 44px;
            background: #ffffff;
            box-shadow: -10px 0 60px rgba(0,0,0,0.35);
        }
        .form-header { margin-bottom: 36px; }
        .form-header h2 {
            font-size: 1.65rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }
        .form-header p { color: #64748b; font-size: 0.875rem; }

        .form-group { margin-bottom: 20px; }
        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 7px;
            letter-spacing: 0.3px;
        }
        .form-control {
            width: 100%;
            padding: 11px 14px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.9rem;
            color: #0f172a;
            background: #f8fafc;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            font-family: 'Inter', sans-serif;
        }
        .form-control:focus {
            border-color: #87CEEB;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(135,206,235,0.2);
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 24px;
        }
        .remember-row input[type="checkbox"] {
            width: 16px; height: 16px;
            accent-color: #1e3a5f;
            cursor: pointer;
        }
        .remember-row label { font-size: 0.85rem; color: #475569; cursor: pointer; }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #1e3a5f, #2563eb);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 0.95rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            transition: transform 0.15s, box-shadow 0.2s;
            font-family: 'Inter', sans-serif;
        }
        .btn-login:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(30,58,95,0.35);
        }
        .btn-login:active { transform: translateY(0); }

        .error-box {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: 10px;
            padding: 12px 14px;
            color: #b91c1c;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ── Role Selector ── */
        .role-selector {
            display: flex;
            gap: 10px;
            margin-bottom: 22px;
        }
        .role-btn {
            flex: 1;
            padding: 10px 8px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
            background: #f8fafc;
            color: #64748b;
            font-size: 0.82rem;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
            font-family: 'Inter', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }
        .role-btn:hover {
            border-color: #87CEEB;
            background: #f0f9ff;
            color: #1e3a5f;
        }
        .role-btn.active {
            border-color: #1e3a5f;
            background: #e8f0fb;
            color: #1e3a5f;
        }
        .role-btn svg { flex-shrink: 0; }

        .register-link {
            text-align: center;
            margin-top: 28px;
            font-size: 0.875rem;
            color: #64748b;
        }
        .register-link a {
            color: #1e3a5f;
            font-weight: 700;
            text-decoration: none;
        }
        .register-link a:hover { text-decoration: underline; }

        .footer-note {
            margin-top: auto;
            padding-top: 32px;
            text-align: center;
            font-size: 0.72rem;
            color: #94a3b8;
        }

        @media (max-width: 768px) {
            body { flex-direction: column; overflow: auto; }
            .login-left { padding: 36px 24px 28px; }
            .college-logo { width: 100px; height: 100px; }
            .login-right { width: 100%; min-height: auto; padding: 36px 28px; }
        }
    </style>
</head>
<body>

    {{-- ── Left branding panel ── --}}
    <div class="login-left">
        <img src="{{ asset('images/smtec-logo.png') }}" alt="SMTEC Logo" class="college-logo">
        <div class="college-name">SMTEC</div>
        <div class="college-full">St. Mother Theresa Engineering College<br>Vagaikulam, Thoothukudi</div>
        <div class="divider-line"></div>
        <div class="tagline">Alumni Connect Portal</div>
    </div>

    {{-- ── Right form panel ── --}}
    <div class="login-right">
        <div class="form-header">
            <h2>Welcome back</h2>
            <p>Sign in to your Alumni Hub account</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" autocomplete="off">
            @csrf

            {{-- Honeypot: browsers autofill these invisible fields, leaving the real ones empty --}}
            <div style="position:absolute;left:-9999px;top:-9999px;width:0;height:0;overflow:hidden;" aria-hidden="true">
                <input type="text"     name="_h_email"    tabindex="-1" autocomplete="username">
                <input type="password" name="_h_password" tabindex="-1" autocomplete="current-password">
            </div>

            {{-- Role Selector --}}
            <div class="form-group">
                <label class="form-label">Sign in as</label>
                <div class="role-selector">
                    <button type="button" class="role-btn {{ old('role', 'alumni') === 'admin' ? 'active' : '' }}" onclick="selectRole('admin', this)">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Administrator
                    </button>
                    <button type="button" class="role-btn {{ old('role', 'alumni') === 'alumni' ? 'active' : '' }}" onclick="selectRole('alumni', this)">
                        <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Alumni
                    </button>
                </div>
                <input type="hidden" name="role" id="roleInput" value="{{ old('role', 'alumni') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" id="emailInput"
                       value="{{ old('email') }}" required autofocus
                       class="form-control" placeholder="you@example.com"
                       autocomplete="off" spellcheck="false">
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" id="passwordInput" required
                       class="form-control" placeholder="••••••••"
                       autocomplete="new-password">
            </div>

            <div class="remember-row">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Remember me for 30 days</label>
            </div>

            <button type="submit" class="btn-login">Sign In</button>
        </form>

        <div class="register-link">
            New alumni? <a href="{{ route('register') }}">Create an account</a>
        </div>

        <script>
            function selectRole(role, btn) {
                document.querySelectorAll('.role-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                document.getElementById('roleInput').value = role;
                // NOTE: do NOT clear email/password here – user may have already typed credentials.
                // The off-screen honeypot inputs handle browser autofill instead.
            }

            document.addEventListener('DOMContentLoaded', function() {
                // Ensure the correct role button is highlighted
                var role = document.getElementById('roleInput').value;
                document.querySelectorAll('.role-btn').forEach(function(btn) {
                    if ((role === 'admin' && btn.textContent.trim().includes('Administrator')) ||
                        (role === 'alumni' && btn.textContent.trim().includes('Alumni'))) {
                        btn.classList.add('active');
                    }
                });
            });
        </script>

        <div class="footer-note">
            &copy; {{ date('Y') }} SMTEC Alumni Hub &mdash; All rights reserved
        </div>
    </div>

</body>
</html>

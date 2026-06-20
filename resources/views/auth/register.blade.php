<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alumni Registration – SMTEC Alumni Hub</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: #0f172a;
        }

        /* ── Left branding panel ── */
        .reg-left {
            width: 320px;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 60%, #1a2e4a 100%);
            padding: 48px 36px;
            position: relative;
            overflow: hidden;
        }
        .reg-left::before {
            content: '';
            position: absolute;
            width: 400px; height: 400px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(135,206,235,0.12) 0%, transparent 70%);
            top: -80px; left: -80px;
        }
        .reg-left::after {
            content: '';
            position: absolute;
            width: 300px; height: 300px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(100,160,220,0.1) 0%, transparent 70%);
            bottom: -60px; right: -60px;
        }
        .college-logo {
            width: 110px; height: 110px;
            object-fit: contain;
            border-radius: 50%;
            border: 4px solid rgba(135,206,235,0.4);
            box-shadow: 0 0 40px rgba(135,206,235,0.25), 0 0 80px rgba(135,206,235,0.1);
            background: #fff;
            padding: 5px;
            margin-bottom: 24px;
            position: relative; z-index: 1;
        }
        .college-name {
            color: #87CEEB;
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            position: relative; z-index: 1;
        }
        .college-full {
            color: rgba(255,255,255,0.65);
            font-size: 0.78rem;
            font-weight: 500;
            text-align: center;
            margin-top: 8px;
            letter-spacing: 0.5px;
            line-height: 1.6;
            max-width: 220px;
            position: relative; z-index: 1;
        }
        .divider-line {
            width: 50px; height: 3px;
            background: linear-gradient(90deg, transparent, #87CEEB, transparent);
            border-radius: 2px;
            margin: 18px auto;
            position: relative; z-index: 1;
        }
        .tagline {
            color: rgba(255,255,255,0.4);
            font-size: 0.7rem;
            letter-spacing: 1px;
            text-transform: uppercase;
            position: relative; z-index: 1;
        }

        /* ── Right form panel ── */
        .reg-right {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 52px;
            background: #ffffff;
            box-shadow: -10px 0 60px rgba(0,0,0,0.35);
        }

        .form-header { margin-bottom: 30px; }
        .form-header h2 {
            font-size: 1.55rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 5px;
        }
        .form-header p { color: #64748b; font-size: 0.875rem; }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 0;
        }
        .form-row.full { grid-column: 1 / -1; }
        .form-group { margin-bottom: 16px; }
        .form-group.span-2 { grid-column: 1 / -1; }

        .form-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
            letter-spacing: 0.3px;
        }
        .form-label .req { color: #ef4444; margin-left: 2px; }

        .form-control {
            width: 100%;
            padding: 10px 13px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.875rem;
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
        .form-hint {
            margin-top: 4px;
            font-size: 0.72rem;
            color: #94a3b8;
        }

        .error-box {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: 10px;
            padding: 12px 14px;
            color: #b91c1c;
            font-size: 0.83rem;
            margin-bottom: 20px;
        }
        .error-box ul { padding-left: 16px; }
        .error-box li { margin-bottom: 3px; }

        .btn-register {
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
            margin-top: 8px;
        }
        .btn-register:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(30,58,95,0.35);
        }
        .btn-register:active { transform: translateY(0); }

        .login-link {
            text-align: center;
            margin-top: 22px;
            font-size: 0.875rem;
            color: #64748b;
        }
        .login-link a {
            color: #1e3a5f;
            font-weight: 700;
            text-decoration: none;
        }
        .login-link a:hover { text-decoration: underline; }

        .section-label {
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: #94a3b8;
            margin-bottom: 12px;
            margin-top: 4px;
            padding-bottom: 6px;
            border-bottom: 1px solid #f1f5f9;
        }

        @media (max-width: 780px) {
            body { flex-direction: column; }
            .reg-left {
                width: 100%;
                padding: 32px 24px 24px;
                flex-direction: row;
                justify-content: flex-start;
                gap: 18px;
            }
            .reg-left::before, .reg-left::after { display: none; }
            .college-logo { width: 64px; height: 64px; margin-bottom: 0; }
            .college-full, .divider-line, .tagline { display: none; }
            .college-name { font-size: 1.1rem; }
            .reg-right { padding: 32px 24px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    {{-- ── Left branding panel ── --}}
    <div class="reg-left">
        <img src="{{ asset('images/smtec-logo.png') }}" alt="SMTEC Logo" class="college-logo">
        <div class="college-name">SMTEC</div>
        <div class="college-full">St. Mother Theresa Engineering College<br>Vagaikulam, Thoothukudi</div>
        <div class="divider-line"></div>
        <div class="tagline">Alumni Connect Portal</div>
    </div>

    {{-- ── Right form panel ── --}}
    <div class="reg-right">
        <div class="form-header">
            <h2>Create Alumni Account</h2>
            <p>Join the SMTEC Alumni Hub — fill in your details below.</p>
        </div>

        @if ($errors->any())
            <div class="error-box">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" autocomplete="off">
            @csrf

            {{-- Account credentials --}}
            <div class="section-label">Account Credentials</div>

            <div class="form-group">
                <label class="form-label">Full Name <span class="req">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required autocomplete="off"
                       class="form-control" placeholder="e.g. Priya Rajan">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Email Address <span class="req">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="off"
                           class="form-control" placeholder="you@example.com">
                </div>
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone') }}"
                           class="form-control" placeholder="+91 98765 43210">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Password <span class="req">*</span></label>
                    <input type="password" name="password" required autocomplete="new-password"
                           class="form-control" placeholder="••••••••">
                    <div class="form-hint">Min 8 chars · uppercase · lowercase · number</div>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password <span class="req">*</span></label>
                    <input type="password" name="password_confirmation" required autocomplete="new-password"
                           class="form-control" placeholder="••••••••">
                </div>
            </div>

            {{-- Academic profile --}}
            <div class="section-label" style="margin-top:8px;">Academic Profile</div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Graduation Year</label>
                    <input type="number" name="graduation_year" value="{{ old('graduation_year') }}"
                           min="1950" max="{{ date('Y') }}"
                           class="form-control" placeholder="{{ date('Y') - 4 }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Department</label>
                    <input type="text" name="department" value="{{ old('department') }}"
                           class="form-control" placeholder="e.g. Computer Science">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Degree</label>
                <input type="text" name="degree" value="{{ old('degree') }}"
                       class="form-control" placeholder="e.g. B.E Computer Science & Engineering">
            </div>

            <button type="submit" class="btn-register">Create My Alumni Account</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="{{ route('login') }}">Sign in</a>
        </div>
    </div>

</body>
</html>

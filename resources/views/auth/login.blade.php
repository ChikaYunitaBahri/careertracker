<x-guest-layout>
    {{-- Left panel content --}}
    @section('panel-headline')
        <p class="auth-panel-headline">Kelola karir<br>lebih terstruktur</p>
        <p class="auth-panel-sub">Lacak lamaran, wawancara, dan<br>progress karir Anda dalam satu tempat.</p>
    @endsection

    @section('panel-features')
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><rect x="1" y="3" width="12" height="9" rx="1.5"/><path d="M5 3V2a2 2 0 014 0v1"/><path d="M1 7h12"/></svg>
            </div>
            <span class="auth-feature-text">Kelola semua lamaran dalam satu dashboard</span>
        </div>
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><rect x="1" y="1" width="12" height="12" rx="2"/><path d="M4 1v2M10 1v2M1 5h12"/><circle cx="7" cy="8.5" r="1"/></svg>
            </div>
            <span class="auth-feature-text">Jadwal wawancara & pengingat otomatis</span>
        </div>
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><path d="M1 11L5 7l3 3 5-6"/><circle cx="11" cy="3.5" r="1.5"/></svg>
            </div>
            <span class="auth-feature-text">Analitik & progress goal karir</span>
        </div>
    @endsection

    {{-- Form --}}
    <style>
        .form-eyebrow {
            font-size: 10px;
            font-weight: 600;
            color: #6366f1;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .form-heading {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }
        .form-sub-text {
            font-size: 13px;
            color: #94a3b8;
            margin-top: 5px;
        }
        .form-divider {
            height: 1px;
            background: #f1f5f9;
            margin: 22px 0;
        }
        .field-group { margin-bottom: 14px; }
        .field-group label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #475569;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            margin-bottom: 6px;
        }
        .field-group input[type="text"],
        .field-group input[type="email"],
        .field-group input[type="password"] {
            width: 100%;
            height: 40px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            padding: 0 12px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            color: #0f172a;
            background: #f8fafc;
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field-group input:focus {
            border-color: #6366f1;
            background: #fff;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }
        .field-error { font-size: 11px; color: #ef4444; margin-top: 4px; }
        .row-inline {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 8px;
        }
        .check-label {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: #64748b;
            cursor: pointer;
        }
        .check-label input[type="checkbox"] {
            width: 14px;
            height: 14px;
            accent-color: #6366f1;
            border-radius: 4px;
            border-color: #cbd5e1;
        }
        .link-muted {
            font-size: 12px;
            color: #6366f1;
            text-decoration: none;
            font-weight: 500;
        }
        .link-muted:hover { text-decoration: underline; }
        .btn-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: 100%;
            height: 42px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            margin-top: 20px;
            letter-spacing: 0.1px;
            transition: opacity 0.15s, transform 0.1s, box-shadow 0.15s;
            box-shadow: 0 4px 14px rgba(99,102,241,0.35);
        }
        .btn-submit:hover {
            opacity: 0.92;
            box-shadow: 0 6px 20px rgba(99,102,241,0.45);
        }
        .btn-submit:active { transform: scale(0.99); }
        .btn-submit svg {
            width: 16px; height: 16px;
            stroke: white;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
        .alt-action {
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            margin-top: 16px;
        }
        .alt-action a {
            color: #6366f1;
            font-weight: 600;
            text-decoration: none;
        }
        .alt-action a:hover { text-decoration: underline; }
        .session-status {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #15803d;
            border-radius: 8px;
            padding: 10px 12px;
            font-size: 13px;
            margin-bottom: 16px;
        }
        .error-msg {
            display: flex;
            align-items: center;
            gap: 5px;
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="session-status">{{ session('status') }}</div>
    @endif

    <div class="form-eyebrow">Selamat datang kembali</div>
    <div class="form-heading">Masuk ke akun Anda</div>
    <div class="form-sub-text">Lanjutkan mengelola karir Anda</div>

    <div class="form-divider"></div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="field-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="nama@email.com"
                   required autofocus autocomplete="username" />
            @if ($errors->has('email'))
                <div class="error-msg">{{ $errors->first('email') }}</div>
            @endif
        </div>

        {{-- Password --}}
        <div class="field-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password"
                   placeholder="••••••••"
                   required autocomplete="current-password" />
            @if ($errors->has('password'))
                <div class="error-msg">{{ $errors->first('password') }}</div>
            @endif
        </div>

        {{-- Remember + Forgot --}}
        <div class="row-inline">
            <label class="check-label">
                <input type="checkbox" name="remember" id="remember_me">
                Ingat saya
            </label>
            @if (Route::has('password.request'))
                <a class="link-muted" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="btn-submit">
            <svg viewBox="0 0 16 16"><path d="M6 3H3a1 1 0 00-1 1v8a1 1 0 001 1h3"/><path d="M10 11l4-4-4-4M14 8H6"/></svg>
            Masuk ke Dashboard
        </button>

        <div class="alt-action">
            Belum punya akun? <a href="{{ route('register') }}">Daftar gratis</a>
        </div>
    </form>
</x-guest-layout>
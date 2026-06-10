<x-guest-layout>
    {{-- Left panel content --}}
    @section('panel-headline')
        <p class="auth-panel-headline">Mulai perjalanan<br>karir Anda hari ini</p>
        <p class="auth-panel-sub">Buat akun gratis dan kelola semua<br>proses lamaran kerja Anda.</p>
    @endsection

    @section('panel-features')
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><path d="M7 1l1.5 3.5h3.5l-2.8 2 1 3.5L7 8.5 3.8 10l1-3.5L2 4.5h3.5z"/></svg>
            </div>
            <span class="auth-feature-text">Gratis selamanya untuk fitur dasar</span>
        </div>
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><rect x="1" y="5" width="12" height="8" rx="1.5"/><path d="M4 5V3.5a3 3 0 016 0V5"/></svg>
            </div>
            <span class="auth-feature-text">Data Anda terenkripsi & aman</span>
        </div>
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><circle cx="5" cy="4" r="2"/><circle cx="9" cy="4" r="2"/><path d="M1 12c0-2.2 1.8-3.5 4-3.5M7.5 12c0-2.2 1.8-3.5 3.5-3.5"/></svg>
            </div>
            <span class="auth-feature-text">Bergabung dengan ribuan job seeker</span>
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
            margin: 20px 0;
        }
        .field-group { margin-bottom: 12px; }
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
        .field-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
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
            margin-top: 16px;
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
            margin-top: 14px;
        }
        .alt-action a {
            color: #6366f1;
            font-weight: 600;
            text-decoration: none;
        }
        .alt-action a:hover { text-decoration: underline; }
        .pass-hint {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 4px;
        }
        .terms-note {
            font-size: 11px;
            color: #94a3b8;
            text-align: center;
            margin-top: 10px;
            line-height: 1.5;
        }
    </style>

    <div class="form-eyebrow">Daftar sekarang</div>
    <div class="form-heading">Buat akun baru</div>
    <div class="form-sub-text">Mulai kelola karir Anda secara gratis</div>

    <div class="form-divider"></div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Name --}}
        <div class="field-group">
            <label for="name">Nama lengkap</label>
            <input id="name" type="text" name="name"
                   value="{{ old('name') }}"
                   placeholder="Nama Anda"
                   required autofocus autocomplete="name" />
            @if ($errors->has('name'))
                <div class="error-msg">{{ $errors->first('name') }}</div>
            @endif
        </div>

        {{-- Email --}}
        <div class="field-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="nama@email.com"
                   required autocomplete="username" />
            @if ($errors->has('email'))
                <div class="error-msg">{{ $errors->first('email') }}</div>
            @endif
        </div>

        {{-- Password fields side by side --}}
        <div class="field-row">
            <div class="field-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password"
                       placeholder="Min. 8 karakter"
                       required autocomplete="new-password" />
                @if ($errors->has('password'))
                    <div class="error-msg">{{ $errors->first('password') }}</div>
                @endif
            </div>
            <div class="field-group">
                <label for="password_confirmation">Konfirmasi</label>
                <input id="password_confirmation" type="password"
                       name="password_confirmation"
                       placeholder="Ulangi password"
                       required autocomplete="new-password" />
                @if ($errors->has('password_confirmation'))
                    <div class="error-msg">{{ $errors->first('password_confirmation') }}</div>
                @endif
            </div>
        </div>

        <button type="submit" class="btn-submit">
            <svg viewBox="0 0 16 16"><path d="M8 1v10M3 6l5 5 5-5"/><path d="M1 13h14"/></svg>
            Buat Akun Gratis
        </button>

        <div class="alt-action">
            Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
        </div>
    </form>
</x-guest-layout>
<x-guest-layout>
    {{-- Left panel content --}}
    @section('panel-headline')
        <p class="auth-panel-headline">Reset password<br>dengan mudah</p>
        <p class="auth-panel-sub">Kami akan mengirimkan link reset<br>ke email Anda dalam hitungan detik.</p>
    @endsection

    @section('panel-features')
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><path d="M1 3h12v8a1 1 0 01-1 1H2a1 1 0 01-1-1V3z"/><path d="M1 3l6 5 6-5"/></svg>
            </div>
            <span class="auth-feature-text">Link dikirim ke email terdaftar</span>
        </div>
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><circle cx="7" cy="7" r="6"/><path d="M7 4v3l2 2"/></svg>
            </div>
            <span class="auth-feature-text">Link berlaku selama 60 menit</span>
        </div>
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><rect x="1" y="5" width="12" height="8" rx="1.5"/><path d="M4 5V3.5a3 3 0 016 0V5"/></svg>
            </div>
            <span class="auth-feature-text">Password baru langsung aktif</span>
        </div>
    @endsection

    {{-- Form --}}
    <style>
        .form-eyebrow {
            font-size: 10px; font-weight: 600; color: #6366f1;
            letter-spacing: 1px; text-transform: uppercase; margin-bottom: 6px;
        }
        .form-heading {
            font-size: 22px; font-weight: 700; color: #0f172a;
            letter-spacing: -0.5px; line-height: 1.2;
        }
        .form-sub-text { font-size: 13px; color: #94a3b8; margin-top: 5px; line-height: 1.6; }
        .form-divider { height: 1px; background: #f1f5f9; margin: 22px 0; }
        .field-group { margin-bottom: 14px; }
        .field-group label {
            display: block; font-size: 11px; font-weight: 600;
            color: #475569; letter-spacing: 0.4px;
            text-transform: uppercase; margin-bottom: 6px;
        }
        .field-group input[type="email"] {
            width: 100%; height: 40px;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            padding: 0 12px; font-size: 14px;
            font-family: 'Inter', sans-serif; color: #0f172a;
            background: #f8fafc; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s, background 0.15s;
        }
        .field-group input:focus {
            border-color: #6366f1; background: #fff;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        }
        .error-msg {
            background: #fef2f2; border: 1px solid #fecaca;
            color: #dc2626; border-radius: 8px;
            padding: 9px 12px; font-size: 12px; margin-top: 5px;
        }
        .session-status {
            display: flex; align-items: center; gap: 10px;
            background: #f0fdf4; border: 1px solid #bbf7d0;
            color: #15803d; border-radius: 10px;
            padding: 12px 14px; font-size: 13px; margin-bottom: 18px;
        }
        .session-status svg {
            width: 16px; height: 16px; flex-shrink: 0;
            stroke: #16a34a; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }
        .btn-submit {
            display: flex; align-items: center; justify-content: center; gap: 8px;
            width: 100%; height: 42px;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            color: #fff; border: none; border-radius: 10px;
            font-size: 14px; font-weight: 600; font-family: 'Inter', sans-serif;
            cursor: pointer; margin-top: 20px;
            box-shadow: 0 4px 14px rgba(99,102,241,0.35);
            transition: opacity 0.15s, box-shadow 0.15s;
        }
        .btn-submit:hover { opacity: 0.92; box-shadow: 0 6px 20px rgba(99,102,241,0.45); }
        .btn-submit:active { transform: scale(0.99); }
        .btn-submit svg {
            width: 16px; height: 16px; stroke: white; fill: none;
            stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
        }
        .alt-action {
            text-align: center; font-size: 12px; color: #94a3b8; margin-top: 16px;
        }
        .alt-action a { color: #6366f1; font-weight: 600; text-decoration: none; }
        .alt-action a:hover { text-decoration: underline; }
    </style>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="session-status">
            <svg viewBox="0 0 16 16"><path d="M3 8l3.5 3.5L13 5"/></svg>
            {{ session('status') }}
        </div>
    @endif

    <div class="form-eyebrow">Lupa password</div>
    <div class="form-heading">Reset password Anda</div>
    <div class="form-sub-text">Masukkan email terdaftar dan kami akan mengirimkan link untuk membuat password baru.</div>

    <div class="form-divider"></div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="field-group">
            <label for="email">Alamat Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}"
                   placeholder="nama@email.com"
                   required autofocus />
            @if ($errors->has('email'))
                <div class="error-msg">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <button type="submit" class="btn-submit">
            <svg viewBox="0 0 16 16"><path d="M1 3h14v10a1 1 0 01-1 1H2a1 1 0 01-1-1V3z"/><path d="M1 3l7 6 7-6"/></svg>
            Kirim Link Reset Password
        </button>

        <div class="alt-action">
            Ingat password Anda? <a href="{{ route('login') }}">Kembali masuk</a>
        </div>
    </form>
</x-guest-layout>
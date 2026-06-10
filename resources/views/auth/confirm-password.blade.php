<x-guest-layout>
    {{-- Left panel content --}}
    @section('panel-headline')
        <p class="auth-panel-headline">Verifikasi<br>identitas Anda</p>
        <p class="auth-panel-sub">Langkah keamanan tambahan untuk<br>melindungi akun Anda.</p>
    @endsection

    @section('panel-features')
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><rect x="1" y="5" width="12" height="8" rx="1.5"/><path d="M4 5V3.5a3 3 0 016 0V5"/></svg>
            </div>
            <span class="auth-feature-text">Area aman & terenkripsi</span>
        </div>
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><path d="M7 1l5 3v4a5 5 0 01-5 5 5 5 0 01-5-5V4z"/><path d="M5 7l1.5 1.5L9 5.5"/></svg>
            </div>
            <span class="auth-feature-text">Data Anda selalu terlindungi</span>
        </div>
        <div class="auth-feature-row">
            <div class="auth-feature-icon">
                <svg viewBox="0 0 14 14"><circle cx="7" cy="7" r="6"/><path d="M7 4v3l2 2"/></svg>
            </div>
            <span class="auth-feature-text">Sesi aktif selama 24 jam</span>
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
        .field-group input[type="password"] {
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
        .security-notice {
            display: flex; align-items: flex-start; gap: 10px;
            background: #f8fafc; border: 1px solid #e2e8f0;
            border-radius: 10px; padding: 12px 14px;
            margin-bottom: 22px;
        }
        .security-notice svg {
            width: 16px; height: 16px; flex-shrink: 0;
            stroke: #6366f1; fill: none;
            stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round;
            margin-top: 1px;
        }
        .security-notice p { font-size: 12px; color: #64748b; line-height: 1.55; }
    </style>

    <div class="form-eyebrow">Konfirmasi keamanan</div>
    <div class="form-heading">Masukkan password Anda</div>
    <div class="form-sub-text">Verifikasi diperlukan sebelum melanjutkan ke area ini.</div>

    <div class="form-divider"></div>

    <div class="security-notice">
        <svg viewBox="0 0 16 16"><rect x="1" y="6" width="14" height="9" rx="2"/><path d="M4 6V4.5a4 4 0 018 0V6"/></svg>
        <p>Ini adalah area aman. Konfirmasi password Anda untuk memastikan bahwa Anda adalah pemilik akun ini.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="field-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password"
                   placeholder="Masukkan password Anda"
                   required autocomplete="current-password" />
            @if ($errors->has('password'))
                <div class="error-msg">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <button type="submit" class="btn-submit">
            <svg viewBox="0 0 16 16"><rect x="1" y="6" width="14" height="9" rx="2"/><path d="M4 6V4.5a4 4 0 018 0V6"/><circle cx="8" cy="11" r="1" fill="white" stroke="none"/></svg>
            Konfirmasi & Lanjutkan
        </button>
    </form>
</x-guest-layout>
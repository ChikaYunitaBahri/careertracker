<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Career Tracker') }}</title>
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

            body {
                font-family: 'Inter', sans-serif;
                background: #f1f5f9;
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 1.5rem;
            }

            /* ── WRAPPER ── */
            .auth-wrapper {
                display: flex;
                width: 100%;
                max-width: 900px;
                min-height: 560px;
                border-radius: 20px;
                overflow: hidden;
                box-shadow: 0 8px 48px rgba(0,0,0,0.12);
            }

            /* ── LEFT PANEL ── */
            .auth-panel-left {
                width: 44%;
                background: #0f172a;
                display: flex;
                flex-direction: column;
                padding: 40px 36px;
                position: relative;
                overflow: hidden;
                flex-shrink: 0;
            }

            /* Decorative blobs */
            .auth-panel-left::before {
                content: '';
                position: absolute;
                top: -80px; right: -80px;
                width: 240px; height: 240px;
                background: radial-gradient(circle, rgba(99,102,241,0.18) 0%, transparent 70%);
                pointer-events: none;
            }
            .auth-panel-left::after {
                content: '';
                position: absolute;
                bottom: -60px; left: -60px;
                width: 200px; height: 200px;
                background: radial-gradient(circle, rgba(139,92,246,0.14) 0%, transparent 70%);
                pointer-events: none;
            }

            /* Brand */
            .auth-brand {
                display: flex;
                align-items: center;
                gap: 10px;
                position: relative;
                z-index: 1;
                margin-bottom: auto;
            }
            .auth-brand-icon {
                width: 36px; height: 36px;
                background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
                border-radius: 10px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .auth-brand-icon svg { width: 20px; height: 20px; }
            .auth-brand-text { }
            .auth-brand-name {
                font-size: 15px;
                font-weight: 700;
                color: #ffffff;
                letter-spacing: -0.3px;
                line-height: 1;
            }
            .auth-brand-sub {
                font-size: 10px;
                color: rgba(255,255,255,0.35);
                letter-spacing: 0.3px;
                margin-top: 2px;
            }

            /* Mid content */
            .auth-panel-mid {
                flex: 1;
                display: flex;
                flex-direction: column;
                justify-content: center;
                position: relative;
                z-index: 1;
                padding: 32px 0;
            }
            .auth-panel-headline {
                font-size: 26px;
                font-weight: 700;
                color: #ffffff;
                line-height: 1.25;
                letter-spacing: -0.6px;
                margin-bottom: 10px;
            }
            .auth-panel-sub {
                font-size: 13px;
                color: rgba(255,255,255,0.42);
                line-height: 1.65;
            }

            /* Stats row */
            .auth-stats {
                display: flex;
                gap: 20px;
                margin-top: 28px;
            }
            .auth-stat {
                display: flex;
                flex-direction: column;
            }
            .auth-stat-num {
                font-size: 20px;
                font-weight: 700;
                color: #6366f1;
                letter-spacing: -0.5px;
                line-height: 1;
            }
            .auth-stat-label {
                font-size: 10px;
                color: rgba(255,255,255,0.35);
                margin-top: 3px;
                letter-spacing: 0.3px;
            }
            .auth-stat-divider {
                width: 1px;
                background: rgba(255,255,255,0.08);
                align-self: stretch;
            }

            /* Features */
            .auth-features {
                display: flex;
                flex-direction: column;
                gap: 12px;
                position: relative;
                z-index: 1;
            }
            .auth-feature-row {
                display: flex;
                align-items: center;
                gap: 12px;
            }
            .auth-feature-icon {
                width: 30px; height: 30px;
                background: rgba(99,102,241,0.15);
                border: 1px solid rgba(99,102,241,0.2);
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                flex-shrink: 0;
            }
            .auth-feature-icon svg {
                width: 14px; height: 14px;
                stroke: #818cf8;
                fill: none;
                stroke-width: 1.8;
                stroke-linecap: round;
                stroke-linejoin: round;
            }
            .auth-feature-text {
                font-size: 12px;
                color: rgba(255,255,255,0.5);
                line-height: 1.4;
            }

            /* ── RIGHT PANEL ── */
            .auth-panel-right {
                flex: 1;
                background: #ffffff;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 44px 40px;
            }
            .auth-form-wrap {
                width: 100%;
                max-width: 340px;
            }

            /* ── RESPONSIVE ── */
            @media (max-width: 640px) {
                .auth-panel-left { display: none; }
                .auth-wrapper { max-width: 420px; border-radius: 16px; }
                .auth-panel-right { padding: 32px 24px; }
            }
        </style>
    </head>
    <body>
        <div class="auth-wrapper">
            <!-- Left Branding Panel -->
            <div class="auth-panel-left">
                <!-- Brand -->
                <div class="auth-brand">
                    <div class="auth-brand-icon">
                        <!-- Briefcase icon matching Career Tracker sidebar icon -->
                        <svg viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="2" y="7" width="16" height="11" rx="2.5" stroke="white" stroke-width="1.8"/>
                            <path d="M7 7V5.5a3 3 0 016 0V7" stroke="white" stroke-width="1.8" stroke-linecap="round"/>
                            <path d="M2 12h16" stroke="white" stroke-width="1.5" stroke-linecap="round" opacity="0.6"/>
                        </svg>
                    </div>
                    <div class="auth-brand-text">
                        <div class="auth-brand-name">{{ config('app.name', 'Career Tracker') }}</div>
                        <div class="auth-brand-sub">Career Management Platform</div>
                    </div>
                </div>

                <!-- Mid: Headline + stats -->
                <div class="auth-panel-mid">
                    @yield('panel-headline')

                    <div class="auth-stats">
                        <div class="auth-stat">
                            <span class="auth-stat-num">2.4K+</span>
                            <span class="auth-stat-label">Pengguna aktif</span>
                        </div>
                        <div class="auth-stat-divider"></div>
                        <div class="auth-stat">
                            <span class="auth-stat-num">18K+</span>
                            <span class="auth-stat-label">Lamaran dikelola</span>
                        </div>
                        <div class="auth-stat-divider"></div>
                        <div class="auth-stat">
                            <span class="auth-stat-num">87%</span>
                            <span class="auth-stat-label">Response rate</span>
                        </div>
                    </div>
                </div>

                <!-- Features -->
                <div class="auth-features">
                    @yield('panel-features')
                </div>
            </div>

            <!-- Right Form Panel -->
            <div class="auth-panel-right">
                <div class="auth-form-wrap">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
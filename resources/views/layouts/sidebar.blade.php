<aside class="w-64 h-screen bg-white border-r border-[#E1E2E6] flex flex-col shrink-0">

    {{-- Brand --}}
    <div class="px-6 py-5 border-b border-[#E1E2E6]">

        <div class="flex items-start gap-3">

            <div
                class="w-12 h-12 rounded-2xl bg-[#5E3BDB] text-white flex items-center justify-center shrink-0">

                <i class="ri-rocket-2-line text-xl"></i>

            </div>

            <div>

                <h1 class="font-bold text-lg leading-6">
                    Career Tracker
                </h1>

                <p class="text-xs text-[#797586] mt-1">
                    Career Management Platform
                </p>

            </div>

        </div>

    </div>

    {{-- Menu --}}
    <nav class="flex-1 p-4 overflow-y-auto">

        <div class="space-y-1">

            <a href="{{ route('dashboard') }}"
                @class([
                    'flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors',
                    'bg-[#EEF2FF] text-[#5E3BDB]' => request()->routeIs('dashboard'),
                    'text-[#797586] hover:bg-[#F4F5F7]' => !request()->routeIs('dashboard'),
                ])>
                <i class="ri-dashboard-line"></i>
                Dashboard
            </a>

            <a href="{{ route('applications.index') }}"
                @class([
                    'flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors',
                    'bg-[#EEF2FF] text-[#5E3BDB]' => request()->routeIs('applications.*'),
                    'text-[#797586] hover:bg-[#F4F5F7]' => !request()->routeIs('applications.*'),
                ])>
                <i class="ri-file-list-3-line"></i>
                Lamaran
            </a>

            <a href="{{ route('companies.index') }}"
                @class([
                    'flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors',
                    'bg-[#EEF2FF] text-[#5E3BDB]' => request()->routeIs('companies.*'),
                    'text-[#797586] hover:bg-[#F4F5F7]' => !request()->routeIs('companies.*'),
                ])>
                <i class="ri-building-line"></i>
                Perusahaan
            </a>

            <a href="{{ route('calendar-events.index') }}"
                @class([
                    'flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors',
                    'bg-[#EEF2FF] text-[#5E3BDB]' => request()->routeIs('calendar-events.*'),
                    'text-[#797586] hover:bg-[#F4F5F7]' => !request()->routeIs('calendar-events.*'),
                ])>
                <i class="ri-calendar-line"></i>
                Kalender
            </a>

            <a href="{{ route('career-goals.index') }}"
                @class([
                    'flex items-center gap-3 px-4 py-3 rounded-xl font-medium transition-colors',
                    'bg-[#EEF2FF] text-[#5E3BDB]' => request()->routeIs('career-goals.*'),
                    'text-[#797586] hover:bg-[#F4F5F7]' => !request()->routeIs('career-goals.*'),
                ])>
                <i class="ri-focus-3-line"></i>
                Goal Karier
            </a>

            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#797586] hover:bg-[#F4F5F7] transition-colors">
                <i class="ri-bar-chart-box-line"></i>
                Analytics
            </a>

        </div>

        <div class="border-t border-[#E1E2E6] my-5"></div>

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl text-[#797586] hover:bg-[#F4F5F7] transition-colors">
            <i class="ri-settings-3-line"></i>
            Pengaturan
        </a>

    </nav>

    {{-- User --}}
    <div
        x-data="{ open:false }"
        class="p-4 border-t border-[#E1E2E6] relative">

        <button
            @click="open = !open"
            class="w-full bg-[#F8F9FD] hover:bg-[#F1F3F9] transition rounded-xl p-3 flex items-center justify-between">

            <div class="flex items-center gap-3 min-w-0">

                <div
                    class="w-10 h-10 rounded-full bg-[#5E3BDB] text-white flex items-center justify-center font-semibold shrink-0">

                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                </div>

                <div class="text-left min-w-0">

                    <p class="font-medium text-sm text-[#191C1F] truncate">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="text-xs text-[#797586] truncate">
                        {{ Auth::user()->email }}
                    </p>

                </div>

            </div>

            <i
                class="ri-arrow-up-s-line text-[#797586]"
                :class="{ 'rotate-180': open }">
            </i>

        </button>

        {{-- Dropdown --}}
        <div
            x-show="open"
            @click.away="open = false"
            x-transition
            class="absolute bottom-24 left-4 right-4 bg-white border border-[#E1E2E6] rounded-xl shadow-lg overflow-hidden z-50">

            {{-- Profile --}}
            <a
                href="/profile"
                class="flex items-center gap-3 px-4 py-3 hover:bg-[#F8F9FD]">

                <i class="ri-user-line"></i>

                <span>Profil</span>

            </a>

            {{-- Settings --}}
            <a
                href="#"
                class="flex items-center gap-3 px-4 py-3 hover:bg-[#F8F9FD]">

                <i class="ri-settings-3-line"></i>

                <span>Pengaturan</span>

            </a>

            <div class="border-t border-[#E1E2E6]"></div>

            {{-- Logout --}}
            <button
                type="button"
                onclick="document.getElementById('logoutModal').style.display='flex'"
                class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50">
                <i class="ri-logout-box-r-line"></i>
                <span>Keluar</span>
            </button>

        </div>

    </div>
    {{-- Logout Confirmation Modal --}}
    <div id="logoutModal"
        style="display:none; position:fixed; inset:0; z-index:100; align-items:center; justify-content:center; padding:1rem; background:rgba(0,0,0,0.4); backdrop-filter:blur(4px);"
        onclick="if(event.target===this) this.style.display='none'">

        <div style="background:white; border-radius:1rem; box-shadow:0 20px 60px rgba(0,0,0,0.15); width:100%; max-width:22rem; padding:1.5rem;">

            <div style="width:3.5rem; height:3.5rem; background:#fef2f2; border-radius:50%; display:flex; align-items:center; justify-content:center; margin:0 auto 1rem;">
                <i class="ri-logout-box-r-line" style="font-size:1.5rem; color:#ef4444;"></i>
            </div>

            <div style="text-align:center; margin-bottom:1.5rem;">
                <h3 style="font-size:1.125rem; font-weight:700; color:#191C1F; margin:0 0 0.375rem;">Keluar dari akun?</h3>
                <p style="font-size:0.875rem; color:#797586; margin:0;">Sesi Anda akan diakhiri dan Anda perlu login kembali.</p>
            </div>

            <div style="display:flex; gap:0.75rem;">
                <button
                    onclick="document.getElementById('logoutModal').style.display='none'"
                    style="flex:1; padding:0.625rem 1rem; font-size:0.875rem; font-weight:500; color:#797586; background:#F8F9FD; border:none; border-radius:0.75rem; cursor:pointer;">
                    Batal
                </button>
                <form method="POST" action="{{ route('logout') }}" style="flex:1;">
                    @csrf
                    <button type="submit"
                        style="width:100%; padding:0.625rem 1rem; font-size:0.875rem; font-weight:500; color:white; background:#ef4444; border:none; border-radius:0.75rem; cursor:pointer;">
                        Ya, Keluar
                    </button>
                </form>
            </div>

        </div>
    </div>
</aside>
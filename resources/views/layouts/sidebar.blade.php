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
                class="flex items-center gap-3 px-4 py-3 rounded-xl bg-[#EEF2FF] text-[#5E3BDB] font-medium">

                <i class="ri-dashboard-line"></i>
                Dashboard

            </a>

            <a href="{{ route('applications.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#F4F5F7]">

                <i class="ri-file-list-3-line"></i>
                Applications

            </a>

            <a href="{{ route('companies.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#F4F5F7]">

                <i class="ri-building-line"></i>
                Companies

            </a>

            <a href="{{ route('calendar-events.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#F4F5F7]">

                <i class="ri-calendar-line"></i>
                Calendar

            </a>

            <a href="{{ route('career-goals.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#F4F5F7]">

                <i class="ri-focus-3-line"></i>
                Career Goals

            </a>

            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#F4F5F7]">

                <i class="ri-bar-chart-box-line"></i>
                Analytics

            </a>

        </div>

        <div class="border-t border-[#E1E2E6] my-5"></div>

        <a href="#"
            class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-[#F4F5F7]">

            <i class="ri-settings-3-line"></i>
            Settings

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

                <span>Profile</span>

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
            <form
                method="POST"
                action="{{ route('logout') }}">

                @csrf

                <button
                    type="submit"
                    class="w-full flex items-center gap-3 px-4 py-3 text-red-600 hover:bg-red-50">

                    <i class="ri-logout-box-r-line"></i>

                    <span>Keluar</span>

                </button>

            </form>

        </div>

    </div>
    

</aside>
<header
    class="h-16 bg-white border-b border-[#E1E2E6] px-8 flex items-center justify-between shrink-0">

    {{-- Left --}}
    <div>

        <h2 class="text-lg font-semibold text-[#191C1F]">
            @php
                $pageNames = [
                    'applications' => 'Lamaran',
                    'perusahaan' => 'Perusahaan',
                    'kalender' => 'Kalender',
                    'goal-karier' => 'Goal Karier',
                    'analytics' => 'Analytics',
                    'pengaturan' => 'Pengaturan',
                ];
                $currentSegment = request()->segment(1) ?: 'dashboard';
                $pageName = $pageNames[$currentSegment] ?? ucfirst($currentSegment);
            @endphp
            {{ $pageName }}
        </h2>

    </div>

    {{-- Right --}}
    <div class="flex items-center gap-4">

        {{-- Notification --}}
        <div x-data="{ open: false }" class="relative">

            <button
                @click="open = !open"
                class="relative w-10 h-10 rounded-xl hover:bg-[#F4F5F7] flex items-center justify-center transition">

                <i class="ri-notification-3-line text-xl"></i>

                <!-- <span
                    class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full">
                </span> -->

            </button>

            <div
                x-show="open"
                @click.away="open = false"
                x-transition
                class="absolute right-0 mt-2 w-80 bg-white border border-[#E1E2E6] rounded-xl shadow-lg z-50">

                <div class="p-4 border-b">

                    <h3 class="font-semibold">
                        Notifikasi
                    </h3>

                </div>

                <div class="p-4 text-sm text-[#797586]">

                    Tidak ada notifikasi baru.

                </div>

            </div>

        </div>

        {{-- Profile Dropdown --}}
        <div x-data="{ open: false }" class="relative">

            <button
                @click="open = !open"
                class="flex items-center gap-3 hover:bg-[#F4F5F7] rounded-xl p-2 transition">

                <div
                    class="w-10 h-10 rounded-full bg-[#5E3BDB] text-white flex items-center justify-center font-semibold">

                    {{ strtoupper(substr(Auth::user()->name,0,1)) }}

                </div>

                <div class="text-left hidden md:block">

                    <p class="text-sm font-medium text-[#191C1F]">
                        {{ Auth::user()->name }}
                    </p>

                    <p class="text-xs text-[#797586]">
                        Job Seeker
                    </p>

                </div>

                <i class="ri-arrow-down-s-line text-[#797586]"></i>

            </button>

            <div
                x-show="open"
                @click.away="open = false"
                x-transition
                class="absolute right-0 mt-2 w-56 bg-white border border-[#E1E2E6] rounded-xl shadow-lg z-50">

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-4 py-3 hover:bg-[#F4F5F7]">

                    <i class="ri-user-line"></i>

                    Profil

                </a>

                <div class="border-t border-[#E1E2E6]"></div>

                <form method="POST"
                    action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="w-full text-left flex items-center gap-3 px-4 py-3 hover:bg-red-50 text-red-600">

                        <i class="ri-logout-box-r-line"></i>

                        Keluar

                    </button>

                </form>

            </div>

        </div>

    </div>

</header>
@extends('layouts.app')

@section('content')

<div class="space-y-8">

    {{-- Header --}}
    <div class="flex items-start justify-between">

        <div>

            <h1 class="text-4xl font-bold tracking-tight text-[#191C1F]">
                Dashboard
            </h1>

            <p class="text-[#797586] mt-2">
                Welcome back, {{ Auth::user()->name }} 👋
            </p>

        </div>

    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

        {{-- Applications --}}
        <div class="bg-white border border-[#E1E2E6] rounded-2xl p-6 relative">
            <div class="absolute top-6 right-6 w-9 h-9 rounded-2xl bg-violet-100 flex items-center justify-center text-purple-600">
                <i class="ri-group-line"></i>
            </div>
            <p class="text-sm text-[#797586]">Lamaran</p>
            <h2 class="text-5xl font-bold mt-3">{{ $totalApplications }}</h2>
            <p class="text-green-600 text-sm mt-3">{{ $totalApplications }} aktif</p>
        </div>

        {{-- Interviews --}}
        <div class="bg-white border border-[#E1E2E6] rounded-2xl p-6 relative">
            <div class="absolute top-6 right-6 w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M21 14l-3 -3h-7a1 1 0 0 1 -1 -1v-6a1 1 0 0 1 1 -1h9a1 1 0 0 1 1 1v10"/><path d="M14 15v2a1 1 0 0 1 -1 1h-7l-3 3v-10a1 1 0 0 1 1 -1h2"/>
                </svg>
            </div>
            <p class="text-sm text-[#797586]">Wawancara</p>
            <h2 class="text-5xl font-bold mt-3">{{ $totalInterviews }}</h2>
            <p class="text-green-600 text-sm mt-3">{{ $totalInterviews }} terjadwal</p>
        </div>

        {{-- Offers --}}
        <div class="bg-white border border-[#E1E2E6] rounded-2xl p-6 relative">
            <div class="absolute top-6 right-6 w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-amber-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 21l4 -4l4 4"/><path d="M12 17v-14"/><path d="M3 8l3 -3l3 3"/><path d="M3 5h6"/><path d="M15 8l3 -3l3 3"/><path d="M15 5h6"/>
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 21l8 0"/><path d="M12 17l0 4"/><path d="M7 4l5 3l5 -3"/><path d="M7 4l0 7.5l5 3l5 -3l0 -7.5"/>
                </svg>
            </div>
            <p class="text-sm text-[#797586]">Tawaran</p>
            <h2 class="text-5xl font-bold mt-3">{{ $totalOffers }}</h2>
            <p class="text-[#5E3BDB] text-sm mt-3">Menunggu respons</p>
        </div>

        {{-- Success Rate --}}
        <div class="bg-white border border-[#E1E2E6] rounded-2xl p-6 relative">
            <div class="absolute top-6 right-6 w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#5E3BDB]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l4 -4l4 4l4 -8l4 4"/>
                </svg>
            </div>
            <p class="text-sm text-[#797586]">Rate Keberhasilan</p>
            <h2 class="text-5xl font-bold mt-3">{{ $successRate }}%</h2>
            <p class="text-green-600 text-sm mt-3">Lamaran yang diterima</p>
        </div>

    </div>

    {{-- Goal Progress + Schedule --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Goal Progress --}}
        <div
            class="xl:col-span-2 bg-white border border-[#E1E2E6] rounded-2xl p-6">

            <div class="flex justify-between items-center mb-8">

                <h2 class="text-2xl font-semibold">
                    Progress Goal Karier
                </h2>

                <span class="text-sm text-[#797586]">
                    3 Goal Aktif
                </span>

            </div>

            <div class="space-y-8">

                <div>

                    <div class="flex justify-between mb-3">

                        <span class="font-medium">
                            Menjadi Product Designer
                        </span>

                        <span>
                            75%
                        </span>

                    </div>

                    <div class="h-3 bg-gray-100 rounded-full">

                        <div
                            class="h-3 rounded-full bg-[#5E3BDB]"
                            style="width:75%">
                        </div>

                    </div>

                </div>

                <div>

                    <div class="flex justify-between mb-3">

                        <span class="font-medium">
                            Membangun Website Portfolio
                        </span>

                        <span>
                            60%
                        </span>

                    </div>

                    <div class="h-3 bg-gray-100 rounded-full">

                        <div
                            class="h-3 rounded-full bg-emerald-500"
                            style="width:60%">
                        </div>

                    </div>

                </div>

                <div>

                    <div class="flex justify-between mb-3">

                        <span class="font-medium">
                            Menyelesaikan Sertifikasi UI/UX
                        </span>

                        <span>
                            40%
                        </span>

                    </div>

                    <div class="h-3 bg-gray-100 rounded-full">

                        <div
                            class="h-3 rounded-full bg-amber-500"
                            style="width:40%">
                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- Schedule --}}
        <div
            class="bg-white border border-[#E1E2E6] rounded-2xl p-6">

            <h2 class="text-2xl font-semibold mb-8">
                Aktivitas Mendatang
            </h2>

            <div class="space-y-6">

                <div class="flex gap-4">

                    <div class="w-1 bg-[#5E3BDB] rounded-full"></div>

                    <div>

                        <p class="font-semibold">
                            HR Interview
                        </p>

                        <p class="text-[#797586]">
                            Google • Besok
                        </p>

                    </div>

                </div>

                <div class="flex gap-4">

                    <div class="w-1 bg-emerald-500 rounded-full"></div>

                    <div>

                        <p class="font-semibold">
                            Review Portfolio
                        </p>

                        <p class="text-[#797586]">
                            Jumat • 13:00
                        </p>

                    </div>

                </div>

                <div class="flex gap-4">

                    <div class="w-1 bg-amber-500 rounded-full"></div>

                    <div>

                        <p class="font-semibold">
                            Deadline Goal
                        </p>

                        <p class="text-[#797586]">
                            Sertifikasi UI/UX
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- Recent Applications --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        <div
            class="xl:col-span-2 bg-white border border-[#E1E2E6] rounded-2xl overflow-hidden">

            <div
                class="p-6 border-b border-[#E1E2E6] flex justify-between items-center">

                <h2 class="text-2xl font-semibold">
                    Aplikasi Terbaru
                </h2>

                <a href="{{ route('applications.index') }}"
                    class="text-[#5E3BDB] font-medium hover:underline">
                    Lihat Semua
                </a>

            </div>

            <table class="w-full">

                <thead>

                    <tr
                        class="bg-[#F8F9FD] text-left text-sm text-[#797586]">

                        <th class="px-6 py-4">
                            Perusahaan
                        </th>

                        <th class="py-4">
                            Posisi
                        </th>

                        <th class="py-4">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($recentApplications as $application)
                        <tr class="border-t border-[#E1E2E6]">

                            <td class="px-6 py-5">
                                {{ $application->company_name }}
                            </td>

                            <td>
                                {{ $application->position_name }}
                            </td>

                            <td>

                                <span
                                    class="px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-sm">

                                    {{ $application->status->label ?? '-' }}

                                </span>

                            </td>

                        </tr>
                    @empty
                        <tr class="border-t border-[#E1E2E6]">
                            <td colspan="3" class="px-6 py-8 text-center text-[#797586]">
                                Belum ada lamaran.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>

        </div>

        {{-- Pipeline --}}
        <div
            class="bg-white border border-[#E1E2E6] rounded-2xl p-6">

            <h2 class="text-2xl font-semibold mb-6">
                Pipeline Aplikasi
            </h2>

            <div class="space-y-5">

                @foreach($pipelineStatuses as $status)
                    <div class="flex justify-between">
                        <span>{{ $status->label }}</span>
                        <span>{{ $status->applications_count }}</span>
                    </div>
                @endforeach

            </div>

        </div>

    </div>

</div>

@endsection

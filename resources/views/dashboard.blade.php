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

        <div
            class="bg-white border border-[#E1E2E6] rounded-2xl p-6">

            <p class="text-sm text-[#797586]">
                Applications
            </p>

            <h2 class="text-5xl font-bold mt-3">
                25
            </h2>

            <p class="text-green-600 text-sm mt-3">
                +12% this month
            </p>

        </div>

        <div
            class="bg-white border border-[#E1E2E6] rounded-2xl p-6">

            <p class="text-sm text-[#797586]">
                Interviews
            </p>

            <h2 class="text-5xl font-bold mt-3">
                8
            </h2>

            <p class="text-green-600 text-sm mt-3">
                +3 upcoming
            </p>

        </div>

        <div
            class="bg-white border border-[#E1E2E6] rounded-2xl p-6">

            <p class="text-sm text-[#797586]">
                Offers
            </p>

            <h2 class="text-5xl font-bold mt-3">
                2
            </h2>

            <p class="text-[#5E3BDB] text-sm mt-3">
                Waiting response
            </p>

        </div>

        <div
            class="bg-white border border-[#E1E2E6] rounded-2xl p-6">

            <p class="text-sm text-[#797586]">
                Success Rate
            </p>

            <h2 class="text-5xl font-bold mt-3">
                35%
            </h2>

            <p class="text-green-600 text-sm mt-3">
                Better than last month
            </p>

        </div>

    </div>

    {{-- Goal Progress + Schedule --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Goal Progress --}}
        <div
            class="xl:col-span-2 bg-white border border-[#E1E2E6] rounded-2xl p-6">

            <div class="flex justify-between items-center mb-8">

                <h2 class="text-2xl font-semibold">
                    Career Goal Progress
                </h2>

                <span class="text-sm text-[#797586]">
                    3 Active Goals
                </span>

            </div>

            <div class="space-y-8">

                <div>

                    <div class="flex justify-between mb-3">

                        <span class="font-medium">
                            Become Product Designer
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
                            Build Portfolio Website
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
                            Complete UI/UX Certification
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
                Upcoming Activities
            </h2>

            <div class="space-y-6">

                <div class="flex gap-4">

                    <div class="w-1 bg-[#5E3BDB] rounded-full"></div>

                    <div>

                        <p class="font-semibold">
                            HR Interview
                        </p>

                        <p class="text-[#797586]">
                            Google • Tomorrow
                        </p>

                    </div>

                </div>

                <div class="flex gap-4">

                    <div class="w-1 bg-emerald-500 rounded-full"></div>

                    <div>

                        <p class="font-semibold">
                            Portfolio Review
                        </p>

                        <p class="text-[#797586]">
                            Friday • 13:00
                        </p>

                    </div>

                </div>

                <div class="flex gap-4">

                    <div class="w-1 bg-amber-500 rounded-full"></div>

                    <div>

                        <p class="font-semibold">
                            Goal Deadline
                        </p>

                        <p class="text-[#797586]">
                            UI/UX Certificate
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
                    Recent Applications
                </h2>

                <a href="#"
                    class="text-[#5E3BDB] font-medium hover:underline">
                    View All
                </a>

            </div>

            <table class="w-full">

                <thead>

                    <tr
                        class="bg-[#F8F9FD] text-left text-sm text-[#797586]">

                        <th class="px-6 py-4">
                            Company
                        </th>

                        <th class="py-4">
                            Position
                        </th>

                        <th class="py-4">
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <tr class="border-t border-[#E1E2E6]">

                        <td class="px-6 py-5">
                            Google
                        </td>

                        <td>
                            Product Designer
                        </td>

                        <td>

                            <span
                                class="px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-sm">

                                Interview

                            </span>

                        </td>

                    </tr>

                    <tr class="border-t border-[#E1E2E6]">

                        <td class="px-6 py-5">
                            Shopee
                        </td>

                        <td>
                            UI Designer
                        </td>

                        <td>

                            <span
                                class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm">

                                Applied

                            </span>

                        </td>

                    </tr>

                    <tr class="border-t border-[#E1E2E6]">

                        <td class="px-6 py-5">
                            Tokopedia
                        </td>

                        <td>
                            Frontend Developer
                        </td>

                        <td>

                            <span
                                class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm">

                                Offer

                            </span>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        {{-- Pipeline --}}
        <div
            class="bg-white border border-[#E1E2E6] rounded-2xl p-6">

            <h2 class="text-2xl font-semibold mb-6">
                Application Pipeline
            </h2>

            <div class="space-y-5">

                <div class="flex justify-between">
                    <span>Applied</span>
                    <span>25</span>
                </div>

                <div class="flex justify-between">
                    <span>Review</span>
                    <span>12</span>
                </div>

                <div class="flex justify-between">
                    <span>Interview</span>
                    <span>8</span>
                </div>

                <div class="flex justify-between">
                    <span>Offer</span>
                    <span>2</span>
                </div>

                <div class="flex justify-between">
                    <span>Rejected</span>
                    <span>6</span>
                </div>

            </div>

        </div>

    </div>

</div>

@endsection
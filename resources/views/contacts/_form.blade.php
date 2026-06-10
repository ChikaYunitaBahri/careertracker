<div class="max-w-5xl mx-auto space-y-6">

    {{-- HEADER --}}
    <div class="flex items-start gap-3">

        <a href="{{ route('companies.show', $company) }}"
           class="mt-1 p-2 rounded-lg text-[#797586] hover:bg-[#F4F5F8] hover:text-[#5E3BDB] transition">

            <i class="ri-arrow-left-line text-lg"></i>
        </a>

        <div>
            <h1 class="text-3xl font-bold text-[#191C1F]">
                {{ $title }}
            </h1>

            <p class="text-sm text-[#797586] mt-1">
                {{ $company->name }}
            </p>
        </div>

    </div>

    {{-- FORM --}}
    <form action="{{ $action }}" method="POST">

        @csrf

        @if($method !== 'POST')
            @method($method)
        @endif

        <div class="bg-white border border-[#EAEBEF] rounded-2xl overflow-hidden">

            {{-- CARD HEADER --}}
            <div class="px-6 py-5 border-b border-[#EAEBEF]">

                <div class="flex items-center gap-3">

                    <div class="w-12 h-12 rounded-xl bg-[#F0ECFE] flex items-center justify-center">
                        <i class="ri-user-3-line text-xl text-[#5E3BDB]"></i>
                    </div>

                    <div>
                        <h2 class="font-semibold text-[#191C1F]">
                            Informasi Kontak
                        </h2>

                        <p class="text-sm text-[#797586]">
                            HR, recruiter, hiring manager, atau networking contact
                        </p>
                    </div>

                </div>

            </div>

            {{-- FORM BODY --}}
            <div class="p-6 space-y-6">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- NAMA --}}
                    <div>
                        <label class="block text-sm font-medium text-[#191C1F] mb-2">
                            Nama Kontak *
                        </label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $contact->name ?? '') }}"
                            required
                            class="w-full px-4 py-3 border border-[#E1E2E6] rounded-xl focus:border-[#5E3BDB] focus:ring-4 focus:ring-[#5E3BDB]/10">

                        @error('name')
                            <p class="text-xs text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- JABATAN --}}
                    <div>
                        <label class="block text-sm font-medium text-[#191C1F] mb-2">
                            Jabatan
                        </label>

                        <input
                            type="text"
                            name="role"
                            value="{{ old('role', $contact->role ?? '') }}"
                            placeholder="HR Recruiter"
                            class="w-full px-4 py-3 border border-[#E1E2E6] rounded-xl focus:border-[#5E3BDB] focus:ring-4 focus:ring-[#5E3BDB]/10">
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label class="block text-sm font-medium text-[#191C1F] mb-2">
                            Email
                        </label>

                        <input
                            type="email"
                            name="email"
                            value="{{ old('email', $contact->email ?? '') }}"
                            placeholder="email@company.com"
                            class="w-full px-4 py-3 border border-[#E1E2E6] rounded-xl focus:border-[#5E3BDB] focus:ring-4 focus:ring-[#5E3BDB]/10">

                        @error('email')
                            <p class="text-xs text-red-500 mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    {{-- PHONE --}}
                    <div>
                        <label class="block text-sm font-medium text-[#191C1F] mb-2">
                            Nomor Telepon
                        </label>

                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone', $contact->phone ?? '') }}"
                            placeholder="+62..."
                            class="w-full px-4 py-3 border border-[#E1E2E6] rounded-xl focus:border-[#5E3BDB] focus:ring-4 focus:ring-[#5E3BDB]/10">
                    </div>

                </div>

                {{-- LINKEDIN --}}
                <div>
                    <label class="block text-sm font-medium text-[#191C1F] mb-2">
                        LinkedIn URL
                    </label>

                    <input
                        type="url"
                        name="linkedin_url"
                        value="{{ old('linkedin_url', $contact->linkedin_url ?? '') }}"
                        placeholder="https://linkedin.com/in/..."
                        class="w-full px-4 py-3 border border-[#E1E2E6] rounded-xl focus:border-[#5E3BDB] focus:ring-4 focus:ring-[#5E3BDB]/10">

                    @error('linkedin_url')
                        <p class="text-xs text-red-500 mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                {{-- NOTES --}}
                <div>
                    <label class="block text-sm font-medium text-[#191C1F] mb-2">
                        Catatan
                    </label>

                    <textarea
                        name="notes"
                        rows="5"
                        placeholder="Misalnya: recruiter yang menghubungi saat interview..."
                        class="w-full px-4 py-3 border border-[#E1E2E6] rounded-xl resize-none focus:border-[#5E3BDB] focus:ring-4 focus:ring-[#5E3BDB]/10">{{ old('notes', $contact->notes ?? '') }}</textarea>
                </div>

            </div>

        </div>

        {{-- BUTTONS --}}
        <div class="flex items-center justify-end gap-3 mt-6">

            <a href="{{ route('companies.show', $company) }}"
               class="px-5 py-3 rounded-xl border border-[#E1E2E6] text-[#797586] hover:bg-[#F8F9FD]">

                Batal
            </a>

            <button
                type="submit"
                class="px-6 py-3 rounded-xl bg-[#5E3BDB] text-white font-medium hover:bg-[#4D31B8] transition">

                <i class="ri-save-line mr-1"></i>

                {{ $method === 'POST'
                    ? 'Simpan Kontak'
                    : 'Update Kontak' }}
            </button>

        </div>

    </form>

</div>
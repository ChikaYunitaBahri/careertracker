<div class="bg-white border border-[#EAEBEF] rounded-xl overflow-hidden">

    {{-- Header --}}
    <div class="flex items-center justify-between px-5 py-3.5 border-b border-[#EAEBEF]">

        <div class="flex items-center gap-2">
            <h2 class="text-sm font-semibold text-[#191C1F]">
                Kontak Perusahaan
            </h2>

            <span
                class="text-[11px] font-medium bg-[#EDE9FB] text-[#5E3BDB] px-1.5 py-0.5 rounded-full">
                {{ $company->contacts->count() }}
            </span>
        </div>

        <a href="{{ route('companies.contacts.create', $company) }}"
            class="flex items-center gap-1 text-xs font-medium text-[#5E3BDB] hover:bg-[#EDE9FB] px-2.5 py-1.5 rounded-lg transition-colors">

            <i class="ri-add-line text-sm"></i>
            Tambah Kontak
        </a>

    </div>

    {{-- Contact List --}}
    @forelse($company->contacts as $contact)

        <div
            class="flex items-start gap-3 px-5 py-4 border-b border-[#EAEBEF] last:border-0 hover:bg-[#FAFBFF] transition-colors group">

            {{-- Avatar --}}
            <div
                class="w-10 h-10 rounded-full bg-[#F0ECFE] flex items-center justify-center flex-shrink-0">

                <span class="text-sm font-semibold text-[#5E3BDB]">
                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                </span>

            </div>

            {{-- Info --}}
            <div class="flex-1 min-w-0">

                <div class="flex items-center gap-2 flex-wrap">

                    <p class="text-sm font-medium text-[#191C1F]">
                        {{ $contact->name }}
                    </p>

                    @if($contact->position)
                        <span
                            class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-[#F0ECFE] text-[#5E3BDB]">
                            {{ $contact->position }}
                        </span>
                    @endif

                </div>

                <div class="mt-1.5 space-y-1">

                    @if($contact->email)
                        <a href="mailto:{{ $contact->email }}"
                            class="flex items-center gap-2 text-xs text-[#797586] hover:text-[#5E3BDB]">

                            <i class="ri-mail-line"></i>
                            <span>{{ $contact->email }}</span>
                        </a>
                    @endif

                    @if($contact->phone)
                        <a href="tel:{{ $contact->phone }}"
                            class="flex items-center gap-2 text-xs text-[#797586] hover:text-[#5E3BDB]">

                            <i class="ri-phone-line"></i>
                            <span>{{ $contact->phone }}</span>
                        </a>
                    @endif

                    @if($contact->linkedin_url)
                        <a href="{{ $contact->linkedin_url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center gap-2 text-xs text-[#797586] hover:text-[#5E3BDB]">

                            <i class="ri-linkedin-box-line"></i>
                            <span>LinkedIn Profile</span>
                        </a>
                    @endif

                </div>

                @if($contact->notes)
                    <div
                        class="mt-3 pt-3 border-t border-dashed border-[#EAEBEF]">

                        <p
                            class="text-[11px] font-medium text-[#ADADB8] uppercase tracking-wide mb-1">

                            Catatan
                        </p>

                        <p
                            class="text-xs text-[#797586] leading-relaxed whitespace-pre-line">

                            {{ $contact->notes }}

                        </p>

                    </div>
                @endif

            </div>

            {{-- Actions --}}
            <div
                class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">

                <a href="{{ route('companies.contacts.edit', [$company, $contact]) }}"
                    class="p-1.5 rounded-lg text-[#ADADB8] hover:text-[#5E3BDB] hover:bg-[#EDE9FB] transition-colors"
                    title="Edit">

                    <i class="ri-edit-line text-sm"></i>

                </a>

                <button
                    type="button"
                    @click="$dispatch('open-delete-modal', {
                        formAction: '{{ route('companies.contacts.destroy', [$company, $contact]) }}',
                        title: 'Hapus Kontak?',
                        description: 'Kontak {{ addslashes($contact->name) }} akan dihapus permanen.'
                    })"
                    class="p-1.5 rounded-lg text-[#ADADB8] hover:text-red-500 hover:bg-red-50 transition-colors"
                    title="Hapus">

                    <i class="ri-delete-bin-line text-sm"></i>

                </button>

            </div>

        </div>

    @empty

        {{-- Empty State --}}
        <div class="text-center py-12">

            <div
                class="w-14 h-14 rounded-full bg-[#F8F9FD] flex items-center justify-center mx-auto mb-3">

                <i class="ri-user-search-line text-2xl text-[#C5C6CC]"></i>

            </div>

            <p class="text-sm font-medium text-[#797586]">
                Belum ada kontak
            </p>

            <p class="text-xs text-[#ADADB8] mt-1">
                Tambahkan recruiter, HR, atau kontak perusahaan untuk referensi
            </p>

            <a href="{{ route('companies.contacts.create', $company) }}"
                class="inline-flex items-center gap-1.5 mt-4 text-sm font-medium text-[#5E3BDB] bg-[#EDE9FB] px-3 py-2 rounded-lg hover:bg-[#ddd5f8] transition-colors">

                <i class="ri-add-line"></i>
                Tambah Kontak

            </a>

        </div>

    @endforelse

</div>
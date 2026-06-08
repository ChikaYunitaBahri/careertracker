<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyContactRequest;
use App\Models\Company;
use App\Models\CompanyContact;
use Illuminate\Http\RedirectResponse;

class CompanyContactController extends Controller
{
    /**
     * Tambahkan kontak baru ke dalam sebuah perusahaan.
     *
     * Kontak dapat berupa HR, rekruter, atau siapapun yang berhubungan
     * dengan proses rekrutmen di perusahaan tersebut.
     * user_id diisi dari sesi login agar kepemilikan data tetap terjaga.
     */
    public function store(StoreCompanyContactRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('view', $company);

        $company->contacts()->create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return back()->with('success', 'Kontak berhasil ditambahkan.');
    }

    /**
     * Perbarui data kontak perusahaan.
     * Validasi memastikan kontak memang milik perusahaan yang dimaksud.
     */
    public function update(StoreCompanyContactRequest $request, Company $company, CompanyContact $contact): RedirectResponse
    {
        $this->authorize('view', $company);

        abort_if($contact->company_id !== $company->id, 404);

        $contact->update($request->validated());

        return back()->with('success', 'Data kontak berhasil diperbarui.');
    }

    /**
     * Hapus kontak dari perusahaan.
     */
    public function destroy(Company $company, CompanyContact $contact): RedirectResponse
    {
        $this->authorize('update', $company);

        abort_if($contact->company_id !== $company->id, 404);

        $contact->delete();

        return back()->with('success', 'Kontak berhasil dihapus.');
    }
}
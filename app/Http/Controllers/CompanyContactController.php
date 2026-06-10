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
    public function create(Company $company)
    {
        return view('contacts.create', [
            'company' => $company
        ]);
    }
    
    public function show(Company $company)
    {
        $company->load('contacts');

        $company->loadCount([
            'contacts',
            'applications'
        ]);

        return view('companies.show', compact('company'));
    }
    
    public function store(StoreCompanyContactRequest $request, Company $company): RedirectResponse
    {
        $company->contacts()->create([
            ...$request->validated(),
            'user_id' => auth()->id(),
        ]);

        return redirect()
            ->route('companies.show', $company)
            ->with('success', 'Kontak berhasil ditambahkan.');
    }

    public function edit(
        Company $company,
        CompanyContact $contact
    ) {
        abort_if(
            $contact->company_id !== $company->id,
            404
        );

        return view(
            'contacts.edit',
            compact('company', 'contact')
        );
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

       return redirect()
            ->route('companies.show', $company)
            ->with('success', 'Data kontak berhasil diperbarui.');
    }

    /**
     * Hapus kontak dari perusahaan.
     */
    public function destroy(Company $company, CompanyContact $contact): RedirectResponse
    {
        $this->authorize('update', $company);

        abort_if($contact->company_id !== $company->id, 404);

        $contact->delete();

        return redirect()
            ->route('companies.show', $company)
            ->with('success', 'Kontak berhasil dihapus.');
    }
}
<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Tampilkan daftar semua perusahaan milik user.
     * Dilengkapi jumlah lamaran per perusahaan dan filter pencarian.
     */
    public function index(Request $request): View
    {
        $query = auth()->user()
            ->companies()
            ->withCount('applications');

        // Filter pencarian berdasarkan nama perusahaan atau industri
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('industry', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan ukuran perusahaan
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        $companies = $query->latest()->paginate(12)->withQueryString();

        return view('companies.index', compact('companies'));
    }

    /**
     * Tampilkan form untuk menambah perusahaan baru.
     */
    public function create(): View
    {
        return view('companies.create');
    }

    /**
     * Simpan perusahaan baru ke database.
     */
    public function store(StoreCompanyRequest $request): RedirectResponse
    {
        $company = $request->user()->companies()->create($request->validated());

        return redirect()->route('companies.show', $company)
            ->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail perusahaan beserta daftar lamaran dan kontak yang terkait.
     */
    public function show(Company $company): View
    {
        $this->authorize('view', $company);

        $company->load([
            'applications.status',
            'contacts' => fn($q) => $q->orderBy('name'),
        ]);

        return view('companies.show', compact('company'));
    }

    /**
     * Tampilkan form edit data perusahaan.
     */
    public function edit(Company $company): View
    {
        $this->authorize('update', $company);

        return view('companies.edit', compact('company'));
    }

    /**
     * Perbarui data perusahaan yang sudah ada.
     */
    public function update(UpdateCompanyRequest $request, Company $company): RedirectResponse
    {
        $this->authorize('update', $company);

        $company->update($request->validated());

        return back()->with('success', 'Data perusahaan berhasil diperbarui.');
    }

    /**
     * Hapus perusahaan. Lamaran yang terhubung akan di-set null (nullOnDelete)
     * sesuai konfigurasi migration, data lamaran tetap terjaga.
     */
    public function destroy(Company $company): RedirectResponse
    {
        $this->authorize('delete', $company);

        $company->delete();

        return redirect()->route('companies.index')
            ->with('success', 'Perusahaan berhasil dihapus.');
    }
}
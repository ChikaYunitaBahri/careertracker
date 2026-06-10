<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * INDEX — List semua perusahaan milik user yang login,
     * dengan filter search, industry, sort, dan view mode.
     */
    public function index(Request $request)
    {
        $query = Company::where('user_id', auth()->id());

        // Search
        if ($search = $request->get('search')) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Filter industri (bisa multiple, dipisah koma)
        if ($industry = $request->get('industry')) {
            $industries = array_filter(explode(',', $industry));
            if (! empty($industries)) {
                $query->whereIn('industry', $industries);
            }
        }

        // Sort
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'oldest' => $query->oldest(),
            'name'   => $query->orderBy('name'),
            default  => $query->latest(),
        };

        $companies = $query->paginate(12)->withQueryString();
        $viewMode  = $request->get('view', 'board'); // 'board' atau 'list'

        return view('companies.index', compact('companies', 'viewMode'));
    }

    /**
     * SHOW — Fix 403: pastikan hanya pemilik yang bisa lihat.
     */
    public function show(Company $company)
    {
        // Cek kepemilikan — kalau bukan miliknya, abort 403
        abort_if($company->user_id !== auth()->id(), 403);
        
        $company->load('contacts');

        $company->loadCount([
            'contacts',
            'applications'
        ]);

        return view('companies.show', compact('company'));
    }

    /**
     * CREATE
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * STORE — Fix: user_id di-set dari auth(), bukan dari request.
     */
    public function store(StoreCompanyRequest $request)
    {
        $data            = $request->validated();
        $data['user_id'] = auth()->id(); // Selalu dari server, bukan input

        Company::create($data);

        return redirect()
            ->route('companies.index')
            ->with('success', 'Perusahaan berhasil ditambahkan.');
    }

    /**
     * EDIT — Fix 403
     */
    public function edit(Company $company)
    {
        abort_if($company->user_id !== auth()->id(), 403);

        return view('companies.edit', compact('company'));
    }

    /**
     * UPDATE — Fix 403
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        abort_if($company->user_id !== auth()->id(), 403);

        $company->update($request->validated());

        return redirect()
            ->route('companies.show', $company)
            ->with('success', 'Perusahaan berhasil diperbarui.');
    }

    /**
     * DESTROY — Fix: delete modal tidak berfungsi karena event Alpine.js
     * belum di-init dengan benar. Di sini cukup pastikan otorisasi.
     */
    public function destroy(Company $company)
    {
        abort_if($company->user_id !== auth()->id(), 403);

        $company->delete();

        return redirect()
            ->route('companies.index')
            ->with('success', 'Perusahaan berhasil dihapus.');
    }
}
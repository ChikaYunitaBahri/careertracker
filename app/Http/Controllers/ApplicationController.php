<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use App\Models\RecruitmentStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function index(): View
    {
        $user     = auth()->user();
        $viewMode = request('view', 'board'); // 'board' | 'list'

        // ── Base query dengan filter ──────────────────────────────────
        $query = $user->applications()
            ->with(['status', 'company'])
            ->active();

        // Filter: search
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('position_name', 'like', "%{$search}%")
                  ->orWhere('company_name',  'like', "%{$search}%");
            });
        }

        // Filter: job_type (bisa multiple, dipisah koma)
        if ($jobType = request('job_type')) {
            $types = array_filter(explode(',', $jobType));
            if (!empty($types)) {
                $query->whereIn('job_type', $types);
            }
        }

        // Sort
        $sort = request('sort', 'latest');
        match ($sort) {
            'oldest'   => $query->oldest(),
            'position' => $query->orderBy('position_name'),
            default    => $query->latest(),
        };

        // ── Data untuk masing-masing view ─────────────────────────────
        $statuses    = RecruitmentStatus::orderBy('sort_order')->orderBy('order_position')->get();
        $totalActive = $user->applications()->active()->count();

        if ($viewMode === 'list') {
            $applications = $query->paginate(10)->withQueryString();
            $grouped      = collect();
        } else {
            // Board: ambil semua (tanpa paginate) lalu group by status_id
            $applications = $query->get();
            $grouped      = $applications->groupBy('status_id');
        }

        return view('applications.index', compact(
            'applications',
            'statuses',
            'grouped',
            'viewMode',
            'totalActive',
        ));
    }

    public function create(): View
    {
        $statuses        = RecruitmentStatus::orderBy('sort_order')->orderBy('order_position')->get();
        $defaultStatusId = $statuses->first(fn($s) => $s->slug === 'wishlist')?->id
                        ?? $statuses->first()?->id;

        // Jika dari board, pre-select kolom yang diklik
        if ($requestStatus = request('status')) {
            $defaultStatusId = (int) $requestStatus;
        }

        return view('applications.create', compact('statuses', 'defaultStatusId'));
    }

    public function store(StoreApplicationRequest $request): RedirectResponse
    {
        $application = $request->user()->applications()->create($request->validated());

        return redirect()->route('applications.show', $application)
            ->with('success', 'Lamaran berhasil ditambahkan.');
    }

    public function show(Application $application): View
    {
        $this->authorize('view', $application);

        $application->load([
            'status',
            'company',
            'notes'     => fn ($q) => $q->latest(),
            'documents' => fn ($q) => $q->latest(),
            'activities',
            'calendarEvents',
        ]);

        return view('applications.show', compact('application'));
    }

    public function edit(Application $application): View
    {
        $this->authorize('update', $application);

        $statuses = RecruitmentStatus::orderBy('sort_order')->orderBy('order_position')->get();

        return view('applications.edit', compact('application', 'statuses'));
    }

    public function update(UpdateApplicationRequest $request, Application $application): RedirectResponse
    {
        $this->authorize('update', $application);

        $application->update($request->validated());

        return redirect()->route('applications.show', $application)
            ->with('success', 'Lamaran berhasil diperbarui.');
    }

    public function destroy(Application $application): RedirectResponse
    {
        $this->authorize('delete', $application);

        $application->delete();

        return redirect()->route('applications.index')
            ->with('success', 'Lamaran berhasil dihapus.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCareerGoalRequest;
use App\Http\Requests\UpdateCareerGoalRequest;
use App\Models\CareerGoal;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerGoalController extends Controller
{
    /**
     * Tampilkan semua target karir user.
     *
     * Dikelompokkan berdasarkan status: active, achieved, archived.
     * Setiap goal memuat milestones dan perhitungan progress otomatis.
     */
    public function index(Request $request): View
    {
        $filter = $request->get('status', 'active');

        $goals = auth()->user()
            ->careerGoals()
            ->with('milestones')
            ->when(
                in_array($filter, ['active', 'achieved', 'archived']),
                fn($q) => $q->where('status', $filter),
                fn($q) => $q->where('status', 'active') // fallback ke active jika filter tidak valid
            )
            ->latest()
            ->get();

        // Hitung ringkasan statistik untuk dashboard goal
        $summary = [
            'active'   => auth()->user()->careerGoals()->where('status', 'active')->count(),
            'achieved' => auth()->user()->careerGoals()->where('status', 'achieved')->count(),
            'archived' => auth()->user()->careerGoals()->where('status', 'archived')->count(),
        ];

        return view('goals.index', compact('goals', 'filter', 'summary'));
    }

    /**
     * Tampilkan form membuat target karir baru.
     */
    public function create(): View
    {
        return view('goals.create');
    }

    /**
     * Simpan target karir baru.
     * current_count dimulai dari 0; akan diperbarui secara otomatis
     * setiap kali lamaran baru dibuat (bisa via Observer atau event listener).
     */
    public function store(StoreCareerGoalRequest $request): RedirectResponse
    {
        $goal = $request->user()->careerGoals()->create([
            ...$request->validated(),
            'current_count' => 0,
            'status'        => 'active',
        ]);

        return redirect()->route('goals.show', $goal)
            ->with('success', 'Target karir berhasil dibuat.');
    }

    /**
     * Tampilkan detail target karir beserta semua milestones dan progress bar.
     */
    public function show(CareerGoal $goal): View
    {
        $this->authorize('view', $goal);

        $goal->load('milestones');

        // Hitung jumlah lamaran yang sudah dibuat dalam periode goal ini
        $applicationCount = auth()->user()
            ->applications()
            ->when($goal->deadline, fn($q) => $q->where('applied_date', '<=', $goal->deadline))
            ->count();

        return view('goals.show', compact('goal', 'applicationCount'));
    }

    /**
     * Tampilkan form edit target karir.
     */
    public function edit(CareerGoal $goal): View
    {
        $this->authorize('update', $goal);

        return view('goals.edit', compact('goal'));
    }

    /**
     * Perbarui data target karir.
     */
    public function update(UpdateCareerGoalRequest $request, CareerGoal $goal): RedirectResponse
    {
        $this->authorize('update', $goal);

        $goal->update($request->validated());

        return back()->with('success', 'Target karir berhasil diperbarui.');
    }

    /**
     * Tandai target karir sebagai "tercapai".
     * Mengubah status menjadi 'achieved' dan mencatat waktu pencapaian.
     */
    public function achieve(CareerGoal $goal): RedirectResponse
    {
        $this->authorize('update', $goal);

        $goal->update(['status' => 'achieved']);

        return back()->with('success', 'Selamat! Target karir berhasil dicapai.');
    }

    /**
     * Arsipkan target karir yang sudah tidak aktif.
     */
    public function archive(CareerGoal $goal): RedirectResponse
    {
        $this->authorize('update', $goal);

        $goal->update(['status' => 'archived']);

        return back()->with('success', 'Target karir berhasil diarsipkan.');
    }

    /**
     * Hapus target karir beserta semua milestones-nya (cascade).
     */
    public function destroy(CareerGoal $goal): RedirectResponse
    {
        $this->authorize('delete', $goal);

        $goal->delete();

        return redirect()->route('goals.index')
            ->with('success', 'Target karir berhasil dihapus.');
    }
}
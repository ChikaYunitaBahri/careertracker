<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationRequest;
use App\Http\Requests\UpdateApplicationRequest;
use App\Models\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class ApplicationController extends Controller
{
    public function index(): View
    {
        $applications = auth()->user()
            ->applications()
            ->with(['status', 'company'])
            ->active()
            ->latest()
            ->paginate(15);

        return view('applications.index', compact('applications'));
    }

    public function store(StoreApplicationRequest $request): RedirectResponse
    {
        $application = $request->user()->applications()->create($request->validated());

        return redirect()->route('applications.show', $application)
            ->with('success', 'Lamaran berhasil ditambahkan.');
    }

    public function show(Application $application): View
    {
        // Pastikan hanya pemilik yang bisa akses
        $this->authorize('view', $application);

        $application->load(['status', 'company', 'notes', 'documents', 'activities', 'calendarEvents']);

        return view('applications.show', compact('application'));
    }

    public function update(UpdateApplicationRequest $request, Application $application): RedirectResponse
    {
        $this->authorize('update', $application);

        $application->update($request->validated());

        return back()->with('success', 'Lamaran berhasil diperbarui.');
    }

    public function destroy(Application $application): RedirectResponse
    {
        $this->authorize('delete', $application);

        $application->delete();

        return redirect()->route('applications.index')
            ->with('success', 'Lamaran berhasil dihapus.');
    }
}
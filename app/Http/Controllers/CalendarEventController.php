<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCalendarEventRequest;
use App\Http\Requests\UpdateCalendarEventRequest;
use App\Models\Application;
use App\Models\CalendarEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CalendarEventController extends Controller
{
    /**
     * Tampilkan semua jadwal milik user.
     *
     * Mendukung filter rentang tanggal untuk tampilan kalender (bulanan/mingguan).
     * Jika request dari AJAX, kembalikan JSON — cocok untuk integrasi FullCalendar.js
     * atau library kalender lainnya di frontend.
     */
    public function index(Request $request): View|JsonResponse
    {
        $query = auth()->user()
            ->calendarEvents()
            ->with('application:id,position_name,company_name');

        // Filter rentang tanggal — digunakan oleh library kalender frontend
        if ($request->filled('from')) {
            $query->where('event_datetime', '>=', $request->from);
        }

        if ($request->filled('until')) {
            $query->where('event_datetime', '<=', $request->until);
        }

        // Filter hanya yang belum selesai
        if ($request->boolean('upcoming')) {
            $query->where('is_completed', false)->where('event_datetime', '>=', now());
        }

        $events = $query->orderBy('event_datetime')->get();

        if ($request->expectsJson()) {
            return response()->json($events);
        }

        // Ambil jadwal mendatang yang paling dekat untuk widget dashboard
        $upcomingEvents = auth()->user()
            ->calendarEvents()
            ->where('is_completed', false)
            ->where('event_datetime', '>=', now())
            ->orderBy('event_datetime')
            ->take(5)
            ->get();

        return view('calendar.index', compact('events', 'upcomingEvents'));
    }

    /**
     * Tampilkan form untuk membuat jadwal baru.
     * Parameter opsional `application_id` untuk pre-fill dari halaman detail lamaran.
     */
    public function create(Request $request): View
    {
        $applications = auth()->user()
            ->applications()
            ->active()
            ->orderBy('position_name')
            ->get(['id', 'position_name', 'company_name']);

        // Pre-select aplikasi jika dibuka dari halaman detail lamaran
        $selectedApplication = null;
        if ($request->filled('application_id')) {
            $selectedApplication = Application::find($request->application_id);
        }

        return view('calendar.create', compact('applications', 'selectedApplication'));
    }

    /**
     * Simpan jadwal baru ke database.
     */
    public function store(StoreCalendarEventRequest $request): RedirectResponse
    {
        $event = $request->user()->calendarEvents()->create($request->validated());

        return redirect()->route('calendar-events.show', $event)
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Tampilkan detail satu jadwal beserta informasi lamaran yang terkait (jika ada).
     */
    public function show(CalendarEvent $calendarEvent): View
    {
        $this->authorize('view', $calendarEvent);

        $calendarEvent->load('application:id,position_name,company_name,status_id');

        return view('calendar.show', compact('calendarEvent'));
    }

    /**
     * Tampilkan form edit jadwal yang sudah ada.
     */
    public function edit(CalendarEvent $calendarEvent): View
    {
        $this->authorize('update', $calendarEvent);

        $applications = auth()->user()
            ->applications()
            ->active()
            ->orderBy('position_name')
            ->get(['id', 'position_name', 'company_name']);

        return view('calendar.edit', compact('calendarEvent', 'applications'));
    }

    /**
     * Perbarui data jadwal yang sudah ada.
     */
    public function update(UpdateCalendarEventRequest $request, CalendarEvent $calendarEvent): RedirectResponse
    {
        $this->authorize('update', $calendarEvent);

        $calendarEvent->update($request->validated());

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Tandai jadwal sebagai selesai (completed).
     * Endpoint khusus ini memudahkan user menyelesaikan event tanpa membuka form edit.
     */
    public function complete(CalendarEvent $calendarEvent): RedirectResponse
    {
        $this->authorize('update', $calendarEvent);

        $calendarEvent->update(['is_completed' => true]);

        return back()->with('success', 'Jadwal ditandai sebagai selesai.');
    }

    /**
     * Hapus jadwal secara permanen.
     */
    public function destroy(CalendarEvent $calendarEvent): RedirectResponse
    {
        $this->authorize('delete', $calendarEvent);

        $calendarEvent->delete();

        return redirect()->route('calendar-events.index')
            ->with('success', 'Jadwal berhasil dihapus.');
    }
}
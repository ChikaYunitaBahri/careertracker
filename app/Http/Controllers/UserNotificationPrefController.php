<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserNotificationPrefRequest;
use App\Models\UserNotificationPref;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserNotificationPrefController extends Controller
{
    /**
     * Tampilkan halaman pengaturan preferensi notifikasi milik user.
     *
     * Record preferensi dibuat otomatis saat user pertama kali mendaftar
     * (via UserObserver). Method firstOrCreate digunakan sebagai fallback
     * jika karena alasan tertentu record belum ada.
     */
    public function show(Request $request): View
    {
        $prefs = $request->user()
            ->notificationPref
            ?? UserNotificationPref::firstOrCreate(
                ['user_id' => $request->user()->id]
            );

        return view('settings.notifications', compact('prefs'));
    }

    /**
     * Simpan perubahan preferensi notifikasi.
     *
     * Karena checkbox yang tidak dicentang tidak terkirim dalam form HTML,
     * semua field boolean di-cast ke false secara eksplisit jika tidak ada
     * di dalam request. Ini mencegah nilai lama tetap tersimpan.
     *
     * Penggunaan updateOrCreate memastikan record selalu ada meski
     * UserObserver gagal membuatnya saat registrasi.
     */
    public function update(UpdateUserNotificationPrefRequest $request): RedirectResponse
    {
        $booleanFields = [
            'email_enabled',
            'push_enabled',
            'interview_reminder_email',
            'interview_reminder_push',
            'idle_application_email',
            'idle_application_push',
            'goal_milestone_push',
            'weekly_summary_email',
        ];

        // Normalisasi: semua field boolean yang tidak ada di request → false
        $data = array_merge(
            array_fill_keys($booleanFields, false),
            $request->validated()
        );

        UserNotificationPref::updateOrCreate(
            ['user_id' => $request->user()->id],
            $data
        );

        return back()->with('success', 'Preferensi notifikasi berhasil disimpan.');
    }
}
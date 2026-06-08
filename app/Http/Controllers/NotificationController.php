<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NotificationController extends Controller
{
    /**
     * Tampilkan semua notifikasi milik user yang sedang login.
     *
     * Notifikasi diurutkan dari yang terbaru. Mendukung dua format:
     * - HTML view (untuk halaman notifikasi penuh)
     * - JSON (untuk dropdown notifikasi di navbar / polling AJAX)
     *
     * Jika request dari AJAX, hanya kirimkan notifikasi yang belum dibaca
     * beserta jumlah total unread agar efisien untuk polling berkala.
     */
    public function index(Request $request): View|JsonResponse
    {
        $user = $request->user();

        if ($request->expectsJson()) {
            // Untuk dropdown navbar — kirim 10 notifikasi terbaru + jumlah unread
            $notifications = $user->notifications()
                ->latest()
                ->take(10)
                ->get()
                ->map(fn($notif) => [
                    'id'         => $notif->id,
                    'type'       => class_basename($notif->type),
                    'data'       => $notif->data,
                    'read_at'    => $notif->read_at,
                    'created_at' => $notif->created_at->diffForHumans(),
                ]);

            return response()->json([
                'notifications' => $notifications,
                'unread_count'  => $user->unreadNotifications()->count(),
            ]);
        }

        // Untuk halaman penuh notifikasi — tampilkan semua dengan paginasi
        $notifications = $user->notifications()->latest()->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Tandai satu notifikasi sebagai sudah dibaca.
     * Dipanggil saat user mengklik notifikasi di dropdown atau halaman list.
     */
    public function markAsRead(Request $request, string $id): JsonResponse|RedirectResponse
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        $notification->markAsRead();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Notifikasi ditandai sudah dibaca.']);
        }

        return back()->with('success', 'Notifikasi dibaca.');
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca sekaligus.
     * Berguna untuk tombol "Tandai semua dibaca" di halaman notifikasi.
     */
    public function markAllRead(Request $request): JsonResponse|RedirectResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Semua notifikasi sudah ditandai dibaca.']);
        }

        return back()->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }

    /**
     * Hapus satu notifikasi secara permanen dari database.
     * Umumnya dipanggil via tombol "Hapus" di item notifikasi.
     */
    public function destroy(Request $request, string $id): JsonResponse|RedirectResponse
    {
        $notification = $request->user()
            ->notifications()
            ->findOrFail($id);

        $notification->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Notifikasi berhasil dihapus.']);
        }

        return back()->with('success', 'Notifikasi dihapus.');
    }

    /**
     * Hapus semua notifikasi yang sudah dibaca.
     * Digunakan untuk membersihkan notifikasi lama yang tidak relevan.
     */
    public function clearRead(Request $request): RedirectResponse
    {
        $request->user()->readNotifications()->delete();

        return back()->with('success', 'Notifikasi yang sudah dibaca berhasil dibersihkan.');
    }
}
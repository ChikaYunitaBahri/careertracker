<?php

namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ApplicationActivityController extends Controller
{
    /**
     * Tampilkan log aktivitas untuk satu lamaran tertentu.
     *
     * Activity log bersifat immutable — hanya bisa dibaca, tidak bisa diedit
     * atau dihapus secara manual. Pencatatan dilakukan otomatis oleh
     * ApplicationObserver setiap kali ada perubahan pada lamaran.
     *
     * Mendukung dua format respons:
     * - HTML view (untuk halaman detail lamaran)
     * - JSON (untuk request AJAX/SPA)
     */
    public function index(Application $application): View|JsonResponse
    {
        $this->authorize('view', $application);

        $activities = $application->activities()
            ->with('user:id,name,avatar')
            ->latest('created_at')
            ->paginate(20);

        // Jika request dari AJAX/API, kembalikan JSON
        if (request()->expectsJson()) {
            return response()->json($activities);
        }

        return view('applications.activities', compact('application', 'activities'));
    }
}
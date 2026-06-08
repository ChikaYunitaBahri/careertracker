<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationNoteRequest;
use App\Models\Application;
use App\Models\ApplicationNote;
use Illuminate\Http\RedirectResponse;

class ApplicationNoteController extends Controller
{
    /**
     * Simpan catatan baru untuk sebuah lamaran.
     * Catatan dapat berupa hasil HR interview, user interview, psikotest, atau umum.
     * user_id diisi otomatis dari sesi login agar tidak bisa dimanipulasi dari form.
     */
    public function store(StoreApplicationNoteRequest $request, Application $application): RedirectResponse
    {
        // Pastikan user hanya bisa menambah catatan ke lamaran miliknya sendiri
        $this->authorize('view', $application);

        $application->notes()->create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return back()->with('success', 'Catatan berhasil ditambahkan.');
    }

    /**
     * Perbarui isi catatan yang sudah ada.
     * Validasi ownership melalui Policy: hanya pemilik catatan yang boleh mengubah.
     */
    public function update(StoreApplicationNoteRequest $request, Application $application, ApplicationNote $note): RedirectResponse
    {
        $this->authorize('update', $note);

        // Pastikan catatan memang milik lamaran yang dimaksud (cegah ID spoofing)
        abort_if($note->application_id !== $application->id, 404);

        $note->update($request->validated());

        return back()->with('success', 'Catatan berhasil diperbarui.');
    }

    /**
     * Hapus catatan secara permanen.
     * Data interview atau kesan yang sudah dihapus tidak dapat dipulihkan.
     */
    public function destroy(Application $application, ApplicationNote $note): RedirectResponse
    {
        $this->authorize('delete', $note);

        abort_if($note->application_id !== $application->id, 404);

        $note->delete();

        return back()->with('success', 'Catatan berhasil dihapus.');
    }
}
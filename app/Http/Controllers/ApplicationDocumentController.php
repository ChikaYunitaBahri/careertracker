<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApplicationDocumentRequest;
use App\Models\Application;
use App\Models\ApplicationDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ApplicationDocumentController extends Controller
{
    /**
     * Upload dan simpan dokumen baru untuk sebuah lamaran.
     *
     * File disimpan di storage disk 'private' agar tidak dapat diakses
     * langsung via URL publik — harus melalui endpoint download yang terautentikasi.
     *
     * Tipe dokumen yang didukung: cv, cover_letter, portfolio, other.
     */
    public function store(StoreApplicationDocumentRequest $request, Application $application): RedirectResponse
    {
        $this->authorize('view', $application);

        $file = $request->file('file');

        // Simpan file ke storage dengan nama unik (timestamp + random string)
        $path = $file->store(
            "documents/{$request->user()->id}/{$application->id}",
            'private'
        );

        $application->documents()->create([
            'user_id'       => $request->user()->id,
            'document_type' => $request->validated('document_type'),
            'file_name'     => $file->getClientOriginalName(),
            'file_path'     => $path,
            'file_size'     => $file->getSize(),
            'mime_type'     => $file->getMimeType(),
        ]);

        return back()->with('success', 'Dokumen berhasil diunggah.');
    }

    /**
     * Download dokumen. Endpoint ini memvalidasi kepemilikan sebelum mengirim file,
     * sehingga file private tidak bisa diakses tanpa autentikasi.
     */
    public function download(Application $application, ApplicationDocument $document): mixed
    {
        $this->authorize('view', $application);

        abort_if($document->application_id !== $application->id, 404);

        // Pastikan file benar-benar ada di storage sebelum dikirim
        abort_unless(Storage::disk('private')->exists($document->file_path), 404);

        return Storage::disk('private')->download(
            $document->file_path,
            $document->file_name
        );
    }

    /**
     * Hapus dokumen beserta file fisiknya dari storage.
     * Jika file sudah tidak ada di disk, tetap hapus record database-nya.
     */
    public function destroy(Application $application, ApplicationDocument $document): RedirectResponse
    {
        $this->authorize('delete', $document);

        abort_if($document->application_id !== $application->id, 404);

        // Hapus file fisik dari storage (tidak error jika file tidak ditemukan)
        Storage::disk('private')->delete($document->file_path);

        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}
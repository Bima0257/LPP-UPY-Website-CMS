<?php

namespace App\Services;

use App\Models\Documents;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class DocumentDownloadService
{
    /**
     * Download normal (non-protected)
     */
    public function download(Documents $document)
    {
        if ($document->is_protected) {
            return back()
                ->with('error', 'Dokumen ini dilindungi password.')
                ->with('form_error', true);
        }

        return $this->downloadFile($document);
    }

    /**
     * Handle password verification for protected document
     */
    public function verifyPassword($request)
    {
        $key = 'verify-password:' . $request->ip();

        // Rate limit
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);

            return response()->json([
                'status' => 'error',
                'message' => "Terlalu banyak percobaan. Coba lagi dalam {$seconds} detik."
            ], 429);
        }

        $document = Documents::find($request->document_id);

        if (!$document) {
            return response()->json([
                'status' => 'error',
                'message' => 'Dokumen tidak ditemukan.'
            ], 404);
        }

        // Password check
        if (!Hash::check($request->access_password, $document->access_password)) {
            RateLimiter::hit($key, 60);

            return response()->json([
                'status' => 'error',
                'message' => 'Password salah.'
            ], 401);
        }

        // sukses → reset rate limit
        RateLimiter::clear($key);

        // Create temp token
        $token = Str::random(64);
        cache()->put('download_token_' . $token, $document->id, now()->addMinute(5));

        return response()->json([
            'status'   => 'success',
            'message'  => 'Password benar! Unduhan akan dimulai...',
            'download_url' => route('documents.downloadVerified', ['token' => $token])
        ]);
    }

    /**
     * Download via secure token
     */
    public function downloadVerified($token)
    {
        if (!$token) {
            abort(403, 'Token tidak valid.');
        }

        $documentId = cache()->pull('download_token_' . $token);

        if (!$documentId) {
            abort(403, 'Token tidak valid atau sudah kadaluarsa.');
        }

        $document = Documents::findOrFail($documentId);

        return $this->downloadFile($document);
    }

    /**
     * Private file download helper
     */
    private function downloadFile(Documents $document)
    {
        $path = storage_path('app/public/' . $document->file_path);

        if (!file_exists($path)) {
            return back()
                ->with('error', 'File tidak ditemukan.')
                ->with('form_error', true);
        }

        return response()->download(
            $path,
            $document->title . '.' . pathinfo($path, PATHINFO_EXTENSION)
        );
    }
}

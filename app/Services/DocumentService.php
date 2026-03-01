<?php

namespace App\Services;

use App\Models\Documents;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    use UploadTrait;

    /**
     * Simpan dokumen baru
     */
    public function store(array $data): Documents
    {
        // Upload file
        if (!empty($data['file_path'])) {
            $fileInfo = $this->uploadDoc($data['file_path']);
            $data = array_merge($data, $fileInfo);
        }

        // Hash password jika protected
        if (!empty($data['access_password'])) {
            $data['access_password'] = Hash::make($data['access_password']);
        }

        $data['uploaded_by'] = Auth::id();

        return Documents::create($data);
    }

    public function update(Documents $documents, array $data): Documents
    {
        // Upload file baru
        if (!empty($data['file_path'])) {

            // Hapus file lama jika ada
            if ($documents->file_path && Storage::disk('public')->exists($documents->file_path)) {
                Storage::disk('public')->delete($documents->file_path);
            }

            $fileInfo = $this->uploadDoc($data['file_path']);
            $data = array_merge($data, $fileInfo);
        }

        // Jika password baru ada → hash
        if (!empty($data['access_password'])) {
            $data['access_password'] = Hash::make($data['access_password']);
        } else {
            unset($data['access_password']); // jangan override password lama
        }

        $data['uploaded_by'] = Auth::id();

        $documents->update($data);

        return $documents;
    }

    /**
     * Hapus dokumen
     */
    public function delete(Documents $documents): bool
    {
        if ($documents->file_path && Storage::disk('public')->exists($documents->file_path)) {
            Storage::disk('public')->delete($documents->file_path);
        }

        return $documents->delete();
    }
}

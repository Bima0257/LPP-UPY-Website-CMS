<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function uploadImage($file, $folder)
    {
        $filename = uniqid($folder . '_') . '.' . $file->getClientOriginalExtension();
        return $file->storeAs($folder, $filename, 'public');
    }

    public function uploadDoc($file, $oldFilePath = null)
    {
        // Jika tidak ada file upload, return null
        if (!$file) {
            return null;
        }

        // Hapus file lama jika ada
        if ($oldFilePath && Storage::disk('public')->exists($oldFilePath)) {
            Storage::disk('public')->delete($oldFilePath);
        }

        // Generate nama baru
        $filename = time() . '_' . $file->getClientOriginalName();

        // Simpan ke storage/app/public/documents
        $path = $file->storeAs('documents', $filename, 'public');

        // Return detail file
        return [
            'file_path'      => $path,
            'file_mime'      => $file->getClientMimeType(),
            'file_extension' => $file->getClientOriginalExtension(),
            'file_size'      => $file->getSize(),
        ];
    }
}

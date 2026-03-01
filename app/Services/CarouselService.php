<?php

namespace App\Services;

use App\Models\Carousels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;

class CarouselService
{
    /** Upload gambar carousel */
    public function uploadFoto(?UploadedFile $file): ?string
    {
        if (!$file) {
            return null;
        }

        $filename = uniqid('carousel_') . '.' . $file->getClientOriginalExtension();
        return $file->storeAs('carousels', $filename, 'public');
    }


    /** Store Carousel */
    public function store(array $data): Carousels
    {
        $imagePath = $this->uploadFoto($data['image'] ?? null);

        return Carousels::create([
            'title'          => $data['title'],
            'description'    => $data['description'] ?? null,
            'btn_link'       => $data['btn_link'] ?? null,
            'image'          => $imagePath,
            'is_published'   => $data['is_published'],
            'author_id'      => Auth::id(),
        ]);
    }

    /** Update Carousel */
    public function update(Carousels $carousel, array $data): Carousels
    {
        $newImagePath = $this->uploadFoto($data['image'] ?? null);

        // Hapus gambar lama bila ada upload baru
        if ($newImagePath && $carousel->image) {
            Storage::disk('public')->delete($carousel->image);
        }

        $carousel->update([
            'title'          => $data['title'],
            'description'    => $data['description'] ?? null,
            'btn_link'       => $data['btn_link'] ?? null,
            'image'          => $newImagePath ? $newImagePath : $carousel->image,
            'is_published'   => $data['is_published'],
        ]);

        return $carousel;
    }

    /** Delete Carousel */
    public function delete(Carousels $carousel): bool
    {
        if ($carousel->image && Storage::disk('public')->exists($carousel->image)) {
            Storage::disk('public')->delete($carousel->image);
        }

        return $carousel->delete();
    }
}

<?php

namespace App\Services;

use App\Models\Carousels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        return DB::transaction(function () use ($data) {

            $imagePath = $this->uploadFoto($data['image'] ?? null);

            $lastOrder = Carousels::lockForUpdate()->max('sort_order') ?? 0;

            return Carousels::create([
                'title'          => $data['title'],
                'description'    => $data['description'] ?? null,
                'btn_link'       => $data['btn_link'] ?? null,
                'image'          => $imagePath,
                'sort_order'     => $lastOrder + 1,
                'is_published'   => $data['is_published'],
                'author_id'      => Auth::id(),
            ]);
        });
    }

    /** Update Carousel */
    public function update(Carousels $carousel, array $data): Carousels
    {
        $newImagePath = $this->uploadFoto($data['image'] ?? null);

        if ($newImagePath && $carousel->image) {
            Storage::disk('public')->delete($carousel->image);
        }

        $carousel->update([
            'title'          => $data['title'],
            'description'    => $data['description'] ?? null,
            'btn_link'       => $data['btn_link'] ?? null,
            'image'          => $newImagePath ?? $carousel->image,
            'is_published'   => $data['is_published'],
        ]);

        return $carousel;
    }

    /** Delete Carousel */
    public function delete(Carousels $carousel): bool
    {
        return DB::transaction(function () use ($carousel) {

            $deletedOrder = $carousel->sort_order;

            if ($carousel->image && Storage::disk('public')->exists($carousel->image)) {
                Storage::disk('public')->delete($carousel->image);
            }

            $carousel->delete();

            // rapihin urutan
            Carousels::where('sort_order', '>', $deletedOrder)
                ->decrement('sort_order');

            return true;
        });
    }

    public function updateOrder(array $orders): bool
    {
        return DB::transaction(function () use ($orders) {

            foreach ($orders as $index => $id) {
                Carousels::where('id', $id)
                    ->update(['sort_order' => $index + 1]);
            }

            return true;
        });
    }
}

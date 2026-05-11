<?php

namespace App\Services;

use App\Models\Posts;
use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class PostService
{
    use UploadTrait;

    public function store(array $data): Posts
    {
        // Upload thumbnail jika ada
        if (!empty($data['thumbnail'])) {
            // Karena uploadImage hanya mengembalikan path (string), bukan array
            $thumbnailPath = $this->uploadImage($data['thumbnail'], 'thumbnails');
            $data['thumbnail'] = $thumbnailPath;
        }

        // Upload image utama jika ada
        if (!empty($data['image'])) {
            $imagePath = $this->uploadImage($data['image'], 'images');
            $data['image'] = $imagePath;
        }

        $data['author_id'] = Auth::id();

        return Posts::create($data);
    }

    public function update(Posts $post, array $data): Posts
    {
        // Update thumbnail
        if (!empty($data['thumbnail'])) {

            // Hapus file lama
            if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
                Storage::disk('public')->delete($post->thumbnail);
            }

            $path = $this->uploadImage($data['thumbnail'], 'thumbnails');
            $data['thumbnail'] = $path;
        }

        // Update image
        if (!empty($data['image'])) {

            // Hapus file lama
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }

            $path = $this->uploadImage($data['image'], 'images');
            $data['image'] = $path;
        }

        $post->update($data);
        return $post;
    }

    public function delete(Posts $post): bool
    {
        // Hapus thumbnail
        if ($post->thumbnail && Storage::disk('public')->exists($post->thumbnail)) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        // Hapus image
        if ($post->image && Storage::disk('public')->exists($post->image)) {
            Storage::disk('public')->delete($post->image);
        }

        return $post->delete();
    }
}

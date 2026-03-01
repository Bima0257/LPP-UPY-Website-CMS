<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;


class BannerController extends Controller
{
    public function index()
    {
        $title = 'Banner Setting';
        $banner = Banner::first();
        
        if (!$banner) {
            $banner = Banner::create([
                'banner_background' => null,
                'footer_background' => null
            ]);
        }
        return view('admin.banner.index', compact('title', 'banner'));
    }

    public function edit($id)
    {
        $banner = Banner::findOrFail($id);
        Cache::forget('banner');
        Cache::forget('banner_footer');
        return response()->json($banner);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'banner_background' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1000',
            'footer_background' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1000',
        ]);

        // Upload banner_background dan hapus yang lama
        if ($request->hasFile('banner_background')) {
            // Hapus file lama jika ada
            if ($banner->banner_background && Storage::disk('public')->exists($banner->banner_background)) {
                Storage::disk('public')->delete($banner->banner_background);
            }

            // Upload file baru
            $validated['banner_background'] = $request->file('banner_background')->store('banners', 'public');
        }

        // Upload footer_background dan hapus yang lama
        if ($request->hasFile('footer_background')) {
            // Hapus file lama jika ada
            if ($banner->footer_background && Storage::disk('public')->exists($banner->footer_background)) {
                Storage::disk('public')->delete($banner->footer_background);
            }

            // Upload file baru
            $validated['footer_background'] = $request->file('footer_background')->store('banners', 'public');
        }

        $banner->update($validated);

        Cache::forget('banner');
        Cache::forget('banner_footer');

        return redirect()->route('banner.index')
            ->with('success', 'Banner berhasil diperbarui!');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Abouts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class AboutsController extends Controller
{
    public function index()
    {
        // Ambil data pertama
        $about = Abouts::first();

        // Jika belum ada, buat data dummy
        if (!$about) {
            $about = Abouts::create([
                'name' => 'Nama Organisasi',
                'description' => 'Deskripsi singkat tentang organisasi Anda.',
                'vision' => 'Menjadi organisasi yang unggul dan berdaya saing.',
                'mission' => '1. Memberikan layanan terbaik kepada masyarakat. 
                          2. Meningkatkan profesionalisme dan integritas.',
                'purpose' => 'Memberikan manfaat bagi masyarakat luas.',
                'address' => 'Jl. Contoh No. 123, Kota Contoh, Indonesia',
                'email' => 'info@organisasi.com',
                'phone' => '+62 812 3456 7890',
                'youtube_link' => 'https://youtube.com/',
                'instagram_link' => 'https://instagram.com/',
            ]);
        }

        // Tampilkan view
        return view('admin.abouts.index', [
            'title' => 'About Setting',
            'about' => $about
        ]);
    }


    public function update(Request $request, $id)
    {
        // 1️⃣ Cari data yang akan diupdate
        $about = Abouts::findOrFail($id);

        // 2️⃣ Validasi input
        $validator = Validator::make($request->all(), [
            'name'        => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'vision'      => 'nullable|string',
            'mission'     => 'nullable|string',
            'purpose'     => 'nullable|string',
            'thumbnail'   => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'favicon'  => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'white_logo'  => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'black_logo'  => 'nullable|image|mimes:jpeg,png,jpg|max:5000',
            'address'     => 'nullable|string',
            'email'       => 'nullable|email|max:150',
            'instagram_link'       => 'nullable|string|max:255',
            'youtube_link'       => 'nullable|string|max:255',
            'phone'       => 'nullable|string|max:50',
        ]);

        // 3️⃣ Jika validasi gagal
        if ($validator->fails()) {
            // Simpan file sementara jika ada
            foreach (['thumbnail', 'image', 'favicon', 'white_logo', 'black_logo'] as $field) {
                if ($request->hasFile($field)) {
                    $tempPath = $request->file($field)->store('temp');
                    session(["about_temp_{$field}" => $tempPath]);
                }
            }

            $errorMessages = implode('<br>', $validator->errors()->all());

            return back()
                ->withErrors($validator)
                ->withInput($request->except(['thumbnail', 'image', 'favicon', 'white_logo', 'black_logo']))
                ->with('error', $errorMessages)
                ->with('form_error', true);
        }

        // 4️⃣ Ambil data tervalidasi
        $validatedData = $validator->validated();

        // 5️⃣ Proses upload file (hapus lama jika ada)
        foreach (['thumbnail', 'image', 'favicon', 'white_logo', 'black_logo'] as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama jika ada
                if ($about->$field && Storage::exists($about->$field)) {
                    Storage::delete($about->$field);
                }

                // Upload file baru
                $validatedData[$field] = $request->file($field)->store('abouts');
            }
        }

        // 6️⃣ Update data
        $about->update($validatedData);

        Cache::forget('about_layout');
        Cache::forget('about_favicon');
        Cache::forget('about_logo');
        Cache::forget('about_footer');
        Cache::forget('about_navbar');
        Cache::forget('about');

        // 7️⃣ Redirect sukses
        return redirect()->route('about.index')
            ->with('success', 'Profil organisasi berhasil diperbarui!');
    }
}

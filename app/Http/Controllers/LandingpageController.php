<?php

namespace App\Http\Controllers;

use App\Models\Abouts;
use App\Models\Carousels;
use App\Models\Documents;
use App\Models\Member;
use App\Models\Posts;
use App\Models\Service;
use App\Models\WorkProgram;
use Illuminate\Support\Facades\Cache;

class LandingpageController extends Controller
{
    public function index()
    {
        $icons = [
            'pdf' => 'mdi-pdf-box',
            'doc' => 'mdi-microsoft-word',
            'docx' => 'mdi-microsoft-word',
            'xls' => 'mdi-microsoft-excel',
            'xlsx' => 'mdi-microsoft-excel',
            'ppt' => 'mdi-microsoft-powerpoint',
            'pptx' => 'mdi-microsoft-powerpoint',
            'txt' => 'mdi-file-document',
            'default' => 'mdi-file-document',
        ];

        $title = 'Home';

        $carousels = Cache::remember('carousels', 60 * 60, function () {
            return Carousels::where('is_published', 1)->get();
        });

        $about = Cache::remember('about', 60 * 60, function () {
            return Abouts::first();
        });

        $posts = Cache::remember('latest_posts', 60 * 60, function () {
            return Posts::with('author', 'category')
                ->where('is_published', 1)
                ->latest()
                ->take(8)
                ->get();
        });
        


        $documents = Cache::remember('latest_documents', 60 * 60, function () {
            return Documents::with('category')->where('is_published', 1)->latest()->take(4)->get();
        });

        $members = Cache::remember('members', 60 * 60, function () {
            return Member::take(4)->orderBy('sort_order', 'asc')->get();
        });

        $services = Cache::remember('services', 60 * 60, function () {
            return Service::take(6)->latest()->get();
        });

        // Tambahkan property icon_class ke setiap document
        $documents->map(function ($doc) use ($icons) {
            $ext = strtolower($doc->file_extension);
            $doc->icon_class = $icons[$ext] ?? $icons['default'];
            return $doc;
        });

        return view('index', compact('services', 'members', 'posts', 'carousels', 'about', 'documents', 'title'));
    }


    public function abouts()
    {
        $about = Abouts::first();
        $title = 'Tentang LPP';
        return view('landingpage.abouts-all', compact('title', 'about'));
    }

    public function visiMisi()
    {
        $about = Abouts::select('name', 'vision', 'mission', 'purpose', 'image')->first();
        $title = 'Visi-Misi & Tujuan';
        return view('landingpage.visi-misi', compact('about', 'title'));
    }

    public function teams()
    {
        $members = Member::orderBy('sort_order', 'asc')->get();
        $title = 'Struktur Organisasi';
        return view('landingpage.teams', compact('title', 'members'));
    }


    // Timeline - work-programs 
    public function timeline()
    {
        // Ambil semua program kerja, urutkan dari terbaru ke terlama
        $programs = WorkProgram::where('is_published', 1)->orderBy('tgl_pelaksanaan', 'desc')->get();

        return view('landingpage.work-programs', [
            'title' => 'Program Kerja',
            'programs' => $programs
        ]);
    }

    // Timeline - work-programs End


}

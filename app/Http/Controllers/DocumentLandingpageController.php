<?php

namespace App\Http\Controllers;

use App\Models\DocumentCategories;
use App\Models\Documents;
use App\Services\DocumentDownloadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DocumentLandingpageController extends Controller
{

    // Document 
    public function documents(Request $request)
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

        $query = Documents::with(['category', 'author'])
            ->where('is_published', 1)
            ->search($request->search);

        // ✅ Deteksi mobile dari User-Agent
        $userAgent = $request->header('User-Agent');
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);

        $perPage = $isMobile ? 4 : 8;
        $cacheKey = 'documents_'
            . md5($request->input('search') . '_page_' . $request->input('page') . '_perPage_' . $perPage);

        $all_document = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($query, $perPage) {
            return $query->latest()->paginate($perPage)->withQueryString();
        });


        $title = 'Semua Dokumen';

        $all_document->map(function ($doc) use ($icons) {
            $ext = strtolower($doc->file_extension);
            $doc->icon_class = $icons[$ext] ?? $icons['default'];
            return $doc;
        });

        return view('landingpage.all-document', compact('all_document', 'title'));
    }

    public function categoryDocumentAll()
    {
        $categories = DocumentCategories::where('is_published', 1)->get();
        $title =  'Semua Kategori';
        return view('landingpage.all-document-categories', compact('categories', 'title'));
    }

    public function documentSuggestions(Request $request, $slug = null)
    {
        $query = $request->get('q', '');
        $results = [];

        if (strlen($query) > 1) {
            $documents = Documents::where('is_published', 1);

            if ($slug) {
                // Hanya filter jika di halaman kategori tertentu
                $documents->whereHas('category', function ($q) use ($slug) {
                    $q->where('slug', $slug);
                });
            }

            $documents->search($query);

            $results = $documents
                ->select('id', 'title', 'created_at')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($doc) {
                    return [
                        'id' => $doc->id,
                        'title' => $doc->title,
                        'created_at' => $doc->created_at->format('d M Y'),
                    ];
                });
        }

        return response()->json($results);
    }

    public function documentCategory(Request $request, $slug)
    {
        // Mapping ekstensi → icon MDI
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

        $category = DocumentCategories::where('slug', $slug)->firstOrFail();

        // Query dokumen berdasarkan kategori + publish only
        $query = $category->documents()->where('is_published', 1);

        // 🔍 Search reusable dari Trait Searchable
        $query->search($request->search);

        // ✅ Deteksi mobile dari User-Agent
        $userAgent = $request->header('User-Agent');
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);

        $perPage = $isMobile ? 4 : 8;

        $cacheKey = 'documents_category_' . $slug . '_' .
            md5($request->input('search') . '_page_' . $request->input('page') . '_perPage_' . $perPage);

        $all_document = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($query, $perPage) {
            return $query->latest()->paginate($perPage)->withQueryString();
        });

        $title = 'Kategori | ' . $category->name;

        // Tambahkan property icon_class
        $all_document->map(function ($doc) use ($icons) {
            $ext = strtolower($doc->file_extension);
            $doc->icon_class = $icons[$ext] ?? $icons['default'];
            return $doc;
        });

        return view('landingpage.all-document', compact('title', 'category', 'all_document'));
    }

    // Document End

    // Document Download
    public function download($id, DocumentDownloadService $service)
    {
        $document = Documents::findOrFail($id);
        return $service->download($document);
    }

    public function verifyPassword(Request $request, DocumentDownloadService $service)
    {
        return $service->verifyPassword($request);
    }

    public function downloadVerified(Request $request, DocumentDownloadService $service)
    {
        return $service->downloadVerified($request->query('token'));
    }

    // Document Download End
}

<?php

namespace App\Http\Controllers;

use App\Models\Carousels;
use App\Models\DocumentCategories;
use App\Models\Documents;
use App\Models\Member;
use App\Models\Message;
use App\Models\PostCategories;
use App\Models\Posts;
use App\Models\WorkProgram;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard';

        // 🔥 Carousel Stats (1 query + cache)
        $carouselStats = Cache::remember('dashboard.carousel', 60, function () {
            return Carousels::selectRaw("
                COUNT(*) as total,
                SUM(is_published = 1) as published
            ")->first();
        });

        // 🔥 Post Stats
        $postStats = Cache::remember('dashboard.posts', 60, function () {
            return Posts::selectRaw("
                COUNT(*) as total,
                SUM(is_published = 1) as published
            ")->first();
        });

        // 🔥 Document Stats
        $documentStats = Cache::remember('dashboard.documents', 60, function () {
            return Documents::selectRaw("
                COUNT(*) as total,
                SUM(is_published = 1) as published
            ")->first();
        });

        // 🔥 Message Stats
        $messageStats = Cache::remember('dashboard.messages', 60, function () {
            return Message::selectRaw("
                COUNT(*) as total,
                SUM(is_read = 0) as notRead
            ")->first();
        });

        // 🔥 Simple Count (pakai cache juga)
        $memberTotal = Cache::remember('dashboard.members', 60, function () {
            return Member::count();
        });

        $prokerTotal = Cache::remember('dashboard.prokers', 60, function () {
            return WorkProgram::count();
        });

        // 🔥 Category Data (Documents)
        $documentCategoryData = Cache::remember('dashboard.doc_categories', 60, function () {
            return $this->prepareCategoryData(DocumentCategories::class, 'documents', Documents::class, 'category_id');
        });

        // 🔥 Category Data (Posts)
        $postCategoryData = Cache::remember('dashboard.post_categories', 60, function () {
            return $this->prepareCategoryData(PostCategories::class, 'posts', Posts::class, 'post_category_id');
        });

        return view('admin.index', compact(
            'title',
            'carouselStats',
            'postStats',
            'documentStats',
            'messageStats',
            'memberTotal',
            'prokerTotal',
            'documentCategoryData',
            'postCategoryData'
        ));
    }

    /**
     * Helper untuk category chart
     */
    private function prepareCategoryData($modelClass, $relation, $itemModel, $foreignKey = 'category_id')
    {
        // Data per kategori
        $data = $modelClass::withCount($relation)->get();

        // Hitung item yang tidak punya kategori
        $uncategorized = $itemModel::whereNull($foreignKey)->count();

        $categories = $data->pluck('name');
        $totals = $data->pluck($relation . '_count');

        // Tambahkan "Tanpa Kategori" jika ada
        if ($uncategorized > 0) {
            $categories->push('Tanpa Kategori');
            $totals->push($uncategorized);
        }

        if ($categories->isEmpty()) {
            return [
                'categories' => collect(['Belum Ada Data']),
                'totals'     => collect([0]),
            ];
        }

        return [
            'categories' => $categories,
            'totals'     => $totals,
        ];
    }
}

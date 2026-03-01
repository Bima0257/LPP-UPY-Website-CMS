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

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik umum
        $carouselStats = [
            'total'     => Carousels::count(),
            'published' => Carousels::where('is_published', 1)->count(),
        ];

        $postStats = [
            'total'     => Posts::count(),
            'published' => Posts::where('is_published', 1)->count(),
        ];

        $documentStats = [
            'total'     => Documents::count(),
            'published' => Documents::where('is_published', 1)->count(),
        ];

        $messageStats = [
            'total'   => Message::count(),
            'notRead' => Message::where('is_read', 0)->count(),
        ];

        $memberTotal = Member::count();
        $prokerTotal = WorkProgram::count();

        $prepareCategoryData = function ($modelClass, $relationCountName) {
            $data = $modelClass::withCount($relationCountName)->get();

            $categories = $data->isEmpty()
                ? collect(['Belum Ada Data'])
                : $data->pluck('name');

            $totals = $data->isEmpty()
                ? collect([0])
                : $data->pluck($relationCountName . '_count');

            return [
                'categories' => $categories,
                'totals' => $totals,
            ];
        };

        $documentCategoryData = $prepareCategoryData(DocumentCategories::class, 'documents');
        $postCategoryData     = $prepareCategoryData(PostCategories::class, 'posts');

        $documentCategories = $documentCategoryData['categories'];
        $totalDocuments     = $documentCategoryData['totals'];

        $postCategories = $postCategoryData['categories'];
        $totalPosts     = $postCategoryData['totals'];

        $title = 'Dashboard';

        return view('admin.index', compact(
            'title',
            'messageStats',
            'documentStats',
            'postStats',
            'prokerTotal',
            'memberTotal',
            'carouselStats',
            'documentCategories',
            'totalDocuments',
            'postCategories',
            'totalPosts',
            'documentCategoryData',
            'postCategoryData'
        ));
    }
}

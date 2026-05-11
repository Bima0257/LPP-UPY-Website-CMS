<?php

namespace App\Http\Controllers;

use App\Models\PostCategories;
use App\Models\Posts;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostLandingpageController extends Controller
{

    // Post 

    public function posts(Request $request)
    {
        $query = Posts::with('category', 'author')->where('is_published', 1);
        $categories = PostCategories::where('is_published', 1)
            ->orderBy('sort_order')
            ->get();

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 📅 FILTER DATE RANGE
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('date', [
                $request->date_from,
                $request->date_to
            ]);
        } elseif ($request->filled('date_from')) {
            $query->whereDate('date', '>=', $request->date_from);
        } elseif ($request->filled('date_to')) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        $sort = $request->get('sort', 'desc');
        $sort = in_array($sort, ['asc', 'desc']) ? $sort : 'desc';

        $query->orderBy('date', $sort);


        $userAgent = $request->header('User-Agent');
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);

        $perPage = $isMobile ? 2 : 6;
        // Generate Cache Key based on pagination & search query
        $page = $request->get('page', 1);
        $search = $request->get('search', '');
        $category = $request->get('category', '');
        $dateFrom = $request->get('date_from', '');
        $dateTo   = $request->get('date_to', '');

        $cacheKey = "posts_page_{$page}_per_{$perPage}_search_{$search}_cat_{$category}_sort_{$sort}_date_from_{$dateFrom}_date_to_{$dateTo}";

        // Cache the query for 10 minutes
        $all_posts = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($query, $perPage) {
            return $query->paginate($perPage)->withQueryString();
        });


        $title = 'Semua Artikel';
        return view('landingpage.all-post', compact('all_posts', 'title', 'categories'));
    }

    public function categoryPostAll()
    {
        $categories = Cache::remember('lp_categories_all', 3600, function () {
            return PostCategories::withCount('posts')->where('is_published', 1)->get();
        });

        $title =  'Semua Kategori';
        return view('landingpage.all-post-categories', compact('categories', 'title'));
    }

    public function category(Request $request, $slug)
    {
        $category = PostCategories::where('slug', $slug)->firstOrFail();
        // 🔍 Query dokumen khusus kategori ini
        $query = $category->posts()->where('is_published', 1);

        // 🔍 Jika ada search → trait yg handle
        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        // ✅ Deteksi mobile dari User-Agent
        $userAgent = $request->header('User-Agent');
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);

        // ✅ Set jumlah per page: Desktop = 6, Mobile = 2
        $perPage = $isMobile ? 2 : 6;
        $page = $request->get('page', 1);
        $search = $request->get('search', '');

        $cacheKey = "lp_posts_cat_{$slug}_page_{$page}_per_{$perPage}_search_{$search}";

        $all_posts = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($query, $perPage) {
            return $query->latest('date')->paginate($perPage)->withQueryString();
        });
        $title = 'Kategori | ' . $category->name;

        return view('landingpage.all-post', compact('title', 'category', 'all_posts'));
    }

    public function postSuggestions(Request $request, $slug = null)
    {
        $query       = trim($request->get('q', ''));
        $authorName  = $request->get('author');

        // Early return kalau input terlalu pendek
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $posts = Posts::query()
            ->where('is_published', 1)
            ->when($slug, function ($q) use ($slug) {
                $q->whereHas('category', fn($c) => $c->where('slug', $slug));
            })
            ->when($authorName, function ($q) use ($authorName) {
                $q->whereHas('author', fn($a) => $a->where('name', $authorName));
            })
            ->where(function ($qBuilder) use ($query) {
                $qBuilder->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->orWhere('date', 'LIKE', "%{$query}%");
            })
            ->select('id', 'title', 'date')
            ->orderBy('date', 'desc')
            ->limit(5)
            ->get()
            ->map(fn($post) => [
                'id'         => $post->id,
                'title'      => $post->title,
                'date' => $post->date ? \Carbon\Carbon::parse($post->date)->format('d M Y') : null,
            ]);

        return response()->json($posts);
    }


    public function byAuthor(Request $request, User $author)
    {
        $title = "Artikel by - " . $author->name;
        // 🔹 Query builder awal: semua post author yang dipublish
        $query = Posts::where('author_id', $author->id)
            ->where('is_published', 1);

        // 🔍 Jika ada search → trait yg handle
        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        // ✅ Deteksi mobile dari User-Agent
        $userAgent = $request->header('User-Agent');
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);

        // ✅ Set jumlah per page: Desktop = 6, Mobile = 2
        $perPage = $isMobile ? 2 : 6;
        $page = $request->get('page', 1);
        $search = $request->get('search', '');

        $cacheKey = "lp_posts_author_{$author->id}_page_{$page}_per_{$perPage}_search_{$search}";

        $all_posts = Cache::remember($cacheKey, 600, function () use ($query, $perPage) {
            return $query->latest('date')->paginate($perPage)->withQueryString();
        });

        return view('landingpage.all-post', compact('title', 'all_posts', 'author'));
    }

    public function byCategory(Request $request, PostCategories $category)
    {
        $title = "Artikel | " . $category->name;

        // 🔹 Query builder awal: semua post di kategori ini yang dipublish
        $query = Posts::where('post_category_id', $category->id)
            ->where('is_published', 1);

        // 🔍 Jika ada search → trait yg handle
        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        // ✅ Deteksi mobile dari User-Agent
        $userAgent = $request->header('User-Agent');
        $isMobile = preg_match('/Mobile|Android|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i', $userAgent);

        // ✅ Set jumlah per page: Desktop = 6, Mobile = 2
        $perPage = $isMobile ? 2 : 6;
        $page = $request->get('page', 1);
        $search = $request->get('search', '');

        $cacheKey = "lp_posts_catid_{$category->id}_page_{$page}_per_{$perPage}_search_{$search}";

        $all_posts = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($query, $perPage) {
            return $query->latest('date')->paginate($perPage)->withQueryString();
        });

        return view('landingpage.all-post', compact('title', 'all_posts', 'category'));
    }


    public function show($slug)
    {
        $post = Posts::with('author', 'category')->where('slug', $slug)->where('is_published', 1)->firstOrFail();
        $title = $post->title;
        $categories = PostCategories::take(3)->orderBy('sort_order', 'asc')->get();

        $popularPosts = Posts::inRandomOrder()
            ->take(4)
            ->get();


        $relatedPosts = Posts::where('id', '!=', $post->id)
            ->where('post_category_id', $post->post_category_id)
            ->latest('date')
            ->take(3)
            ->get();

        return view('landingpage.post-detail', compact('popularPosts', 'categories', 'title', 'post', 'relatedPosts'));
    }

    // post end

}

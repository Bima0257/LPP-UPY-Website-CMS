<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\PostCategories;
use App\Models\Posts;
use App\Models\User;
use App\Services\PostService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{

    protected $service;

    public function __construct(PostService $service)
    {
        $this->service = $service;
    }

    private function clearPostCache()
    {
        // Cache kategori
        Cache::forget('lp_categories_all');

        // Cache popular post
        Cache::forget('popular_posts');

        // ❗ Clear kemungkinan key utama (pakai looping kecil)
        for ($page = 1; $page <= 5; $page++) {
            foreach ([2, 6] as $perPage) {
                Cache::forget("posts_page_{$page}_per_{$perPage}_search_");

                // category slug tidak diketahui → skip wildcard
            }
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'superadmin') {

            $cacheKey = 'admin_posts_superadmin';

            $posts = Cache::remember($cacheKey, now()->addMinutes(10), function () {
                return Posts::latest('date')->get();
            });
        } else {

            $cacheKey = 'admin_posts_user_' . $user->id;

            $posts = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($user) {
                return Posts::where('author_id', $user->id)->latest('date')->get();
            });
        }

        return view('admin.posts.index', [
            'title' => 'Post',
            'posts' => $posts
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $categories = Cache::remember('post_categories', now()->addMinutes(10), function () {
            return PostCategories::all();
        });

        return view('admin.posts.create', [
            'title' => 'Create Post',
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostStoreRequest $request)
    {

        $this->service->store($request->validated());

        Cache::forget('latest_posts');
        Cache::forget('all_posts');
        Cache::forget('admin_posts_superadmin');
        Cache::forget('dashboard.posts');
        $this->clearPostCache();

        foreach (User::pluck('id') as $id) {
            Cache::forget('admin_posts_user_' . $id);
        }

        return redirect()->route('posts-management.index')
            ->with('success', 'Post baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Posts $posts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Posts $posts)
    {
        $categories = Cache::remember('post_categories', now()->addMinutes(10), function () {
            return PostCategories::all();
        });

        return view('admin.posts.edit', [
            'title' => 'Edit Post',
            'post' => $posts,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Posts $posts)
    {
        $this->service->update($posts, $request->validated());

        Cache::forget('latest_posts');
        Cache::forget('all_posts');
        Cache::forget('admin_posts_superadmin');
        Cache::forget('dashboard.posts');
        $this->clearPostCache();

        foreach (\App\Models\User::pluck('id') as $id) {
            Cache::forget('admin_posts_user_' . $id);
        }

        return redirect()->route('posts-management.index')
            ->with('success', 'Post berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Posts $posts)
    {
        $this->service->delete($posts);

        Cache::forget('latest_posts');
        Cache::forget('all_posts');
        Cache::forget('admin_posts_superadmin');
        Cache::forget('dashboard.posts');
        $this->clearPostCache();

        foreach (User::pluck('id') as $id) {
            Cache::forget('admin_posts_user_' . $id);
        }


        return redirect()->route('posts-management.index')
            ->with('success', 'Post telah dihapus!');
    }
}

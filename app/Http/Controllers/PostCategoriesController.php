<?php

namespace App\Http\Controllers;

use App\Models\PostCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class PostCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.posts.categories', [
            'title' => 'Post Categories',
            'categories' => PostCategories::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150|unique:post_categories,name',
            'is_published' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            $errorMessages = implode('<br>', $validator->errors()->all());
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessages)
                ->with('form_error', true);
        }

        $lastOrder = PostCategories::max('sort_order') ?? 0;

        PostCategories::create([
            'name' => $request->name,
            'sort_order' => $lastOrder + 1,
            'is_published' => $request->is_published,
        ]);

        Cache::forget('post_categories_footer');
        Cache::forget('post_categories');
        Cache::forget('lp_categories_all');


        // 6️⃣ Redirect sukses
        return redirect()->route('posts-categories.index')
            ->with('success', 'Kategori Post berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PostCategories $postCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PostCategories $postCategories)
    {
        return response()->json($postCategories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PostCategories $postCategories)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150|unique:post_categories,name,' . $postCategories->id,
            'is_published' => 'required|boolean',

        ]);

        if ($validator->fails()) {
            $errorMessages = implode('<br>', $validator->errors()->all());
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessages)
                ->with('form_error', true);
        }

        $postCategories->update([
            'name' => $request->name,
            'is_published' => $request->is_published
        ]);

        Cache::forget('post_categories_footer');
        Cache::forget('post_categories');
        Cache::forget('lp_categories_all');

        return redirect()->route('posts-categories.index')
            ->with('success', 'Kategori Post berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PostCategories $postCategories)
    {
        $postCategories->delete();

        $categories = PostCategories::orderBy('sort_order')->get();
        foreach ($categories as $index => $category) {
            $category->update(['sort_order' => $index + 1]);
        }

        Cache::forget('post_categories_footer');
        Cache::forget('post_categories');
        Cache::forget('lp_categories_all');

        return redirect('/posts-categories')->with('success', 'Kategori Post Telah Di hapus!');
    }

    public function updateOrder(Request $request)
    {
        foreach ($request->order as $index => $id) {
            PostCategories::where('id', $id)->update(['sort_order' => $index + 1]);
        }

        Cache::forget('post_categories_footer');
        Cache::forget('post_categories');
        Cache::forget('lp_categories_all');

        return response()->json(['success' => true]);
    }
}

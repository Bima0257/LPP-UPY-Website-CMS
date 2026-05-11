<?php

namespace App\Http\Controllers;

use App\Models\DocumentCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class DocumentCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.documents.categories', [
            'title' => 'Document Categories',
            'categories' => DocumentCategories::orderBy('sort_order')->get()
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
            'name' => 'required|string|max:150|unique:document_categories,name',
            'description' => 'nullable|string|max:5000',
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

        DB::transaction(function () use ($request) {

            $lastOrder = DocumentCategories::lockForUpdate()->max('sort_order') ?? 0;

            DocumentCategories::create([
                'name' => $request->name,
                'description' => $request->description,
                'sort_order' => $lastOrder + 1,
                'is_published' => $request->is_published,
            ]);
        });

        Cache::forget('document_categories');
        Cache::forget('document_categories_footer');
        Cache::forget('dashboard.doc_categories');

        // 6️⃣ Redirect sukses
        return redirect()->route('documents-categories.index')
            ->with('success', 'Kategori dokumen berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentCategories $documentCategories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentCategories $documentCategories)
    {
        return response()->json($documentCategories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentCategories $documentCategories)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150|unique:document_categories,name,' . $documentCategories->id,
            'description' => 'nullable|string|max:5000',
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

        $documentCategories->update($validator->validated());
        Cache::forget('document_categories');
        Cache::forget('document_categories_footer');
        Cache::forget('dashboard.doc_categories');

        return redirect()->route('documents-categories.index')
            ->with('success', 'Kategori dokumen berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentCategories $documentCategories)
    {
        $deletedOrder = $documentCategories->sort_order;

        $documentCategories->delete();

        DocumentCategories::where('sort_order', '>', $deletedOrder)
            ->decrement('sort_order');

        Cache::forget('document_categories');
        Cache::forget('document_categories_footer');
        Cache::forget('dashboard.doc_categories');

        return redirect('/documents-categories')->with('success', 'Kategori Dokumen Telah Di hapus!');
    }

    public function updateOrder(Request $request)
    {
        DB::transaction(function () use ($request) {
            foreach ($request->order as $index => $id) {
                DocumentCategories::where('id', $id)
                    ->update(['sort_order' => $index + 1]);
            }
        });

        Cache::forget('document_categories');
        Cache::forget('document_categories_footer');
        Cache::forget('dashboard.doc_categories');

        return response()->json(['success' => true]);
    }
}

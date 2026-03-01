<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentStoreRequest;
use App\Http\Requests\DocumentUpdateRequest;
use App\Models\DocumentCategories;
use App\Models\Documents;
use App\Services\DocumentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        // Cache categories (karena selalu dipakai di halaman ini)
        $categories = Cache::remember('admin_document_categories', now()->addMinutes(10), function () {
            return DocumentCategories::all();
        });

        if ($user->role === 'superadmin') {

            $cacheKey = 'admin_documents_superadmin';

            $documents = Cache::remember($cacheKey, now()->addMinutes(10), function () {
                return Documents::all();
            });
        } else {

            $cacheKey = 'admin_documents_user_' . $user->id;

            $documents = Cache::remember($cacheKey, now()->addMinutes(10), function () use ($user) {
                return Documents::where('uploaded_by', $user->id)->get();
            });
        }

        return view('admin.documents.index', [
            'title' => 'Document Management',
            'categories' => $categories,
            'documents' => $documents
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
    public function store(DocumentStoreRequest $request, DocumentService $service)
    {

        $service->store($request->validated());

        Cache::forget('latest_documents');
        Cache::tags(['documents'])->flush();

        // 7️⃣ Redirect sukses
        return redirect()->route('documents-management.index')
            ->with('success', 'Dokumen berhasil diunggah!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Documents $documents)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Documents $documents)
    {
        return response()->json($documents);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        DocumentUpdateRequest $request,
        Documents $documents,
        DocumentService $service
    ) {

        $service->update(
            $documents,
            array_merge(
                $request->validated()
            )
        );

        Cache::forget('latest_documents');
        Cache::flush();

        return redirect()->route('documents-management.index')
            ->with('success', 'Dokumen berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Documents $documents, DocumentService $service)
    {
        $service->delete($documents);

        Cache::forget('latest_documents');
        Cache::flush();

        return redirect()->route('documents-management.index')->with('success', 'Documents Telah Di hapus!');
    }
}

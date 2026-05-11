<?php

namespace App\Http\Controllers;

use App\Models\Carousels;
use App\Http\Requests\StoreCarouselRequest;
use App\Http\Requests\UpdateCarouselRequest;
use App\Services\CarouselService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CarouselsController extends Controller
{
    protected $service;

    public function __construct(CarouselService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return view('admin.carousels.index', [
            'title' => 'Carousels Managements',
            'carousels' => Carousels::with('author')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.carousels.create', [
            'title' => 'Create Carousels'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCarouselRequest $request)
    {
        $this->service->store($request->validated());

        Cache::forget('carousels');
        Cache::forget('dashboard.carousel');

        return redirect()->route('carousels-management.index')
            ->with('success', 'Carousel baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Carousels $carousels) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Carousels $carousels)
    {

        return view('admin.carousels.edit', [
            'title' => 'Edit Carousels',
            'carousel' => $carousels
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCarouselRequest $request, Carousels $carousels)
    {
        $this->service->update($carousels, $request->validated());

        Cache::forget('carousels');
        Cache::forget('dashboard.carousel');

        return redirect()->route('carousels-management.index')
            ->with('success', 'Carousel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Carousels $carousels)
    {
        $this->service->delete($carousels);

        Cache::forget('carousels');
        Cache::forget('dashboard.carousel');

        return redirect()->route('carousels-management.index')
            ->with('success', 'Carousel telah dihapus!');
    }

    public function reorder(Request $request)
    {
        $this->service->updateOrder($request->order);

        Cache::forget('carousels');
        Cache::forget('dashboard.carousel');

        return response()->json(['success' => true]);
    }
}

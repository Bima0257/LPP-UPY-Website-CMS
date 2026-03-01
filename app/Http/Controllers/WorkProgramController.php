<?php

namespace App\Http\Controllers;

use App\Models\WorkProgram;
use App\Services\WorkProgramService;
use App\Http\Requests\StoreWorkProgramRequest;
use App\Http\Requests\UpdateWorkProgramRequest;
use Illuminate\Support\Facades\Auth;

class WorkProgramController extends Controller
{

    protected $service;

    public function __construct(WorkProgramService $service)
    {
        $this->service = $service;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Jika Super Admin -> lihat semua, jika Admin -> lihat miliknya
        if (Auth::user()->role === 'superadmin') {
            $workPrograms = WorkProgram::with('author')->latest()->get();
        } else {
            $workPrograms = WorkProgram::with('author')
                ->where('author_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('admin.program-kerja.index', [
            'title' => 'Program Kerja',
            'workPrograms' => $workPrograms
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
    public function store(StoreWorkProgramRequest $request)
    {
        $this->service->store($request);

        return redirect()->route('work-programs.index')->with('success', 'Program kerja berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkProgram $workProgram)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkProgram $workProgram)
    {
        // Pastikan hanya pemilik atau super admin yang bisa edit
        if (Auth::user()->role !== 'superadmin' && $workProgram->author_id !== Auth::id()) {
            abort(403, 'Tidak memiliki izin.');
        }

        return response()->json($workProgram);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkProgramRequest $request, WorkProgram $workProgram)
    {
        $this->service->update($request, $workProgram);

        return redirect()->route('work-programs.index')->with('success', 'Program kerja berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkProgram $workProgram)
    {

        $this->service->destroy($workProgram);

        return redirect()->route('work-programs.index')->with('success', 'Program kerja berhasil dihapus!');
    }
}

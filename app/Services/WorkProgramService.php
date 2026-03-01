<?php

namespace App\Services;

use App\Models\WorkProgram;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class WorkProgramService
{

    public function store($request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tgl_pelaksanaan' => 'required|date',
            'is_published' => 'required|boolean',
        ]);

        return WorkProgram::create([
            'name' => $request->name,
            'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
            'is_published' => $request->is_published,
            'author_id' => Auth::id(),
        ]);
    }

    /**
     * Update Work Program
     */
    public function update($request, WorkProgram $workProgram)
    {
        // Validasi tetap dilakukan
        $request->validate([
            'name' => 'required|string|max:255',
            'tgl_pelaksanaan' => 'required|date',
            'is_published' => 'required|boolean',
        ]);

        // Cek akses
        if (Auth::user()->role !== 'superadmin' && $workProgram->author_id !== Auth::id()) {
            abort(403, 'Tidak memiliki izin.');
        }

        $workProgram->update([
            'name' => $request->name,
            'tgl_pelaksanaan' => $request->tgl_pelaksanaan,
            'is_published' => $request->is_published,
        ]);

        return $workProgram;
    }

    /**
     * Delete Work Program
     */
    public function destroy(WorkProgram $workProgram)
    {
        if (Auth::user()->role !== 'superadmin' && $workProgram->author_id !== Auth::id()) {
            abort(403, 'Tidak memiliki izin.');
        }

        return $workProgram->delete();
    }
}

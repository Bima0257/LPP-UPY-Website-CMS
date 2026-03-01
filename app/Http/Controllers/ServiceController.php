<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.service.index', [
            'title' => 'Layanan',
            'services' => Service::all()
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
        // 1️⃣ Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150|unique:services,name',
            'description' => 'nullable|string|max:5000',
            'link' => 'required|url|max:255',
        ]);

        // 2️⃣ Jika validasi gagal
        if ($validator->fails()) {
            $errorMessages = implode('<br>', $validator->errors()->all());
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessages)
                ->with('form_error', true);
        }

        // 3️⃣ Simpan data layanan baru
        Service::create([
            'name' => $request->name,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        Cache::forget('services');

        // 4️⃣ Redirect sukses
        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return response()->json($service);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        // 1️⃣ Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:150|unique:services,name,' . $service->id,
            'description' => 'nullable|string|max:5000',
            'link' => 'required|url|max:255',
        ]);

        // 2️⃣ Jika validasi gagal
        if ($validator->fails()) {
            $errorMessages = implode('<br>', $validator->errors()->all());
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessages)
                ->with('form_error', true);
        }

        // 3️⃣ Update data layanan
        $service->update([
            'name' => $request->name,
            'description' => $request->description,
            'link' => $request->link,
        ]);

        Cache::forget('services');

        // 4️⃣ Redirect sukses
        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {
        $service->delete();

        Cache::forget('services');
        // 4️⃣ Redirect sukses
        return redirect()->route('services.index')
            ->with('success', 'Layanan berhasil dihapus!');
    }
}

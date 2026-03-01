<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MenuController extends Controller
{
    public function index()
    {
        $title = 'Menu Setting';
        // Ambil data pertama atau buat baru jika belum ada
        $menu = Menu::first();
        if (!$menu) {
            $menu = Menu::create([
                'home' => 'Home',
                'about' => 'About',
                'information' => 'Information',
                'news' => 'News',
                'team' => 'Team',
                'service' => 'Service',
                'contact' => 'Contact',
            ]);
        }
        return view('admin.menu.index', compact('title', 'menu'));
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return response()->json($menu);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $validated = $request->validate([
            'home' => 'required|string|max:255',
            'about' => 'required|string|max:255',
            'information' => 'required|string|max:255',
            'news' => 'required|string|max:255',
            'team' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
        ]);

        $menu->update($validated);

        Cache::forget('menu');

        return redirect()->route('menu.index')
            ->with('success', 'Menu Navbar berhasil diperbarui!');
    }
}

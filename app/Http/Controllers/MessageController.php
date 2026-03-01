<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class MessageController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'origin' => 'nullable|string|max:100',
            'email' => 'required|email|max:150',
            'phone' => 'required|string|max:150',
            'message' => 'required|string',
        ]);


        if ($validator->fails()) {

            // Gabungkan pesan error
            $errorMessages = implode('<br>', $validator->errors()->all());

            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', $errorMessages)
                ->with('form_error', true);
        }

        // 🔒 Hitung pesan yang sudah masuk hari ini
        $today = Carbon::today();
        $todayMessages = Message::whereDate('created_at', $today)->count();

        // Maksimal 20 pesan / hari
        if ($todayMessages >= 20) {
            return back()
                ->withInput()
                ->with('error', 'Kuota pesan hari ini sudah habis, coba lagi besok.')
                ->with('form_error', true);
        }

        $validatedData = $validator->validated();

        Message::create([
            'name' => $validatedData['name'],
            'origin' => $validatedData['origin'] ?? null,
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'message' => $validatedData['message'],
            'is_read' => false,
        ]);

        return back()->with('success', 'Terima kasih, pesanmu telah terkirim!');
    }

    // Menampilkan semua pesan
    public function index()
    {
        $messages = Message::latest()->get();
        $title = 'Pesan Masuk';
        return view('admin.message.index', compact('messages', 'title'));
    }

    // Menampilkan detail pesan dan ubah status jadi "sudah dibaca"
    public function show($id)
    {
        $message = Message::findOrFail($id);

        // Jika belum dibaca, ubah statusnya
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }


        return response()->json($message);
    }

    public function deleteMessage($id)
    {
        Message::destroy($id);
        return back()->with('success', 'Pesan telah berhasil dihapus!');
    }

    public function deleteAll()
    {
        if (Message::count() === 0) {
            return back()->with('error', 'Tidak ada data pesan untuk dihapus.');
        }
        Message::truncate();
        return back()->with('success', 'Semua Pesan telah berhasil dihapus!');
    }
}

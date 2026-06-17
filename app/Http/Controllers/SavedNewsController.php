<?php

namespace App\Http\Controllers;

use App\Models\SavedNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedNewsController extends Controller
{
    /**
     * Tampilkan daftar berita yang disimpan oleh pengguna.
     */
    public function index()
    {
        // Mengambil berita yang disimpan oleh pengguna aktif, diurutkan dari yang terbaru
        $savedNews = Auth::user()->savedNews()->latest()->get();
        
        return view('saved-news.index', compact('savedNews'));
    }

    /**
     * Menyimpan berita baru ke daftar simpanan (bookmark).
     */
    public function store(Request $request)
    {
        // Validasi input data berita dari API yang dikirimkan oleh View
        $request->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'url' => ['required', 'string'],
            'image_url' => ['nullable', 'string'],
            'source_name' => ['nullable', 'string'],
            'category' => ['nullable', 'string'],
            'published_at' => ['nullable', 'string'],
        ]);

        // Cek apakah berita dengan URL yang sama sudah pernah disimpan oleh pengguna ini
        $exists = Auth::user()->savedNews()
            ->where('url', $request->url)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'Berita ini sudah disimpan sebelumnya.');
        }

        // Simpan berita menggunakan relasi hasMany pada model User
        Auth::user()->savedNews()->create($request->all());

        return redirect()->back()->with('success', 'Berita berhasil disimpan!');
    }

    /**
     * Menghapus berita dari daftar simpanan (bookmark).
     */
    public function destroy($id)
    {
        // Temukan berita berdasarkan ID dan pastikan kepemilikannya oleh user aktif
        $savedNews = Auth::user()->savedNews()->findOrFail($id);
        
        // Hapus dari database
        $savedNews->delete();

        return redirect()->back()->with('success', 'Berita berhasil dihapus dari daftar simpanan.');
    }
}
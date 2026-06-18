<?php

namespace App\Http\Controllers;

use App\Models\SavedNews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SavedNewsController extends Controller
{
    /**
     * Display a listing of the saved news.
     */
    public function index()
    {
        $savedNews = Auth::user()->savedNews()->latest()->get();
        return view('saved-news.index', compact('savedNews'));
    }

    /**
     * Store a newly created saved news in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'url' => ['required', 'string'],
            'image_url' => ['nullable', 'string'],
            'source_name' => ['nullable', 'string'],
            'category' => ['nullable', 'string'],
            'published_at' => ['nullable', 'string'],
        ]);
        
        // Check if already saved to avoid duplicates
        $exists = Auth::user()->savedNews()
            ->where('url', $request->url)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('info', 'Berita ini sudah disimpan sebelumnya.');
        }

        Auth::user()->savedNews()->create($request->all());

        return redirect()->back()->with('success', 'Berita berhasil disimpan!');
    }

    /**
     * Remove the specified saved news from storage.
     */
    public function destroy($id)
    {
        $savedNews = Auth::user()->savedNews()->findOrFail($id);
        $savedNews->delete();

        return redirect()->back()->with('success', 'Berita berhasil dihapus dari daftar simpanan.');
    }
}
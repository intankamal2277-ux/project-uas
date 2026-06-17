<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteCategoryController extends Controller
{
    /**
     * Memperbarui kategori berita favorit pengguna.
     */
    public function update(Request $request)
    {
        // Validasi agar input categories bertipe array berisi string
        $request->validate([
            'categories' => ['nullable', 'array'],
            'categories.*' => ['string'],
        ]);

        $user = Auth::user();
        
        // Simpan array kategori terpilih ke kolom favorite_categories di tabel users
        // Jika tidak ada checkbox yang dicentang, default ke array kosong []
        $user->update([
            'favorite_categories' => $request->input('categories', [])
        ]);

        return redirect()->back()->with('success', 'Kategori favorit Anda berhasil diperbarui!');
    }
}
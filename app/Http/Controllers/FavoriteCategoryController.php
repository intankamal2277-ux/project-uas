<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteCategoryController extends Controller
{
    /**
     * Update the user's favorite categories.
     */
    public function update(Request $request)
    {
        $request->validate([
            'categories' => ['nullable', 'array'],
            'categories.*' => ['string'],
        ]);

        $user = Auth::user();
        $user->update([
            'favorite_categories' => $request->input('categories', [])
        ]);

        return redirect()->back()->with('success', 'Kategori favorit Anda berhasil diperbarui!');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'article_url' => ['required', 'string'],
            'article_url_hash' => ['required', 'string'],
            'comment_text' => ['required', 'string', 'max:1000'],
        ], [
            'comment_text.required' => 'Komentar tidak boleh kosong.',
            'comment_text.max' => 'Komentar tidak boleh lebih dari 1000 karakter.'
        ]);

        Auth::user()->comments()->create([
            'article_url' => $request->article_url,
            'article_url_hash' => $request->article_url_hash,
            'comment_text' => $request->comment_text,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if (Auth::user()->id !== $comment->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Anda tidak memiliki hak untuk menghapus komentar ini.');
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }
}
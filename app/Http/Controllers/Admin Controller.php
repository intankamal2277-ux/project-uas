<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\SavedNews;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_users' => User::count(),
            'total_comments' => Comment::count(),
            'total_saved_news' => SavedNews::count(),
            'total_admins' => User::where('role', 'admin')->count(),
        ];

        $users = User::withCount(['comments', 'savedNews'])
            ->latest()
            ->get();

        return view('admin.dashboard', compact('stats', 'users'));
    }
}
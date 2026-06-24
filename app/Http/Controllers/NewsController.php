<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\NewsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewsController extends Controller
{
    protected $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    public function index(Request $request)
    {
        $category = $request->query('category', 'all');
        $search = $request->query('q');

        $articles = $this->newsService->getTopHeadlines($category, $search);

        $userFavorites = [];
        $recommendedArticles = [];
        if (Auth::check()) {
            $userFavorites = Auth::user()->favorite_categories ?? [];
            
            if (!empty($userFavorites)) {
                $favCategory = $userFavorites[0];
                $recommendedArticles = $this->newsService->getTopHeadlines($favCategory);
            }
        }

        return view('welcome', compact('articles', 'category', 'search', 'userFavorites', 'recommendedArticles'));
    }

    public function detail(Request $request)
    {
        $request->validate([
            'url' => ['required', 'string'],
            'title' => ['required', 'string'],
        ]);

        $article = [
            'url' => $request->query('url'),
            'title' => $request->query('title'),
            'description' => $request->query('description'),
            'image_url' => $request->query('image_url'),
            'source_name' => $request->query('source_name'),
            'published_at' => $request->query('published_at'),
            'category' => $request->query('category'),
        ];

        $urlHash = md5($article['url']);

        $comments = Comment::where('article_url_hash', $urlHash)
            ->with('user')
            ->oldest()
            ->get();

        return view('news.detail', compact('article', 'comments', 'urlHash'));
    }
}
<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class NewsApiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key');
        $this->baseUrl = config('services.newsapi.base_url');
    }

    /**
     * Ambil berita terbaru (top headlines) berdasarkan kategori.
     */
    public function getTopHeadlines(string $category, int $pageSize = 6): array
    {
        $cacheKey = "newsapi_top_{$category}";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($category, $pageSize) {

            $response = Http::get($this->baseUrl . '/top-headlines', [
                'category' => $category,
                'pageSize' => $pageSize,
                'country'  => 'us',
                'apiKey'   => $this->apiKey,
            ]);

            if (!$response->successful()) {
                return [];
            }

            $data = $response->json();
            $articles = $data['articles'] ?? [];

            return collect($articles)
                ->filter(function ($item) {
                    return ($item['title'] ?? null) !== '[Removed]';
                })
                ->map(function ($item) use ($category) {
                    return [
                        'title'        => $item['title'] ?? 'Tanpa Judul',
                        'description'  => $item['description'] ?? null,
                        'url'          => $item['url'] ?? '#',
                        'image_url'    => $item['urlToImage'] ?? null,
                        'source_name'  => $item['source']['name'] ?? 'Tidak diketahui',
                        'category'     => $category,
                        'published_at' => $item['publishedAt'] ?? null,
                    ];
                })
                ->values()
                ->toArray();
        });
    }
}
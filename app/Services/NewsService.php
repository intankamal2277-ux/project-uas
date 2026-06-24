<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NewsService
{
    protected $apiKey;
    protected $baseUrl = 'https://newsapi.org/v2';

    public function __construct()
    {
        $this->apiKey = env('NEWS_API_KEY');
    }

    public function getTopHeadlines($category = null, $query = null)
    {
        $apiCategory = $category ? strtolower($category) : null;
        if ($apiCategory === 'all') {
            $apiCategory = null;
        }

        if ($this->apiKey) {
            try {
                $params = [
                    'apiKey' => $this->apiKey,
                    'country' => 'id',
                ];

                if ($apiCategory) {
                    $params['category'] = $apiCategory;
                }

                if ($query) {
                    $params['q'] = $query;
                }

                $response = Http::timeout(5)->get("{$this->baseUrl}/top-headlines", $params);

                if ($response->successful()) {
                    $articles = $response->json()['articles'] ?? [];
                    
                    return collect($articles)->filter(function ($article) {
                        return isset($article['title']) && $article['title'] !== '[Removed]';
                    })->map(function ($article) {
                        return [
                            'title' => $article['title'],
                            'description' => $article['description'] ?? 'Tidak ada deskripsi singkat untuk berita ini.',
                            'url' => $article['url'],
                            'image_url' => $article['urlToImage'] ?? 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=600&auto=format&fit=crop',
                            'source_name' => $article['source']['name'] ?? 'Sumber Berita',
                            'published_at' => $article['publishedAt'] ?? now()->toIso8601String(),
                            'category' => null,
                        ];
                    })->values()->all();
                }

                Log::warning('NewsAPI Response Gagal: ' . $response->body());
            } catch (\Exception $e) {
                Log::error('Gagal menghubungi NewsAPI: ' . $e->getMessage());
            }
        }

        return $this->getMockNews($category, $query);
    }

    protected function getMockNews($category = null, $query = null)
    {
        $mockArticles = [
            [
                'title' => 'Kemkominfo Luncurkan Program Akselerasi AI Nasional untuk Startup Lokal',
                'description' => 'Pemerintah bekerja sama dengan konsorsium teknologi global meluncurkan inisiatif pelatihan dan pendanaan kecerdasan buatan bagi startup Indonesia.',
                'url' => 'https://example.com/tech-ai-indonesia',
                'image_url' => 'https://images.unsplash.com/photo-1677442136019-21780efad99a?q=80&w=600&auto=format&fit=crop',
                'source_name' => 'TeknoIndo',
                'published_at' => '2026-06-24T09:00:00Z',
                'category' => 'Technology',
            ],
            [
                'title' => 'Mengenal Teknologi Jaringan 6G yang Mulai Diuji Coba di Beberapa Negara',
                'description' => 'Meskipun 5G belum merata, pengembangan teknologi nirkabel 6G menjanjikan kecepatan transfer data super kilat hingga 100 kali lipat dari 5G.',
                'url' => 'https://example.com/tech-6g-testing',
                'image_url' => 'https://images.unsplash.com/photo-1544197150-b99a580bb7a8?q=80&w=600&auto=format&fit=crop',
                'source_name' => 'Warta Gadget',
                'published_at' => '2026-06-24T07:15:00Z',
                'category' => 'Technology',
            ],
            [
                'title' => 'Timnas Indonesia Raih Kemenangan Bersejarah di Kualifikasi Piala Dunia',
                'description' => 'Skuad Garuda berhasil menundukkan tim tamu dengan skor dramatis 2-1 lewat gol di menit-menit akhir pertandingan yang membakar semangat penonton.',
                'url' => 'https://example.com/sports-timnas-win',
                'image_url' => 'https://images.unsplash.com/photo-1508098682722-e99c43a406b2?q=80&w=600&auto=format&fit=crop',
                'source_name' => 'BolaNasional',
                'published_at' => '2026-06-23T20:30:00Z',
                'category' => 'Sports',
            ],
            [
                'title' => 'Indonesia Open 2026: Ganda Putra Merah Putih Lolos ke Babak Semifinal',
                'description' => 'Perjuangan sengit di Istora Senayan membuahkan hasil manis setelah ganda putra andalan mengalahkan unggulan pertama asal Denmark.',
                'url' => 'https://example.com/sports-indonesia-open',
                'image_url' => 'https://images.unsplash.com/photo-1626224583764-f87db24ac4ea?q=80&w=600&auto=format&fit=crop',
                'source_name' => 'RaketKita',
                'published_at' => '2026-06-24T05:45:00Z',
                'category' => 'Sports',
            ],
            [
                'title' => 'Rupiah Menguat Tajam Terhadap Dolar AS Menyusul Kebijakan Suku Bunga Baru',
                'description' => 'Langkah strategis Bank Indonesia berhasil menstabilkan nilai tukar mata uang domestik di tengah ketidakpastian pasar finansial global.',
                'url' => 'https://example.com/business-rupiah-strong',
                'image_url' => 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?q=80&w=600&auto=format&fit=crop',
                'source_name' => 'Fokus Keuangan',
                'published_at' => '2026-06-24T08:00:00Z',
                'category' => 'Business',
            ],
            [
                'title' => 'Sektor UMKM Digital Catatkan Pertumbuhan Omzet Hingga 40 Persen Tahun Ini',
                'description' => 'Pemanfaatan platform e-commerce dan pembayaran digital terbukti menjadi motor penggerak ekonomi mikro di berbagai pelosok daerah.',
                'url' => 'https://example.com/business-umkm-digital',
                'image_url' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?q=80&w=600&auto=format&fit=crop',
                'source_name' => 'BisnisKita',
                'published_at' => '2026-06-24T03:10:00Z',
                'category' => 'Business',
            ],
            [
                'title' => 'BRIN Temukan Spesies Tanaman Baru Berkhasiat Obat di Hutan Kalimantan',
                'description' => 'Penelitian kolaboratif berhasil mengidentifikasi varietas tanaman langka yang berpotensi menjadi bahan dasar terapi pengobatan kanker.',
                'url' => 'https://example.com/science-brin-discovery',
                'image_url' => 'https://images.unsplash.com/photo-1532187643603-ba119ca4109e?q=80&w=600&auto=format&fit=crop',
                'source_name' => 'SainsNusantara',
                'published_at' => '2026-06-23T12:00:00Z',
                'category' => 'Science',
            ],
            [
                'title' => 'Kementerian Kesehatan Gencarkan Kampanye Pola Hidup Sehat Cegah Diabetes Muda',
                'description' => 'Meningkatnya kasus diabetes pada usia remaja mendorong Kemenkes menerapkan pembatasan kadar gula pada produk minuman kemasan.',
                'url' => 'https://example.com/health-diabetes-prevention',
                'image_url' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?q=80&w=600&auto=format&fit=crop',
                'source_name' => 'SehatSelalu',
                'published_at' => '2026-06-24T02:00:00Z',
                'category' => 'Health',
            ],
            [
                'title' => 'Film Sutradara Indonesia Masuk Nominasi Festival Film Internasional di Cannes',
                'description' => 'Karya sinematik bertema kearifan lokal berhasil memukau juri dan bersaing memperebutkan penghargaan utama kategori film dokumenter terbaik.',
                'url' => 'https://example.com/ent-film-cannes',
                'image_url' => 'https://images.unsplash.com/photo-1489599849927-2ee91cede3ba?q=80&w=600&auto=format&fit=crop',
                'source_name' => 'LayarKaca',
                'published_at' => '2026-06-24T10:00:00Z',
                'category' => 'Entertainment',
            ]
        ];

        return collect($mockArticles)
            ->filter(function ($article) use ($category, $query) {
                if ($category && strtolower($category) !== 'all') {
                    if (strtolower($article['category']) !== strtolower($category)) {
                        return false;
                    }
                }
                if ($query) {
                    $q = strtolower($query);
                    $titleMatch = str_contains(strtolower($article['title']), $q);
                    $descMatch = str_contains(strtolower($article['description']), $q);
                    return $titleMatch || $descMatch;
                }
                return true;
            })
            ->values()
            ->all();
    }
}
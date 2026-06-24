@extends('layouts.app', ['title' => 'BeritaKini - Portal Berita Indonesia'])

@section('content')
<!-- Hero Header -->
<div class="relative overflow-hidden py-12 sm:py-16 border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto space-y-4">
            <h1 class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white">
                Informasi Terkini & Terpercaya dalam 
                <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent">Satu Tempat</span>
            </h1>
            <p class="text-slate-400 text-sm sm:text-base">
                Membaca berita nasional dari berbagai kategori secara otomatis berdasarkan topik pilihan Anda dengan integrasi NewsAPI.
            </p>

            <!-- Formulir Pencarian Berita -->
            <form action="/" method="GET" class="mt-8 max-w-xl mx-auto flex gap-2">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <div class="relative flex-grow">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kata kunci berita..." 
                        class="w-full pl-10 pr-4 py-3 bg-slate-900/80 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm glass">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
                <button type="submit" class="px-5 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl text-sm transition-all hover:scale-[1.02] active:scale-[0.98]">
                    Cari
                </button>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-10">

    <!-- Bagian Rekomendasi Kategori Favorit User (Integrasi Mhs 1 & Mhs 2) -->
    @auth
        @if(!empty($userFavorites) && !empty($recommendedArticles))
            <div class="space-y-4">
                <div class="flex items-center gap-2">
                    <span class="p-1 bg-indigo-500/10 rounded-lg border border-indigo-500/20 text-indigo-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </span>
                    <h2 class="text-xl font-bold text-white">Rekomendasi Kategori Favorit Anda ({{ $userFavorites[0] }})</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(array_slice($recommendedArticles, 0, 3) as $recArticle)
                        <div class="glass rounded-xl overflow-hidden border border-indigo-500/10 hover:border-indigo-500/20 flex flex-col justify-between p-4 space-y-3">
                            <div class="space-y-2">
                                <span class="text-[10px] font-bold uppercase text-indigo-400 bg-indigo-500/10 px-2 py-0.5 rounded border border-indigo-500/20">
                                    {{ $recArticle['source_name'] }}
                                </span>
                                <h4 class="font-bold text-slate-100 text-sm line-clamp-2">{{ $recArticle['title'] }}</h4>
                                <p class="text-xs text-slate-400 line-clamp-2">{{ $recArticle['description'] }}</p>
                            </div>
                            <div class="flex items-center justify-between gap-4 pt-2 border-t border-white/5">
                                <a href="/news/detail?url={{ urlencode($recArticle['url']) }}&title={{ urlencode($recArticle['title']) }}&description={{ urlencode($recArticle['description']) }}&image_url={{ urlencode($recArticle['image_url']) }}&source_name={{ urlencode($recArticle['source_name']) }}&published_at={{ urlencode($recArticle['published_at']) }}&category={{ urlencode($userFavorites[0]) }}" 
                                    class="text-xs text-indigo-400 hover:text-indigo-300 font-semibold transition-colors">
                                    Detail & Komentar
                                </a>
                                @auth
                                    <form action="{{ route('saved-news.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="title" value="{{ $recArticle['title'] }}">
                                        <input type="hidden" name="description" value="{{ $recArticle['description'] }}">
                                        <input type="hidden" name="url" value="{{ $recArticle['url'] }}">
                                        <input type="hidden" name="image_url" value="{{ $recArticle['image_url'] }}">
                                        <input type="hidden" name="source_name" value="{{ $recArticle['source_name'] }}">
                                        <input type="hidden" name="category" value="{{ $userFavorites[0] }}">
                                        <input type="hidden" name="published_at" value="{{ $recArticle['published_at'] }}">
                                        <button type="submit" class="text-xs text-slate-400 hover:text-white transition-colors">
                                            Simpan
                                        </button>
                                    </form>
                                @endauth
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <hr class="border-white/5 my-8">
        @endif
    @endauth

    <!-- List Berita Utama & Filter Kategori -->
    <div class="space-y-6">
        <div class="flex items-center justify-between border-b border-white/5 pb-4 flex-wrap gap-4">
            <h2 class="text-xl font-bold text-white">Berita Utama</h2>
            
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 max-w-full">
                @php
                    $categories = [
                        'all' => 'Semua',
                        'Business' => 'Bisnis',
                        'Entertainment' => 'Hiburan',
                        'Health' => 'Kesehatan',
                        'Science' => 'Sains',
                        'Sports' => 'Olahraga',
                        'Technology' => 'Teknologi'
                    ];
                @endphp
                @foreach($categories as $key => $label)
                    <a href="/?category={{ $key }}{{ request('q') ? '&q=' . request('q') : '' }}" 
                        class="px-4 py-2 text-xs font-semibold rounded-lg border transition-all whitespace-nowrap {{ ($category === $key) ? 'bg-indigo-600 border-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'bg-slate-900 border-slate-800 text-slate-400 hover:text-white hover:border-slate-700' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>

        @if(empty($articles))
            <div class="glass p-12 text-center rounded-2xl max-w-lg mx-auto shadow-lg space-y-4">
                <div class="w-16 h-16 bg-slate-900 border border-slate-800 rounded-2xl flex items-center justify-center mx-auto text-slate-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Berita tidak ditemukan</h3>
                    <p class="text-slate-400 text-sm mt-1">Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.</p>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($articles as $article)
                    <article class="glass rounded-2xl overflow-hidden flex flex-col hover:border-indigo-500/30 transition-all group duration-300">
                        <div class="aspect-video w-full bg-slate-900 relative overflow-hidden border-b border-white/5">
                            @if($article['image_url'])
                                <img src="{{ $article['image_url'] }}" alt="{{ $article['title'] }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1504711434969-e33886168f5c?q=80&w=600&auto=format&fit=crop';">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-600">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            
                            <span class="absolute top-3 left-3 px-2.5 py-1 text-[10px] font-bold bg-slate-950/80 backdrop-blur border border-white/5 rounded-lg text-slate-200">
                                {{ $article['source_name'] }}
                            </span>
                        </div>

                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <h3 class="font-bold text-white group-hover:text-indigo-400 transition-colors line-clamp-2" title="{{ $article['title'] }}">
                                    {{ $article['title'] }}
                                </h3>
                                <p class="text-xs text-slate-500">
                                    {{ \Carbon\Carbon::parse($article['published_at'])->diffForHumans() }}
                                </p>
                                <p class="text-sm text-slate-400 line-clamp-3">
                                    {{ $article['description'] }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-white/5 flex items-center justify-between gap-4">
                                <a href="/news/detail?url={{ urlencode($article['url']) }}&title={{ urlencode($article['title']) }}&description={{ urlencode($article['description']) }}&image_url={{ urlencode($article['image_url']) }}&source_name={{ urlencode($article['source_name']) }}&published_at={{ urlencode($article['published_at']) }}&category={{ urlencode($article['category']) }}" 
                                    class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition-colors flex items-center gap-1">
                                    Detail & Komentar
                                </a>

                                @auth
                                    <form action="{{ route('saved-news.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="title" value="{{ $article['title'] }}">
                                        <input type="hidden" name="description" value="{{ $article['description'] }}">
                                        <input type="hidden" name="url" value="{{ $article['url'] }}">
                                        <input type="hidden" name="image_url" value="{{ $article['image_url'] }}">
                                        <input type="hidden" name="source_name" value="{{ $recArticle['source_name'] ?? $article['source_name'] }}">
                                        <input type="hidden" name="category" value="{{ $article['category'] ?? $category }}">
                                        <input type="hidden" name="published_at" value="{{ $article['published_at'] }}">
                                        <button type="submit" class="px-3 py-1.5 text-xs font-medium bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 rounded-lg border border-indigo-500/10 transition-colors">
                                            Simpan
                                        </button>
                                    </form>
                                @else
                                    <a href="/login" class="px-3 py-1.5 text-xs font-medium bg-slate-900 hover:bg-slate-800 text-slate-400 hover:text-slate-300 rounded-lg border border-slate-800 transition-colors">
                                        Simpan
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
@extends('layouts.app', ['title' => 'Berita Tersimpan - BeritaKini'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="space-y-8">
        
        <!-- Header -->
        <div class="glass p-6 sm:p-8 rounded-2xl shadow-lg shadow-black/20">
            <h1 class="text-2xl sm:text-3xl font-bold text-white flex items-center gap-3">
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                Berita Tersimpan
            </h1>
            <p class="text-slate-400 mt-1">Daftar seluruh artikel berita yang Anda simpan untuk dibaca nanti.</p>
        </div>

        <!-- Empty State -->
        @if($savedNews->isEmpty())
            <div class="glass p-12 text-center rounded-2xl max-w-lg mx-auto shadow-lg shadow-black/10 space-y-4">
                <div class="w-16 h-16 bg-slate-900 border border-slate-800 rounded-2xl flex items-center justify-center mx-auto text-slate-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Belum ada berita disimpan</h3>
                    <p class="text-slate-400 text-sm mt-1">Cari berita menarik di halaman utama dan klik tombol "Simpan Berita" untuk menyimpannya di sini.</p>
                </div>
                <div class="pt-2">
                    <a href="/" class="px-5 py-2.5 text-sm font-semibold bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md shadow-indigo-500/20 transition-all inline-block">
                        Jelajahi Berita
                    </a>
                </div>
            </div>
        @else
            <!-- News Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($savedNews as $news)
                    <article class="glass rounded-2xl overflow-hidden flex flex-col hover:border-indigo-500/30 transition-all group duration-300">
                        
                        <!-- Thumbnail -->
                        <div class="aspect-video w-full bg-slate-900 relative overflow-hidden border-b border-white/5">
                            @if($news->image_url)
                                <img src="{{ $news->image_url }}" alt="{{ $news->title }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    onerror="this.onerror=null; this.src='/placeholder-news.jpg';">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-slate-600">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            @endif
                            
                            <!-- Source Badge -->
                            @if($news->source_name)
                                <span class="absolute top-3 left-3 px-2.5 py-1 text-[10px] font-bold bg-slate-950/80 backdrop-blur border border-white/5 rounded-lg text-slate-200">
                                    {{ $news->source_name }}
                                </span>
                            @endif

                            <!-- Category Badge -->
                            @if($news->category)
                                <span class="absolute top-3 right-3 px-2.5 py-1 text-[10px] font-bold bg-indigo-500/80 backdrop-blur rounded-lg text-white">
                                    {{ $news->category }}
                                </span>
                            @endif
                        </div>

                        <!-- Card Content -->
                        <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                            <div class="space-y-2">
                                <h3 class="font-bold text-white group-hover:text-indigo-400 transition-colors line-clamp-2" title="{{ $news->title }}">
                                    {{ $news->title }}
                                </h3>
                                <p class="text-xs text-slate-500">
                                    {{ $news->published_at ? \Carbon\Carbon::parse($news->published_at)->diffForHumans() : '' }}
                                </p>
                                <p class="text-sm text-slate-400 line-clamp-3">
                                    {{ $news->description }}
                                </p>
                            </div>

                            <div class="pt-4 border-t border-white/5 flex items-center justify-between gap-4">
                                <a href="{{ $news->url }}" target="_blank" rel="noopener noreferrer" 
                                    class="text-xs font-semibold text-indigo-400 hover:text-indigo-300 transition-colors flex items-center gap-1">
                                    Baca Selengkapnya
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                                <form action="/saved-news/{{ $news->id }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?')">
                                    @csrf

                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 text-xs font-medium bg-red-500/10 hover:bg-red-500/20 text-red-400 rounded-lg border border-red-500/10 transition-colors">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        @endif

    </div>
</div>
@endsection
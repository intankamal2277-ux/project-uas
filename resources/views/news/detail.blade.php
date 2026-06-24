@extends('layouts.app', ['title' => $article['title'] . ' - BeritaKini'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="space-y-6">
        <div>
            <a href="/" class="text-xs font-semibold text-slate-400 hover:text-white transition-colors flex items-center gap-1.5 w-fit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Detail Berita -->
                <article class="glass p-6 sm:p-8 rounded-2xl shadow-lg space-y-6 border border-white/5">
                    @if($article['image_url'])
                        <div class="aspect-video w-full rounded-xl overflow-hidden bg-slate-900 border border-white/5">
                            <img src="{{ $article['image_url'] }}" alt="{{ $article['title'] }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div class="flex flex-wrap gap-2 items-center text-xs text-slate-400">
                            <span class="px-2.5 py-1 bg-slate-900 border border-slate-800 rounded-lg text-slate-200 font-bold">
                                {{ $article['source_name'] }}
                            </span>
                            <span>•</span>
                            <span>{{ $article['published_at'] ? \Carbon\Carbon::parse($article['published_at'])->format('d M Y, H:i') : '' }}</span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                            {{ $article['title'] }}
                        </h1>

                        <p class="text-slate-300 leading-relaxed text-base">
                            {{ $article['description'] }}
                        </p>

                        <div class="p-4 bg-slate-900/60 border border-slate-800 rounded-xl flex items-center justify-between gap-4 mt-6">
                            <span class="text-xs text-slate-400">Baca artikel lengkap secara resmi di portal sumber asli.</span>
                            <a href="{{ $article['url'] }}" target="_blank" rel="noopener noreferrer" 
                                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-xs transition-colors shrink-0">
                                Kunjungi Sumber
                            </a>
                        </div>
                    </div>
                </article>

                <!-- Kolom Komentar (Mhs 3) -->
                <div class="glass p-6 sm:p-8 rounded-2xl shadow-lg space-y-6 border border-white/5">
                    <h3 class="text-lg font-bold text-white flex items-center gap-2">
                        Komentar ({{ $comments->count() }})
                    </h3>

                    @auth
                        <form action="/comments" method="POST" class="space-y-3">
                            @csrf
                            <input type="hidden" name="article_url" value="{{ $article['url'] }}">
                            <input type="hidden" name="article_url_hash" value="{{ $urlHash }}">
                            <textarea name="comment_text" rows="3" required placeholder="Tulis komentar..." 
                                class="w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm"></textarea>
                            <div class="flex justify-end">
                                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg text-xs">
                                    Kirim
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="p-4 bg-slate-900/60 border border-slate-800 rounded-xl text-center text-sm text-slate-400">
                            Harap <a href="/login" class="font-bold text-indigo-400">Login</a> untuk mengirim komentar.
                        </div>
                    @endauth

                    <div class="space-y-4 pt-4 border-t border-white/5">
                        @forelse($comments as $comment)
                            <div class="flex gap-4 p-4 rounded-xl bg-slate-900/40 border border-slate-900">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm uppercase shrink-0">
                                    {{ substr($comment->user->name, 0, 2) }}
                                </div>
                                <div class="flex-grow space-y-1">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm font-semibold text-slate-200">{{ $comment->user->name }}</span>
                                            @if($comment->user->isAdmin())
                                                <span class="px-1.5 py-0.5 text-[9px] font-bold bg-red-500/20 text-red-400 rounded border border-red-500/30">ADMIN</span>
                                            @endif
                                        </div>
                                        <span class="text-[10px] text-slate-500">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-slate-300 break-words">{{ $comment->comment_text }}</p>

                                    @auth
                                        @if(auth()->user()->id === $comment->user_id || auth()->user()->isAdmin())
                                            <div class="flex justify-end pt-1">
                                                <form action="/comments/{{ $comment->id }}" method="POST" onsubmit="return confirm('Hapus komentar?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-[11px] font-semibold text-red-400">Hapus</button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-slate-500 italic text-center">Belum ada komentar.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <div class="glass p-6 rounded-2xl border border-white/5 space-y-4">
                    <h4 class="font-bold text-white text-sm uppercase">Simpan</h4>
                    @auth
                        <form action="{{ route('saved-news.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="title" value="{{ $article['title'] }}">
                            <input type="hidden" name="description" value="{{ $article['description'] }}">
                            <input type="hidden" name="url" value="{{ $article['url'] }}">
                            <input type="hidden" name="image_url" value="{{ $article['image_url'] }}">
                            <input type="hidden" name="source_name" value="{{ $article['source_name'] }}">
                            <input type="hidden" name="category" value="{{ $article['category'] }}">
                            <input type="hidden" name="published_at" value="{{ $article['published_at'] }}">
                            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-semibold text-sm">
                                Simpan Berita
                            </button>
                        </form>
                    @else
                        <a href="/login" class="w-full py-2.5 bg-slate-900 border border-slate-800 rounded-xl text-slate-400 flex items-center justify-center text-sm">
                            Login untuk Simpan
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
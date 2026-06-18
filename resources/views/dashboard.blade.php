@extends('layouts.app', ['title' => 'Dashboard - BeritaKini'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="space-y-8">
        
        <!-- Header -->
        <div class="glass p-6 sm:p-8 rounded-2xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 shadow-lg shadow-black/20">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-white">Halo, {{ auth()->user()->name }}!</h1>
                <p class="text-slate-400 mt-1">Kelola preferensi membaca Anda di dashboard ini.</p>
            </div>
            <div class="flex gap-3">
                <a href="/saved-news" class="px-4 py-2.5 text-sm font-semibold glass hover:bg-white/5 text-slate-200 rounded-xl transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                    Lihat Berita Tersimpan ({{ auth()->user()->savedNews()->count() }})
                </a>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Side: Profile Info & Stats -->
            <div class="glass p-6 sm:p-8 rounded-2xl shadow-lg shadow-black/10 space-y-6 h-fit">
                <h3 class="text-lg font-bold text-white border-b border-white/5 pb-3">Profil Anda</h3>
                
                <div class="space-y-4">
                    <div>
                        <span class="text-xs text-slate-500 block">NAMA LENGKAP</span>
                        <span class="text-sm font-medium text-slate-200">{{ auth()->user()->name }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block">ALAMAT EMAIL</span>
                        <span class="text-sm font-medium text-slate-200">{{ auth()->user()->email }}</span>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 block">TANGGAL BERGABUNG</span>
                        <span class="text-sm font-medium text-slate-200">{{ auth()->user()->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="pt-4 border-t border-white/5">
                    <span class="text-xs text-slate-500 block mb-2">KATEGORI PILIHAN ANDA</span>
                    <div class="flex flex-wrap gap-1.5">
                        @forelse(auth()->user()->favorite_categories ?? [] as $fav)
                            <span class="px-2.5 py-1 text-xs font-semibold bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 rounded-full">
                                {{ $fav }}
                            </span>
                        @empty
                            <span class="text-xs text-slate-400 italic">Belum ada kategori favorit dipilih.</span>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Side: Favorite Category Selector -->
            <div class="lg:col-span-2 glass p-6 sm:p-8 rounded-2xl shadow-lg shadow-black/10 space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-white border-b border-white/5 pb-3">Pilih Kategori Berita Favorit</h3>
                    <p class="text-slate-400 text-sm mt-1">Pilih satu atau beberapa kategori di bawah ini. Rekomendasi berita Anda akan disesuaikan dengan topik ini.</p>
                </div>|

                <form action="/favorites" method="POST" class="space-y-6">
                    @csrf
                    
                    @php
                        $available_categories = [
                            'Business' => 'Bisnis',
                            'Entertainment' => 'Hiburan',
                            'Health' => 'Kesehatan',
                            'Science' => 'Sains',
                            'Sports' => 'Olahraga',
                            'Technology' => 'Teknologi'
                        ];
                        $user_favs = auth()->user()->favorite_categories ?? [];
                    @endphp

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($available_categories as $key => $label)
                            <label class="relative flex items-center p-4 rounded-xl border border-slate-800 hover:border-indigo-500/50 bg-slate-900/40 hover:bg-slate-900/80 cursor-pointer transition-all select-none group">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" name="categories[]" value="{{ $key }}" 
                                        {{ in_array($key, $user_favs) ? 'checked' : '' }}
                                        class="h-5 w-5 rounded border-slate-800 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-slate-900 cursor-pointer">
                                </div>
                                <div class="ml-3 text-sm">
                                    <span class="font-semibold text-slate-200 group-hover:text-white transition-colors">{{ $label }}</span>
                                    <span class="block text-xs text-slate-500">Berita seputar {{ strtolower($label) }} terbaru</span>
                                </div>
                            </label>
                        @endforeach
                    </div>

                    <div class="flex justify-end pt-4 border-t border-white/5">
                        <button type="submit" class="px-6 py-3 font-semibold text-sm bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-xl shadow-md shadow-indigo-500/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>
</div>
@endsection
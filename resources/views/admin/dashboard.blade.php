@extends('layouts.app', ['title' => 'Dashboard Admin - BeritaKini'])

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="space-y-8">
        
        <div class="glass p-6 sm:p-8 rounded-2xl border border-white/5">
            <h1 class="text-2xl sm:text-3xl font-bold text-white flex items-center gap-3">Panel Administrator</h1>
            <p class="text-slate-400 mt-1">Gunakan panel ini untuk memantau pendaftaran pengguna baru, jumlah komentar, dan simpanan berita.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="glass p-6 rounded-2xl border border-white/5">
                <span class="text-xs text-slate-400 block font-semibold uppercase">Total Pengguna</span>
                <span class="text-3xl font-extrabold text-white mt-1 block">{{ $stats['total_users'] }}</span>
            </div>
            <div class="glass p-6 rounded-2xl border border-white/5">
                <span class="text-xs text-slate-400 block font-semibold uppercase">Total Komentar</span>
                <span class="text-3xl font-extrabold text-white mt-1 block">{{ $stats['total_comments'] }}</span>
            </div>
            <div class="glass p-6 rounded-2xl border border-white/5">
                <span class="text-xs text-slate-400 block font-semibold uppercase">Berita Disimpan</span>
                <span class="text-3xl font-extrabold text-white mt-1 block">{{ $stats['total_saved_news'] }}</span>
            </div>
            <div class="glass p-6 rounded-2xl border border-white/5">
                <span class="text-xs text-slate-400 block font-semibold uppercase">Administrator</span>
                <span class="text-3xl font-extrabold text-white mt-1 block">{{ $stats['total_admins'] }}</span>
            </div>
        </div>

        <div class="glass rounded-2xl border border-white/5 overflow-hidden">
            <div class="px-6 py-5 border-b border-white/5">
                <h3 class="font-bold text-white text-lg">Daftar Pengguna & Aktivitas</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900 border-b border-white/5 text-xs text-slate-400 uppercase">
                            <th class="px-6 py-4">Nama Pengguna</th>
                            <th class="px-6 py-4">Alamat Email</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4">Kategori Favorit</th>
                            <th class="px-6 py-4 text-center">Jumlah Komentar</th>
                            <th class="px-6 py-4 text-center">Simpan Berita</th>
                            <th class="px-6 py-4">Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm text-slate-300">
                        @foreach($users as $user)
                            <tr class="hover:bg-white/5">
                                <td class="px-6 py-4 font-semibold text-slate-100">{{ $user->name }}</td>
                                <td class="px-6 py-4 font-mono text-xs text-slate-400">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ $user->isAdmin() ? 'bg-red-500/20 text-red-400' : 'bg-slate-900 text-slate-400' }}">
                                        {{ $user->role }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1 max-w-[180px]">
                                        @forelse($user->favorite_categories ?? [] as $fav)
                                            <span class="px-1.5 py-0.5 text-[9px] bg-indigo-500/10 text-indigo-400 rounded">{{ $fav }}</span>
                                        @empty
                                            <span class="text-xs text-slate-500 italic">None</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">{{ $user->comments_count }}</td>
                                <td class="px-6 py-4 text-center">{{ $user->saved_news_count }}</td>
                                <td class="px-6 py-4 text-xs text-slate-500">{{ $user->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
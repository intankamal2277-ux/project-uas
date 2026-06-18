@extends('layouts.app', ['title' => 'Masuk - BeritaKini'])

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 glass p-8 sm:p-10 rounded-2xl shadow-xl shadow-black/40">
        <div>
            <h2 class="mt-2 text-center text-3xl font-extrabold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">

                Selamat Datang Kembali
            </h2>
            <p class="mt-2 text-center text-sm text-slate-400">
                Masuk ke akun Anda untuk melihat kategori favorit dan berita tersimpan.
            </p>
        </div>

        <form class="mt-8 space-y-6" action="/login" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300">Alamat Email</label>
                    <input id="email" name="email" type="email" autocomplete="email" required 
                        value="{{ old('email') }}"
                        class="mt-1 block w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm"

                        placeholder="nama@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300">Kata Sandi</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required
                        class="mt-1 block w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm"
                        placeholder="••••••••">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember" name="remember" type="checkbox"
                        class="h-4 w-4 bg-slate-900 border-slate-800 text-indigo-600 focus:ring-indigo-500 rounded cursor-pointer">
                    <label for="remember" class="ml-2 block text-sm text-slate-400 cursor-pointer select-none">
                        Ingat saya
                    </label>
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-500/20 transition-all hover:scale-[1.01] active:scale-[0.99]">
                    Masuk
                </button>
            </div>
        </form>

        <div class="text-center text-sm text-slate-400 pt-2 border-t border-white/5">
            Belum punya akun? 
            <a href="/register" class="font-medium text-indigo-400 hover:text-indigo-300 transition-colors">Daftar sekarang</a>
        </div>
    </div>
</div>
@endsection
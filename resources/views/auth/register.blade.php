@extends('layouts.app', ['title' => 'Daftar Akun - BeritaKini'])

@section('content')
<div class="min-h-[70vh] flex items-center justify-center px-4 py-12 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 glass p-8 sm:p-10 rounded-2xl shadow-xl shadow-black/40">
        <div>
            <h2 class="mt-2 text-center text-3xl font-extrabold bg-gradient-to-r from-indigo-400 to-purple-400 bg-clip-text text-transparent">
                Daftar Akun Baru
            </h2>
            <p class="mt-2 text-center text-sm text-slate-400">
                Buat akun untuk mulai mempersonalisasi portal berita Anda.
            </p>
        </div>

        <form class="mt-8 space-y-5" action="/register" method="POST">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300">Nama Lengkap</label>
                    <input id="name" name="name" type="text" required 
                        value="{{ old('name') }}"
                        class="mt-1 block w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm"
                        placeholder="Nama Lengkap Anda">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300">Alamat Email</label>
                    <input id="email" name="email" type="email" required 
                        value="{{ old('email') }}"
                        class="mt-1 block w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm"
                        placeholder="nama@email.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300">Kata Sandi</label>
                    <input id="password" name="password" type="password" required
                        class="mt-1 block w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm"
                        placeholder="Minimal 8 karakter">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-300">Konfirmasi Kata Sandi</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="mt-1 block w-full px-4 py-3 bg-slate-900 border border-slate-800 rounded-xl text-slate-100 placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-sm"
                        placeholder="Ketik ulang kata sandi">
                </div>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-semibold rounded-xl text-white bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-lg shadow-indigo-500/20 transition-all hover:scale-[1.01] active:scale-[0.99]">
                    Daftar Akun
                </button>
            </div>
        </form>

        <div class="text-center text-sm text-slate-400 pt-2 border-t border-white/5">
            Sudah punya akun? 
            <a href="/login" class="font-medium text-indigo-400 hover:text-indigo-300 transition-colors">Masuk di sini</a>
        </div>
    </div>
</div>
@endsection
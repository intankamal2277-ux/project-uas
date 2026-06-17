<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-950 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'BeritaKini - Portal Berita Nasional' }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        .glass {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>
<body class="h-full flex flex-col font-sans antialiased selection:bg-indigo-500 selection:text-white bg-[radial-gradient(ellipse_at_top,_var(--tw-gradient-stops))] from-slate-900 via-slate-950 to-slate-950">
    
    <!-- Navbar -->
    <header class="sticky top-0 z-50 glass shadow-lg shadow-black/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Logo -->
                <div class="flex items-center gap-2">
                    <a href="/" class="flex items-center gap-2">
                        <span class="text-2xl font-bold bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 bg-clip-text text-transparent tracking-tight">
                            BeritaKini
                        </span>
                        <span class="px-2 py-0.5 text-xs font-semibold bg-indigo-500/20 text-indigo-400 rounded-full border border-indigo-500/30">
                            Portal
                        </span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <nav class="hidden md:flex items-center gap-6">
                    <a href="/" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Semua Berita</a>
                    @auth
                        <a href="/dashboard" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Dashboard</a>
                        <a href="/saved-news" class="text-sm font-medium text-slate-300 hover:text-white transition-colors flex items-center gap-1.5">
                            Berita Tersimpan
                            @if(auth()->user()->savedNews()->count() > 0)
                                <span class="bg-indigo-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">
                                    {{ auth()->user()->savedNews()->count() }}
                                </span>
                            @endif
                        </a>
                    @endauth
                </nav>

                <!-- User Controls -->
                <div class="flex items-center gap-4">
                    @auth
                        <div class="hidden sm:flex flex-col items-end text-xs">
                            <span class="font-medium text-slate-200">{{ auth()->user()->name }}</span>
                            <span class="text-slate-500">{{ auth()->user()->email }}</span>
                        </div>
                        <form action="/logout" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 text-xs font-medium bg-red-500/10 hover:bg-red-500/20 text-red-400 hover:text-red-300 rounded-lg border border-red-500/20 transition-all">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="/login" class="text-sm font-medium text-slate-300 hover:text-white transition-colors">Masuk</a>
                        <a href="/register" class="px-4 py-2 text-sm font-semibold bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-lg shadow-md shadow-indigo-500/20 transition-all hover:scale-[1.02] active:scale-[0.98]">
                            Daftar
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile Nav Bar (bottom stick) -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 z-50 glass border-t border-white/5 py-2 px-6 flex justify-around shadow-2xl">
        <a href="/" class="flex flex-col items-center gap-0.5 text-slate-400 hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 00-2 2v3a2 2 0 01-2 2h-3m-6 0a9 9 0 0018 0v-3a2 2 0 00-2-2m-2-4h.01"></path></svg>
            <span class="text-[10px]">Berita</span>
        </a>
        @auth
            <a href="/dashboard" class="flex flex-col items-center gap-0.5 text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                <span class="text-[10px]">Dashboard</span>
            </a>
            <a href="/saved-news" class="flex flex-col items-center gap-0.5 text-slate-400 hover:text-white transition-colors relative">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path></svg>
                <span class="text-[10px]">Simpanan</span>
                @if(auth()->user()->savedNews()->count() > 0)
                    <span class="absolute -top-1 -right-1.5 bg-indigo-500 text-white text-[8px] font-bold w-4 h-4 flex items-center justify-center rounded-full">
                        {{ auth()->user()->savedNews()->count() }}
                    </span>
                @endif
            </a>
        @endauth
    </div>

    <!-- Alert Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="flex items-center gap-3 p-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl mb-4 transition-all">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium">{{ session('success') }}</p>
            </div>
        @endif

        @if(session('info'))
            <div class="flex items-center gap-3 p-4 bg-blue-500/10 border border-blue-500/20 text-blue-400 rounded-xl mb-4 transition-all">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <p class="text-sm font-medium">{{ session('info') }}</p>
            </div>
        @endif

        @if($errors->any())
            <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-xl mb-4 transition-all">
                <div class="flex items-center gap-3 mb-2">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <p class="text-sm font-semibold">Terdapat kesalahan:</p>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 pl-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Content Area -->
    <main class="flex-grow pb-24 md:pb-12">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto py-6 border-t border-slate-900 bg-slate-950 text-slate-500 text-center text-xs">
        <p>&copy; 2026 BeritaKini. Dibuat dengan Laravel & ❤️.</p>
    </footer>

</body>
</html>
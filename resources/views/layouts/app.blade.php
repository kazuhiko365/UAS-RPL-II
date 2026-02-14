<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SportClub') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Poppins', sans-serif; }</style>
</head>
<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <nav class="bg-white shadow-sm sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20">
                
                {{-- LOGO --}}
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                        <div class="bg-emerald-600 text-white p-2 rounded-xl group-hover:bg-emerald-700 transition shadow-lg shadow-emerald-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="font-bold text-2xl tracking-tight text-gray-800">
                            Sports<span class="text-emerald-600">Play</span>
                        </span>
                    </a>
                    
                    {{-- MENU DESKTOP --}}
                    <div class="hidden sm:flex sm:space-x-8 sm:ml-10">
                        <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-emerald-600' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition">
                            Beranda
                        </a>

                        @auth
                            @if(!auth()->user()->isAdmin()) 
                                <a href="{{ route('cari.mabar') }}" class="{{ request()->routeIs('cari.mabar') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-emerald-600' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition">
                                    Cari Mabar
                                </a>
                                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'border-emerald-500 text-gray-900' : 'border-transparent text-gray-500 hover:text-emerald-600' }} inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium transition">
                                    Dashboard Saya
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>

                {{-- USER MENU (KANAN) --}}
                <div class="flex items-center gap-4">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <div class="text-xs bg-red-100 text-red-600 px-3 py-1 rounded-full font-bold uppercase tracking-wide">Admin Panel</div>
                        @endif
                        
                        <div class="relative group">
                            <button class="flex items-center gap-2 text-sm font-medium text-gray-700 hover:text-emerald-600 transition">
                                {{-- FOTO PROFIL --}}
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=10b981&color=fff' }}" 
                                     class="w-8 h-8 rounded-full border border-gray-200 object-cover">
                                
                                <span class="hidden md:inline">{{ Auth::user()->name }}</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </button>
                            
                            {{-- DROPDOWN MENU --}}
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 transform origin-top-right z-50 overflow-hidden">
                                
                                {{-- Link Dashboard --}}
                                @if(!auth()->user()->isAdmin())
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 font-medium">
                                        📊 Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700">Admin Dashboard</a>
                                @endif

                                {{-- LINK PENGATURAN AKUN --}}
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-3 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-700 font-medium border-t border-gray-50">
                                    👤 Pengaturan Akun
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-3 text-sm text-red-600 hover:bg-red-50 font-medium flex items-center gap-2 border-t border-gray-50">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-500 hover:text-emerald-600 font-medium text-sm">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-full text-sm font-bold shadow-lg shadow-emerald-200 transition transform hover:-translate-y-0.5">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow">
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="bg-emerald-100 border-l-4 border-emerald-500 text-emerald-700 p-4 rounded-r shadow-sm flex justify-between">
                    <p>{{ session('success') }}</p>
                    <span onclick="this.parentElement.remove()" class="cursor-pointer font-bold">&times;</span>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 mt-6">
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-r shadow-sm flex justify-between">
                    <p>{{ session('error') }}</p>
                    <span onclick="this.parentElement.remove()" class="cursor-pointer font-bold">&times;</span>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-100 mt-12">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8 flex justify-center text-gray-500 text-sm">
            <span class="font-bold text-gray-800">SportClub &copy; {{ date('Y') }}</span>
        </div>
    </footer>
    @stack('scripts')
</body>
</html>
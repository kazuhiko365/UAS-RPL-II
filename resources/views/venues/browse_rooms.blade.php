@extends('layouts.app')
@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

        <div class="mb-6">
            <h1 class="text-3xl font-bold text-gray-900">Cari Teman Mabar</h1>
            <p class="text-gray-500">Temukan room yang tersedia di lapangan favoritmu.</p>
        </div>

        <!-- Banner Kode Undangan -->
        <div
            class="bg-gradient-to-r from-emerald-600 to-teal-500 rounded-2xl shadow-lg p-6 mb-8 text-white flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
            <div
                class="absolute top-0 right-0 -mr-10 -mt-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl pointer-events-none">
            </div>

            <div class="relative z-10">
                <h2 class="text-2xl font-bold flex items-center gap-2">
                    <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                        </path>
                    </svg>
                    Punya Kode Undangan?
                </h2>
                <p class="text-emerald-100 text-sm mt-1">Masukan 6 digit kode unik dari temanmu untuk langsung bergabung.
                </p>
            </div>

            <form action="{{ route('rooms.join_code') }}" method="POST" class="flex w-full md:w-auto gap-2 relative z-10">
                @csrf
                <input type="text" name="code" placeholder="CONTOH: X7K9LP"
                    class="w-full md:w-64 px-5 py-3 rounded-xl text-gray-800 font-bold uppercase tracking-widest focus:outline-none focus:ring-4 focus:ring-emerald-300 shadow-md placeholder-gray-400"
                    required>
                <button
                    class="bg-gray-900 hover:bg-black text-white font-bold px-6 py-3 rounded-xl shadow-md transition transform active:scale-95 flex items-center gap-2">
                    GABUNG
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6">
                        </path>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Search & Filter Section -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Cari Room Manual</h3>

            <form action="{{ route('cari.mabar') }}" method="GET">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-5 items-end">

                    <!-- Search Bar Room -->
                    <div class="md:col-span-5">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Cari Nama Room /
                            Lapangan</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" name="keyword" value="{{ request('keyword') }}"
                                class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 pl-10 pr-4 rounded-xl focus:outline-none focus:border-emerald-500 transition"
                                placeholder="Contoh: Badminton Bandung..." autocomplete="off">
                        </div>
                    </div>

                    <!-- Filters -->
                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Olahraga</label>
                        <select name="sport_id"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:border-emerald-500 cursor-pointer">
                            <option value="">Semua Olahraga</option>
                            @foreach($sports as $s)
                                <option value="{{ $s->id }}" {{ request('sport_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Kota</label>
                        <select name="city"
                            class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:border-emerald-500 cursor-pointer">
                            <option value="">Semua Kota</option>
                            @foreach($cities as $c)
                                <option value="{{ $c }}" {{ request('city') == $c ? 'selected' : '' }}>{{ $c }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Button -->
                    <div class="md:col-span-1">
                        <button type="submit"
                            class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg transition transform active:scale-95 flex justify-center items-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- List Venues -->
        <div class="space-y-6">
            <div class="flex justify-between items-center">
                <h3 class="font-bold text-xl text-gray-800">Daftar Lapangan & Room</h3>
                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">{{ count($venues) }}
                    Tempat Ditemukan</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($venues as $venue)
                    <div
                        class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition group h-full flex flex-col">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h4
                                    class="font-bold text-lg text-gray-900 group-hover:text-emerald-600 transition line-clamp-1">
                                    {{ $venue->name }}</h4>
                                <p class="text-sm text-gray-500 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    {{ $venue->city }}
                                </p>
                            </div>
                        </div>

                        <div class="flex-grow">
                            <p class="text-xs text-gray-400 mb-4 line-clamp-2">{{ $venue->address }}</p>

                            <!-- Preview Rooms info -->
                            @if($venue->rooms->count() > 0)
                                <div class="bg-gray-50 rounded-lg p-3 text-xs text-gray-600">
                                    <span class="font-bold block mb-1">Room Tersedia:</span>
                                    <ul class="space-y-1">
                                        @foreach($venue->rooms->where('is_active', true)->where('start_datetime', '>=', now())->take(2) as $room)
                                            <li class="truncate flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                                {{ $room->title }} -
                                                {{ \Carbon\Carbon::parse($room->start_datetime)->format('d M H:i') }}
                                            </li>
                                        @endforeach
                                        @php 
                                            $remaining = $venue->rooms->where('is_active', true)->where('start_datetime', '>=', now())->count() - 2; 
                                        @endphp
                                        @if($remaining > 0)
                                            <li class="text-emerald-600 font-bold pl-2.5">+ {{ $remaining }} lainnya</li>
                                        @endif
                                    </ul>
                                </div>
                            @else
                                <div class="bg-red-50 text-red-600 rounded-lg p-2 text-xs font-bold text-center">
                                    Tidak ada room aktif saat ini
                                </div>
                            @endif
                        </div>


                        <a href="{{ route('venues.rooms', $venue->id) }}" class="mt-4 block w-full text-center bg-white border-2 border-emerald-600 text-emerald-600 hover:bg-emerald-600 hover:text-white py-2.5 rounded-xl font-bold transition">
                            Lihat Semua Room
                        </a>
                    </div>
                @empty



                                    <div class="col-span-full text-center p-12 bg-gray-50 rounded-3xl border border-dashed border-gray-300">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-lg font-bold text-gray-500">Tidak ada room ditemukan.</p>
                        <p class="text-sm text-gray-400">Coba ubah kata kunci atau filter pencarian.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
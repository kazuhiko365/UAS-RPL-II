@extends('layouts.app')

@section('content')

    @php
        $dataTitipan = request()->only([
            'title',
            'description',
            'start_datetime',
            'max_participants',
            'cost_per_person',
            'sport_id'
        ]);
    @endphp

    <div class="container mx-auto px-4 py-6">

        <div class="bg-white p-6 rounded-3xl shadow-lg mb-6 border border-gray-100">
            <h2 class="text-xl font-bold mb-4 flex items-center text-gray-800">
                <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                Pilih Lokasi Lapangan
            </h2>

            <form id="searchForm" method="GET" action="{{ route('venues.search') }}"
                class="grid grid-cols-1 md:grid-cols-12 gap-4">

                @foreach($dataTitipan as $key => $value)
                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                @endforeach

                <div class="md:col-span-4">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pilih Kota</label>
                    <div class="relative">
                        <select name="city"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:ring-emerald-500 focus:border-emerald-500 appearance-none font-bold text-gray-700 cursor-pointer">
                            <option value="">Semua Kota</option>
                            @foreach($cities as $city)
                                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                                    {{ $city }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="md:col-span-6">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama / Alamat Lapangan</label>
                    <div class="relative">
                        <input type="text" name="keyword" value="{{ request('keyword') }}"
                            class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-4 pr-4 py-2.5 text-sm focus:ring-emerald-500 focus:border-emerald-500 font-medium"
                            placeholder="Cari berdasarkan nama atau alamat...">
                    </div>
                </div>

                <div class="md:col-span-2 flex items-end">
                    <button type="submit"
                        class="w-full bg-gray-800 text-white py-2.5 rounded-xl hover:bg-black font-bold shadow-md transition text-sm flex justify-center items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-3xl shadow-md border border-gray-200 overflow-hidden">
            <div class="p-4 bg-gray-50 border-b flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Hasil Pencarian</h3>
                <span
                    class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">{{ $venues->count() }}
                    Lokasi</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 p-4">
                @forelse($venues as $venue)
                    <div
                        class="border border-gray-100 rounded-2xl p-4 hover:shadow-md hover:border-emerald-200 transition bg-white group h-full flex flex-col justify-between">
                        <div>
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-bold text-gray-900 group-hover:text-emerald-600 transition text-lg">
                                        {{ $venue->name }}</h4>
                                    <p class="text-sm text-gray-500 mb-2">{{ $venue->city }}</p>
                                </div>
                            </div>

                            <div class="flex items-center space-x-3 mt-1">
                                <div class="flex items-center bg-yellow-50 px-2 py-0.5 rounded-md border border-yellow-100">
                                    <span class="text-xs font-bold text-gray-700">★ {{ $venue->rating }}</span>
                                </div>
                                <div class="text-xs font-bold text-gray-600">
                                    Rp {{ number_format($venue->price_per_hour, 0, ',', '.') }} / jam
                                </div>
                            </div>

                            <p class="text-xs text-gray-400 mt-2 line-clamp-2">{{ $venue->address }}</p>
                        </div>

                        <button type="button" onclick="selectVenue({{ $venue->id }})"
                            class="block mt-4 w-full bg-emerald-600 text-white hover:bg-emerald-700 py-2.5 rounded-xl text-sm font-bold transition shadow-sm">
                            Pilih Lapangan Ini
                        </button>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center h-40 text-gray-400">
                        <p class="text-sm">Tidak ada lapangan ditemukan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        // VITAL: Inject saved PHP data into JavaScript
        const savedInputs = @json($dataTitipan);
        const createRoomBaseUrl = "{{ route('rooms.create') }}";

        // --- URL CONSTRUCTION LOGIC ---
        function getFinalUrl(venueId) {
            const params = new URLSearchParams(savedInputs);
            params.set('venue_id', venueId);
            return `${createRoomBaseUrl}?${params.toString()}`;
        }

        // Function triggered by clicking "Pilih Lapangan Ini"
        function selectVenue(venueId) {
            window.location.href = getFinalUrl(venueId);
        }
    </script>
@endsection
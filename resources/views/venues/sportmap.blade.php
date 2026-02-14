@extends('layouts.app')
@section('content')

<style>
    /* Update CSS Marker jadi Hijau */
    .number-icon {
        background-color: #10b981; /* emerald-500 */
        color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 30px;
        font-weight: bold;
        border: 2px solid white;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: transform 0.2s;
    }
    .number-icon:hover {
        transform: scale(1.1);
        background-color: #059669; /* emerald-600 */
    }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Peta Lapangan</h1>
        <p class="text-gray-500">Cari lapangan terdekat dan termurah di sekitar Anda.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-50 rounded-full -mr-10 -mt-10 opacity-50"></div>
        
        <form action="{{ route('cari.lapangan') }}" method="GET" id="searchForm">
            <input type="hidden" name="lat" id="lat" value="{{ request('lat') }}">
            <input type="hidden" name="lng" id="lng" value="{{ request('lng') }}">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-5">
                
                <div class="lg:col-span-1">
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Olahraga</label>
                    <div class="relative">
                        <select name="sport_id" class="w-full appearance-none bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl leading-tight focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                            <option value="">Semua</option>
                            @foreach($sports as $s)
                                <option value="{{ $s->id }}" {{ request('sport_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Radius (km)</label>
                    <input type="number" name="radius" value="{{ request('radius', 10) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Harga Min</label>
                    <input type="number" name="price_min" placeholder="0" value="{{ request('price_min') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Harga Max</label>
                    <input type="number" name="price_max" placeholder="Max" value="{{ request('price_max') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">Rating Min</label>
                    <input type="number" step="0.1" max="5" name="rating_min" placeholder="0 - 5" value="{{ request('rating_min') }}" class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-xl focus:outline-none focus:bg-white focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
                </div>

                <div class="flex items-end">
                    <button type="button" onclick="getLocation()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-emerald-200 transition transform active:scale-95 flex justify-center items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 order-2 lg:order-1 h-[600px] bg-white rounded-3xl shadow-lg border border-gray-200 overflow-hidden relative z-0">
            <div id="map" class="w-full h-full z-0"></div>
            <div id="loading-map" class="absolute inset-0 bg-white/80 z-10 hidden flex-col items-center justify-center">
                <svg class="animate-spin h-10 w-10 text-emerald-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-emerald-700 font-bold">Mencari Lokasi...</span>
            </div>
        </div>

        <div class="order-1 lg:order-2 space-y-4">
            <div class="flex justify-between items-center mb-2">
                <h3 class="font-bold text-xl text-gray-800">Hasil Pencarian</h3>
                <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">{{ count($venues) }} Tempat</span>
            </div>

            <div class="h-[550px] overflow-y-auto pr-2 space-y-4 custom-scrollbar">
                @forelse($venues as $index => $venue)
                <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-100 hover:shadow-md hover:border-emerald-200 transition cursor-pointer group"
                     onclick="focusVenue({{ $venue->latitude }}, {{ $venue->longitude }})">
                    
                    <div class="flex gap-4">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 flex items-center justify-center rounded-xl font-bold text-lg group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                                {{ $index + 1 }}
                            </div>
                        </div>
                        
                        <div class="flex-grow">
                            <div class="flex justify-between items-start">
                                <h4 class="font-bold text-gray-900 group-hover:text-emerald-600 transition line-clamp-1">{{ $venue->name }}</h4>
                                <div class="flex items-center text-xs font-bold text-yellow-500 bg-yellow-50 px-2 py-0.5 rounded-lg">
                                    <span>★ {{ $venue->rating }}</span>
                                </div>
                            </div>
                            
                            <p class="text-xs text-gray-500 mt-1 line-clamp-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                {{ $venue->city }}
                            </p>

                            <div class="flex justify-between items-center mt-3">
                                <span class="text-sm font-bold text-emerald-600">
                                    Rp {{ number_format($venue->price_per_hour/1000, 0) }}rb<span class="text-gray-400 text-xs font-normal">/jam</span>
                                </span>
                                @if(isset($venue->distance))
                                <span class="text-xs text-blue-600 bg-blue-50 px-2 py-1 rounded-md font-medium">
                                    {{ number_format($venue->distance, 1) }} km
                                </span>
                                @endif
                            </div>

                            <a href="{{ route('rooms.create', ['venue_id' => $venue->id]) }}" class="mt-3 block w-full text-center bg-gray-50 text-gray-600 hover:bg-emerald-600 hover:text-white py-2 rounded-lg text-xs font-bold transition">
                                Pilih Lapangan Ini
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-64 text-center text-gray-400">
                    <svg class="w-12 h-12 mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p>Tidak ada lapangan ditemukan.</p>
                    <p class="text-xs mt-1">Coba perbesar radius atau ganti filter.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([-6.9175, 107.6191], 13);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    var venues = @json($venues);
    var userLat = "{{ request('lat') }}";
    var userLng = "{{ request('lng') }}";

    // Icon User (Biru Custom)
    var userIcon = L.divIcon({
        className: 'bg-transparent',
        html: '<div class="w-6 h-6 bg-blue-500 rounded-full border-2 border-white shadow-lg animate-pulse"></div>',
        iconSize: [24, 24]
    });

    if(userLat && userLng) {
        L.marker([userLat, userLng], {icon: userIcon}).addTo(map)
            .bindPopup("<b>Lokasi Anda</b>").openPopup();
        map.setView([userLat, userLng], 13);
    }

    venues.forEach((venue, index) => {
        var number = index + 1;
        var iconNumber = L.divIcon({
            className: 'custom-div-icon',
            html: `<div class="number-icon">${number}</div>`,
            iconSize: [30, 30],
            iconAnchor: [15, 15]
        });

        var marker = L.marker([venue.latitude, venue.longitude], {icon: iconNumber})
            .addTo(map)
            .bindPopup(`
                <div class="text-center">
                    <b class="text-emerald-700">${venue.name}</b><br>
                    <span class="text-xs text-gray-500">${venue.address}</span><br>
                    <a href="/rooms/create?venue_id=${venue.id}" class="mt-2 inline-block bg-emerald-600 text-white text-xs px-3 py-1 rounded">Pilih</a>
                </div>
            `);
    });

    function getLocation() {
        document.getElementById('loading-map').classList.remove('hidden');
        document.getElementById('loading-map').classList.add('flex');
        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError);
        } else {
            alert("Geolocation tidak didukung browser ini.");
        }
    }

    function showPosition(position) {
        document.getElementById('lat').value = position.coords.latitude;
        document.getElementById('lng').value = position.coords.longitude;
        document.getElementById('searchForm').submit();
    }

    function showError(error) {
        alert("Gagal mengambil lokasi. Pastikan GPS aktif.");
        document.getElementById('loading-map').classList.add('hidden');
        document.getElementById('searchForm').submit();
    }

    function focusVenue(lat, lng) {
        map.flyTo([lat, lng], 16);
    }
</script>
@endsection
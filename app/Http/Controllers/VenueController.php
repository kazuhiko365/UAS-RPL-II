<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Sport;

class VenueController extends Controller
{
    /**
     * AJAX Endpoint: Get Venues by Sport ID
     */
    public function filterBySport(Request $request)
    {
        $sportId = $request->get('sport_id');

        $query = Venue::query()->select('id', 'name', 'city');

        if ($sportId) {
            $query->whereHas('sports', function ($q) use ($sportId) {
                $q->where('sports.id', $sportId);
            });
        }

        $venues = $query->orderBy('city')->orderBy('name')->get();

        return response()->json($venues);
    }

    /**
     * 1. PENCARIAN LAPANGAN (Digunakan saat Create Room)
     * Logika Baru: Hanya Filter Kota, Keyword Nama, dan Urutan Terdekat.
     */
    public function search(Request $request)
    {
        // A. Ambil Parameter
        // A. Ambil Parameter
        $city = $request->get('city');         // Filter Baru: Kota
        $keyword = $request->get('keyword');   // Filter Baru: Cari Nama/Alamat
        $sportId = $request->get('sport_id');  // Filter Baru: Sport ID (PENTING)

        // B. Query Dasar
        $query = Venue::query();
        $query->select('venues.*');

        // --- FILTER KOTA ---
        if ($request->filled('city')) {
            $query->where('city', $city);
        }

        // --- FILTER SPORT (RELASI PIVOT) ---
        if ($request->filled('sport_id')) {
            $query->whereHas('sports', function ($q) use ($sportId) {
                $q->where('sports.id', $sportId);
            });
        }

        // --- FILTER KEYWORD (Nama atau Alamat) ---
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                    ->orWhere('address', 'like', "%{$keyword}%");
            });
        }

        // --- SORTING (URUTAN) ---
        // Jika TIDAK ada lokasi -> Urutkan Abjad Kota lalu Nama Venue
        $query->orderBy('city', 'asc')
            ->orderBy('name', 'asc');

        // C. Eksekusi Query
        $venues = $query->get();

        // Ambil daftar kota unik untuk Dropdown Filter
        $cities = Venue::select('city')->distinct()->orderBy('city')->pluck('city');

        // Tetap kirim $sports (meskipun tidak dipakai filter, siapa tau view butuh)
        $sports = Sport::all();

        // D. Tampilkan View
        return view('venues.map_search', compact('venues', 'cities', 'sports'));
    }

    /**
     * 2. PENCARIAN ROOM UNTUK JOINER (Fitur Cari Mabar di Navbar)
     * Menampilkan daftar Venue yang MEMILIKI Room Aktif.
     */
    public function searchForJoin(Request $request)
    {
        $sportId = $request->get('sport_id');
        $city = $request->get('city');
        $keyword = $request->get('keyword'); // New Filter: Keyword (Room Title or Venue Name)

        $query = Venue::query()->select('venues.*');

        // Filter: Hanya Venue yang punya Room Aktif (Upcoming)
        $query->whereHas('rooms', function ($q) use ($sportId, $keyword) {
            $q->where('is_active', true)
                ->where('start_datetime', '>=', now()); // Hanya room masa depan

            if ($sportId) {
                $q->where('sport_id', $sportId);
            }

            // Optional: Filter by Room properties if needed (e.g. title)
            if ($keyword) {
                // We use use($keyword) here to filter rooms if desired,
                // OR we can rely on the Venue-level filter below.
                // Let's allow searching matching Room Titles:
                $q->where(function ($subQ) use ($keyword) {
                    $subQ->where('title', 'like', "%{$keyword}%");
                });
            }
        });

        // Filter Kota
        if ($city) {
            $query->where('city', $city);
        }

        // Filter Keyword (Venue Name OR Room Title - handled via orWhereHas)
        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%") // Search Venue Name
                    ->orWhereHas('rooms', function ($rq) use ($keyword) { // Search Room Title
                        $rq->where('title', 'like', "%{$keyword}%")
                            ->where('is_active', true)
                            ->where('start_datetime', '>=', now());
                    });
            });
        }

        // Default Sorting: Latest Rooms or Alphabetical
        $query->orderBy('name', 'asc');

        $venues = $query->get();
        $sports = Sport::all();
        $cities = Venue::select('city')->distinct()->pluck('city');

        return view('venues.browse_rooms', compact('venues', 'sports', 'cities'));
    }

    /**
     * 3. Menampilkan Daftar Room di dalam Satu Venue
     */
    public function showVenueRooms(Venue $venue)
    {
        // Ambil room yang aktif & belum lewat
        $rooms = $venue->rooms()
            ->where('is_active', true)
            ->where('start_datetime', '>=', now())
            ->with(['host', 'sport'])
            ->orderBy('start_datetime', 'asc')
            ->get();

        return view('venues.room_list', compact('venue', 'rooms'));
    }

    /**
     * 4. Placeholder
     */
    public function searchMap(Request $request)
    {
        return $this->search($request);
    }
}
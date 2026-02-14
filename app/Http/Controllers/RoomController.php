<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Sport;
use App\Models\Venue;
use App\Models\RoomParticipant;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display a listing of active rooms with filters.
     */
    public function index(Request $request)
    {
        $rooms = $this->getFilteredRooms($request);
        $sports = Sport::all();
        $cities = Venue::distinct()->pluck('city');
        $stat_interaksi = $this->getUserInteractionStats();

        return view('rooms.index', compact('rooms', 'sports', 'cities', 'stat_interaksi'));
    }

    /**
     * Show the form for creating a new room.
     */
    public function create(Request $request)
    {
        $sports = Sport::all();
        $venues = Venue::all();
        $selectedVenueId = $request->get('venue_id');

        return view('rooms.create', compact('sports', 'venues', 'selectedVenueId'));
    }

    /**
     * Store a newly created room in storage.
     */
    public function store(Request $request)
    {
        $validated = $this->validateRoomData($request);

        // Cek bentrok hanya untuk User biasa
        if (!$this->isAdmin() && $this->hasScheduleConflict($request->start_datetime)) {
            return back()->withInput()->withErrors([
                'start_datetime' => 'Anda sudah memiliki jadwal Room di waktu yang persis sama!'
            ]);
        }

        $room = $this->createRoomWithParticipant($validated); // Perhatikan $room diassign di sini

        return $this->redirectAfterStore($room); // Redirect menggunakan objek room yang baru dibuat
    }

    /**
     * Display the specified room.
     */
    public function show(Room $room)
    {
        // PERBAIKAN: Load relasi dengan huruf kecil (sport)
        $room->load(['host', 'venue', 'sport', 'participants.user']);
        
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified room.
     */
    public function edit(Room $room)
    {
        $this->authorizeRoomAccess($room);

        $sports = Sport::all();
        $venues = Venue::all();

        return view('rooms.edit', compact('room', 'sports', 'venues'));
    }

    /**
     * Update the specified room in storage.
     */
    public function update(Request $request, Room $room)
    {
        $this->authorizeRoomAccess($room);

        $validated = $this->validateRoomData($request, false);
        $room->update($validated);

        return $this->redirectAfterUpdate();
    }

    /**
     * Remove the specified room from storage.
     */
    public function destroy(Room $room)
    {
        $this->authorizeRoomAccess($room);

        $room->delete();

        return back()->with('success', 'Room berhasil dihapus.');
    }

    /**
     * Join a room by code.
     */
    public function joinByCode(Request $request)
    {
        $request->validate(['code' => 'required|string']);

        if ($this->isAdmin()) {
            return back()->with('error', 'Admin hanya bisa memantau, tidak bisa join room.');
        }

        $room = $this->findActiveRoomByCode($request->code);

        if (!$room) {
            return back()->with('error', 'Kode Room tidak valid atau Room sudah selesai.');
        }

        return redirect()->route('rooms.show', $room)
            ->with('info', 'Room ditemukan! Silakan klik tombol Gabung.');
    }

    // ==========================================================
    //                        PRIVATE HELPERS
    // ==========================================================

    /**
     * Get filtered rooms based on request parameters.
     */
    private function getFilteredRooms(Request $request)
    {
        $query = Room::query()
            ->where('is_active', true)
            ->where('start_datetime', '>=', now()->subHours(2)) // 2 Jam Rule
            ->with(['venue', 'sport', 'host']);

        $this->applyFilters($query, $request);
        $this->applySorting($query, $request);

        return $query->paginate(12)->withQueryString();
    }

    /**
     * Apply filters to the room query.
     */
    private function applyFilters($query, Request $request)
    {
        if ($request->filled('sport')) {
            $query->where('sport_id', $request->sport);
        }

        if ($request->filled('city')) {
            $query->whereHas('venue', fn($q) => $q->where('city', $request->city));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhereHas('venue', fn($v) => $v->where('name', 'like', "%{$search}%"));
            });
        }
    }

    /**
     * Apply sorting to the room query.
     */
    private function applySorting($query, Request $request)
    {
        if ($request->filled('lat') && $request->filled('lng')) {
            // Asumsi scope nearby sudah didefinisikan di Room Model
            $query->nearby($request->lat, $request->lng); 
        } else {
            $query->orderBy('start_datetime', 'asc');
        }
    }

    /**
     * Get user interaction statistics.
     */
    private function getUserInteractionStats(): int
    {
        if (!Auth::check()) {
            return 0;
        }

        $hosted = Room::where('host_id', Auth::id())->count();
        $joined = RoomParticipant::where('user_id', Auth::id())->count();

        return $hosted + $joined;
    }

    /**
     * Validate room data from request.
     */
    private function validateRoomData(Request $request, bool $isCreating = true): array
    {
        $rules = [
            'sport_id' => 'required|exists:sports,id',
            'venue_id' => 'required|exists:venues,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_datetime' => 'required|date',
            'max_participants' => 'required|integer|min:2',
            'cost_per_person' => 'required|numeric|min:0',
        ];

        if ($isCreating) {
            $rules['start_datetime'] .= '|after:now'; // Hanya di form Create
        }

        return $request->validate($rules);
    }

    /**
     * Check if current user has a schedule conflict.
     */
    private function hasScheduleConflict(string $startDatetime): bool
    {
        return Room::where('host_id', Auth::id())
            ->where('is_active', true)
            ->where('start_datetime', $startDatetime)
            ->exists();
    }

    /**
     * Create room with participant in a transaction.
     */
    private function createRoomWithParticipant(array $validated): Room // Return Room object
    {
        return DB::transaction(function () use ($validated) {
            $room = Room::create([
                ...$validated,
                'host_id' => Auth::id(),
                'is_active' => true,
                'code' => strtoupper(Str::random(6)),
            ]);

            if (!$this->isAdmin()) {
                $this->addHostAsParticipant($room);
            }

            $this->logRoomCreation($room);

            return $room;
        });
    }

    /**
     * Add host as confirmed participant.
     */
    private function addHostAsParticipant(Room $room): void
    {
        RoomParticipant::create([
            'room_id' => $room->id,
            'user_id' => Auth::id(),
            'status' => 'confirmed',
            'responded_at' => now(),
        ]);
    }

    /**
     * Log room creation activity.
     */
    private function logRoomCreation(Room $room): void
    {
        ActivityLog::create([
            'actor_id' => Auth::id(),
            'action' => 'room_created',
            'subject_type' => Room::class,
            'subject_id' => $room->id
        ]);
    }

    /**
     * Authorize user access to room.
     */
    private function authorizeRoomAccess(Room $room): void
    {
        if (!$this->isAdmin() && Auth::id() !== $room->host_id) {
            abort(403, 'Anda tidak memiliki akses ke room ini.');
        }
    }

    /**
     * Find active room by code.
     */
    private function findActiveRoomByCode(string $code): ?Room
    {
        return Room::where('code', $code)
            ->where('is_active', true)
            ->where('start_datetime', '>=', now()->subHours(2))
            ->first();
    }

    /**
     * Check if current user is admin.
     */
    private function isAdmin(): bool
    {
        return Auth::user()->role === 'admin';
    }

    /**
     * Redirect after successful room creation.
     */
    private function redirectAfterStore(Room $room)
    {
        $route = $this->isAdmin() ? 'admin.dashboard' : 'rooms.show'; // Redirect ke rooms.show
        $target = $this->isAdmin() ? null : $room;
        
        $message = $this->isAdmin() 
            ? 'Room berhasil dibuat oleh Admin.' 
            : 'Room berhasil dibuat & Anda otomatis bergabung!';

        return redirect()->route($route, $target)->with('success', $message);
    }

    /**
     * Redirect after successful room update.
     */
    private function redirectAfterUpdate()
    {
        $route = $this->isAdmin() ? 'admin.dashboard' : 'dashboard';
        $message = $this->isAdmin() 
            ? 'Room diperbarui oleh Admin!' 
            : 'Room berhasil diperbarui!';

        return redirect()->route($route)->with('success', $message);
    }
}
<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Controllers
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ForgotPasswordController; // Tambahan Baru
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RoomParticipantController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HistoryController;

// =================================================================
// 1. PUBLIC ROUTES (Bisa diakses siapa saja)
// =================================================================

// Landing Page: Halaman promosi awal
Route::get('/', function () {
    return view('landing');
})->name('landing');

// Main App: Daftar Room Aktif (Dulu ini halaman utama '/')
Route::get('/explore', [RoomController::class, 'index'])->name('home');

// Pencarian Lapangan (Peta & List)
Route::get('/venues/search', [VenueController::class, 'search'])->name('venues.search');
Route::get('/cari-lapangan', [VenueController::class, 'searchMap'])->name('cari.lapangan');

// Pencarian Room Mabar (Untuk Joiner)
Route::get('/cari-mabar', [VenueController::class, 'searchForJoin'])->name('cari.mabar');
Route::get('/venues/filter-by-sport', [VenueController::class, 'filterBySport'])->name('venues.filterBySport'); // NEW AJAX
Route::get('/venues/{venue}/rooms', [VenueController::class, 'showVenueRooms'])->name('venues.rooms');


// =================================================================
// 2. GUEST AUTH ROUTES (Hanya untuk yang belum login)
// =================================================================
Route::middleware('guest')->group(function () {

    // --- LOGIN & REGISTER ---
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // --- GOOGLE SOCIALITE ---
    Route::get('/auth/google/redirect', [SocialAuthController::class, 'redirect'])->name('google.redirect');
    Route::get('/auth/google/callback', [SocialAuthController::class, 'callback']);

    // --- FORGOT PASSWORD (FITUR BARU) ---
    // 1. Form minta link
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
        ->name('password.request');

    // 2. Proses kirim email
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
        ->name('password.email');

    // 3. Form ganti password (Link dari email mengarah ke sini)
    Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])
        ->name('password.reset');

    // 4. Proses update password baru
    Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])
        ->name('password.update');
});


// =================================================================
// 3. AUTHENTICATED ROUTES (Wajib Login)
// =================================================================
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // --- PROFILE & ACCOUNT SETTINGS ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Hapus Akun

    // --- USER DASHBOARD (Statistik & Jadwal Saya) ---
    Route::get('/dashboard', function () {
        $user = Auth::user();

        // Statistik
        $hostedCount = \App\Models\Room::where('host_id', $user->id)->count();
        $joinedCount = \App\Models\RoomParticipant::where('user_id', $user->id)->count();

        // Room yang Saya Host (Upcoming / Baru Lewat 2 Jam)
        $myRooms = \App\Models\Room::where('host_id', $user->id)
            ->where('start_datetime', '>=', now()->subHours(2))
            ->with(['sport', 'venue', 'participants'])
            ->orderBy('start_datetime', 'asc')
            ->get();

        // Room yang Saya Ikuti (Upcoming / Baru Lewat 2 Jam)
        $joinedRooms = \App\Models\RoomParticipant::where('user_id', $user->id)
            ->whereHas('room', function ($q) {
                $q->where('start_datetime', '>=', now()->subHours(2));
            })
            ->with(['room.sport', 'room.venue', 'room.host'])
            ->latest()
            ->get();

        return view('user.dashboard', compact('hostedCount', 'joinedCount', 'myRooms', 'joinedRooms'));
    })->name('dashboard');

    // --- HISTORY PAGE (Riwayat Mabar Lampau) ---
    Route::get('/history', [HistoryController::class, 'index'])->name('history.index');

    // --- ROOM MANAGEMENT (CRUD) ---
    Route::get('/rooms/create', [RoomController::class, 'create'])->name('rooms.create');
    Route::post('/rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show'); // Detail Room

    Route::get('/rooms/{room}/edit', [RoomController::class, 'edit'])->name('rooms.edit');
    Route::put('/rooms/{room}', [RoomController::class, 'update'])->name('rooms.update');
    Route::delete('/rooms/{room}', [RoomController::class, 'destroy'])->name('rooms.destroy');

    // --- JOIN & PARTICIPANTS ---
    // Join via Tombol
    Route::post('/rooms/{room}/join', [RoomParticipantController::class, 'join'])->name('rooms.join');
    // Join via Kode Unik
    Route::post('/rooms/join-code', [RoomController::class, 'joinByCode'])->name('rooms.join_code');
    // Host Confirm Participant (Manual di Web)
    Route::post('/rooms/{room}/participants/{participant}/confirm', [RoomParticipantController::class, 'confirm'])->name('participants.confirm');

    // --- ADMIN AREA ---
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
        Route::get('/users', [AdminController::class, 'users'])->name('users');
        Route::get('/activity', [AdminController::class, 'activityLogs'])->name('activity');
        Route::resource('sports', SportController::class);
    });
});


// =================================================================
// 4. MAGIC LINK ROUTE (NO LOGIN REQUIRED)
// =================================================================
// Fitur canggih: Host bisa klik tombol 'Terima' langsung dari email notifikasi
// tanpa harus login ke aplikasi. Keamanan dijaga oleh signature URL.
Route::get(
    '/participants/{participant}/confirm-email',
    [RoomParticipantController::class, 'confirmFromEmail']
)->name('participants.confirm_email')
    ->middleware('signed');
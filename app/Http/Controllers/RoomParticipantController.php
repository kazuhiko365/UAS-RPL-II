<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomParticipant;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\RoomJoinRequest;
use App\Mail\RoomJoinConfirmed;

class RoomParticipantController extends Controller
{
    // =================================================================
    // 1. PROSES USER MINTA JOIN (DARI TOMBOL GABUNG)
    // =================================================================
    public function join(Request $request, Room $room)
    {
        $user = Auth::user();

        // 1. CEK LOGIN
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk bergabung.');
        }

        // 2. CEK WAKTU (ROOM CLOSED) - PERBAIKAN UTAMA
        // Jika waktu sekarang sudah melewati waktu mulai, tolak join.
        if (now() >= $room->start_datetime) {
            return back()->with('error', 'Maaf, aktivitas ini sudah dimulai/berakhir. Room Closed!');
        }

        // 3. CEK ROLE ADMIN
        if ($user->role === 'admin') {
            return back()->with('error', 'Admin hanya memantau, tidak diperbolehkan ikut bermain.');
        }

        // 4. CEK HOST (Host tidak perlu join lagi)
        if ($room->host_id === $user->id) {
            return back()->with('info', 'Anda adalah Host room ini.');
        }

        // 5. CEK APAKAH SUDAH JOIN (Double Join Prevention)
        $isJoined = $room->participants()->where('user_id', $user->id)->exists();
        if ($isJoined) {
            return back()->with('info', 'Anda sudah terdaftar atau menunggu konfirmasi di room ini.');
        }

        // 6. CEK SLOT PENUH
        if ($room->participants()->count() >= $room->max_participants) {
            return back()->with('error', 'Mohon maaf, kuota peserta sudah penuh.');
        }

        // 7. SIMPAN DATA PESERTA (Status: pending)
        $participant = $room->participants()->create([
            'user_id' => $user->id,
            'status' => 'requested', // Status awal menunggu konfirmasi host
            'requested_at' => now()
        ]);

        // 8. KIRIM NOTIFIKASI EMAIL KE HOST
        if ($room->host->email) {
            try {
                Mail::to($room->host->email)->send(new RoomJoinRequest($participant));
            } catch (\Exception $e) {
                Log::error('Gagal kirim email join request ke host: ' . $e->getMessage());
            }
        }

        // 9. LOG AKTIVITAS
        ActivityLog::create([
            'actor_id' => $user->id,
            'action' => 'join_requested',
            'subject_type' => Room::class,
            'subject_id' => $room->id
        ]);

        return back()->with('success', 'Permintaan bergabung berhasil dikirim! Menunggu konfirmasi Host.');
    }

    // =================================================================
    // 2. KONFIRMASI VIA MAGIC LINK EMAIL (TANPA LOGIN)
    // =================================================================
    public function confirmFromEmail(RoomParticipant $participant)
    {
        // A. Cek Idempotency (Jika sudah dikonfirmasi sebelumnya)
        if ($participant->status === 'confirmed') {
            return view('pages.confirmation_success', compact('participant'));
        }

        // B. Update Status Database
        $participant->update([
            'status' => 'confirmed',
            'responded_at' => now()
        ]);

        // C. Kirim Notifikasi Balasan ke Peserta
        $this->notifyParticipant($participant);

        // D. Catat Log (Atas nama Host)
        ActivityLog::create([
            'actor_id' => $participant->room->host_id,
            'action' => 'join_confirmed_via_email',
            'subject_type' => Room::class,
            'subject_id' => $participant->room->id,
            'meta' => json_encode(['participant_user_id' => $participant->user_id])
        ]);

        // E. Tampilkan Halaman Sukses
        return view('pages.confirmation_success', compact('participant'));
    }

    // =================================================================
    // 3. KONFIRMASI VIA DASHBOARD (MANUAL - WAJIB LOGIN)
    // =================================================================
    public function confirm(Room $room, RoomParticipant $participant)
    {
        // Validasi Host
        if (Auth::id() !== $room->host_id) {
            abort(403, 'Anda bukan host room ini.');
        }

        // Update Status
        $participant->update([
            'status' => 'confirmed',
            'responded_at' => now()
        ]);

        // Kirim Notifikasi
        $this->notifyParticipant($participant);

        // Catat Log
        ActivityLog::create([
            'actor_id' => Auth::id(),
            'action' => 'join_confirmed',
            'subject_type' => Room::class,
            'subject_id' => $room->id,
            'meta' => json_encode(['participant_user_id' => $participant->user_id])
        ]);

        return back()->with('success', 'Peserta berhasil dikonfirmasi.');
    }

    // =================================================================
    // 4. PRIVATE HELPER: KIRIM NOTIFIKASI (WA & EMAIL)
    // =================================================================
    private function notifyParticipant($participant)
    {
        $userPeserta = $participant->user;
        $room = $participant->room;

        // A. Kirim Email Konfirmasi
        if ($userPeserta->email) {
            try {
                Mail::to($userPeserta->email)->send(new RoomJoinConfirmed($participant));
            } catch (\Exception $e) {
                Log::error('Gagal kirim email konfirmasi: ' . $e->getMessage());
            }
        }

    }


}
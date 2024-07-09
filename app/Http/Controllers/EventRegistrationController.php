<?php

namespace App\Http\Controllers;

use App\Mail\EventRegistrationMail;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\event_registration;
use App\Models\User; // tambahkan model User jika belum ditambahkan sebelumnya

class EventRegistrationController extends Controller
{

    public function index()
    {
        $registrations = event_registration::with(['umkm', 'event'])->get();

        return response()->json($registrations, 200);
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'user_id' => 'required|exists:users,id', // ubah validasi umkm_id menjadi user_id
            'event_id' => 'required|exists:event,id',
            'status' => 'required'
        ]);

        $user = User::find($request->user_id); // temukan user berdasarkan user_id
        if (!$user) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        // Anda bisa menyesuaikan ini sesuai dengan struktur model Anda
        $umkm = $user->umkm; // asumsikan bahwa umkm tersimpan dalam relasi user

        $registration = event_registration::create([
            'date' => $request->date,
            'umkm_id' => $umkm->id,
            'event_id' => $request->event_id,
            'status' => $request->status
        ]);

        Mail::to($user->email)->send(new EventRegistrationMail($registration));

        return response()->json(['message' => 'Registration successful and email sent.'], 200);
    }
}
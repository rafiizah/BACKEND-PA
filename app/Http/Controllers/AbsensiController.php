<?php

use App\Models\Attendances;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;

class AbsensiController extends Controller
{
    public function clockIn()
    {
        $attendances = Attendances::latest()->paginate(5);
        $user_id = $attendances->user()->user_id; // Misalnya, mengambil user_id dari user yang sedang login
        $clock_in = $attendances->first()->clock_in; // Mengambil waktu clock_in dari data absensi pertama
        $clock_out = $attendances->first()->clock_out; // Mengambil waktu clock_out dari data absensi pertama

        // Membuat respons JSON dengan data yang diambil
        $response = [
            'message' => 'Data absensi berhasil ditambahkan',
            'user_id' => $user_id,
            'clock_in' => $clock_in,
            'clock_out' => $clock_out,
        ];

        return response()->json($response, 201);
    }
}

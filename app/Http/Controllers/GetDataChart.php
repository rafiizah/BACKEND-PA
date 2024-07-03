<?php

namespace App\Http\Controllers;

use App\Models\UMKM;
use Illuminate\Http\Request;

class GetDataChart extends Controller
{
    public function getDataForChart()
    {
        // Mengambil data dari tabel UMKM
        $umkms = UMKM::all();

        // Mengelompokkan data berdasarkan domisili_usaha
        $data = $umkms->groupBy('domisili_usaha')
            ->map(function ($group) {
                return $group->count();
            });

        // Membuat array untuk menyimpan label dan data untuk chart
        $labels = $data->keys()->toArray();
        $values = $data->values()->toArray();

        // Mengembalikan data dalam format yang dapat digunakan untuk membuat chart
        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);
    }

    public function getDataForTahunBerdiri()
    {
        // Mengambil data dari tabel UMKM
        $umkms = UMKM::all();

        // Mengelompokkan data berdasarkan domisili_usaha
        $data = $umkms->groupBy('tahunBerdiri_usaha')
            ->map(function ($group) {
                return $group->count();
            });

        // Membuat array untuk menyimpan label dan data untuk chart
        $labels = $data->keys()->toArray();
        $values = $data->values()->toArray();

        // Mengembalikan data dalam format yang dapat digunakan untuk membuat chart
        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);
    }

    public function getDataForJenis()
    {
        // Mengambil data dari tabel UMKM
        $umkms = UMKM::all();

        // Mengelompokkan data berdasarkan domisili_usaha
        $data = $umkms->groupBy('jenisbadan_usaha')
            ->map(function ($group) {
                return $group->count();
            });

        // Membuat array untuk menyimpan label dan data untuk chart
        $labels = $data->keys()->toArray();
        $values = $data->values()->toArray();

        // Mengembalikan data dalam format yang dapat digunakan untuk membuat chart
        return response()->json([
            'labels' => $labels,
            'values' => $values,
        ]);
    }
}

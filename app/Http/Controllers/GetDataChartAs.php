<?php

namespace App\Http\Controllers;

use App\Models\asosiasi;
use Illuminate\Http\Request;

class getDataChartAs extends Controller
{
    public function getDataChartAs()
    {
        // Mengambil data dari tabel UMKM
        $as = asosiasi::all();

        // Mengelompokkan data berdasarkan domisili_usaha
        $data = $as->groupBy('domisili_asosiasi')
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

    public function getDataForTahunAs()
    {
        // Mengambil data dari tabel UMKM
        $as = asosiasi::all();

        // Mengelompokkan data berdasarkan domisili_usaha
        $data = $as->groupBy('tahun_berdiri_asosiasi')
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

    public function getDataForJumlahAs()
    {
        // Mengambil data dari tabel UMKM
        $as = asosiasi::all();

        // Mengelompokkan data berdasarkan domisili_usaha
        $data = $as->groupBy('jumlah_anggota_umkm')
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
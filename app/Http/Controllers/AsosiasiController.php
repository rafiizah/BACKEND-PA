<?php

namespace App\Http\Controllers;

use App\Models\asosiasi;
use App\Models\umkm;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AsosiasiController extends Controller
{
    public function index()
    {
        $asosiasi = asosiasi::all();
        return response()->json([
            'success' => true,
            'message' => 'Detail Asosiasi',
            'asosiasi' => $asosiasi
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'namalengkap_asosiasi' => 'required',
            'namasingkat_asosiasi' => 'required',
            'alamat_asosiasi' => 'required',
            'domisili_asosiasi' => 'required',
            'email_asosiasi' => 'required',
            'nomor_wa_asosiasi' => 'required',
            'website_asosiasi' => 'required',
            'nama_pimpinan_asosiasi' => 'required',
            'tahun_berdiri_asosiasi' => 'required',
            'jenis_bidang_asosiasi' => 'required',
            'jumlah_anggota_umkm' => 'required',
            'legalitas_asosiasi' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $image = (object) ['image' => ""];

        if ($request->hasFile('image')) {
            $original_filename = $request->file('image')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './upload/asosiasi/';
            $image = 'U-' . time() . '.' . $file_ext;

            if ($request->file('image')->move($destination_path, $image)) {
                $request->image = '/upload/asosiasi/' . $image;
            }
        }

        $user = new user();

        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = 3;
        $user->save();

        $asosiasi = new asosiasi();
        $asosiasi->namalengkap_asosiasi = $request->namalengkap_asosiasi;
        $asosiasi->namasingkat_asosiasi = $request->namasingkat_asosiasi;
        $asosiasi->alamat_asosiasi = $request->alamat_asosiasi;
        $asosiasi->domisili_asosiasi = $request->domisili_asosiasi;
        $asosiasi->email_asosiasi = $request->email_asosiasi;
        $asosiasi->nomor_wa_asosiasi = $request->nomor_wa_asosiasi;
        $asosiasi->website_asosiasi = $request->website_asosiasi;
        $asosiasi->nama_pimpinan_asosiasi = $request->nama_pimpinan_asosiasi;
        $asosiasi->tahun_berdiri_asosiasi = $request->tahun_berdiri_asosiasi;
        $asosiasi->jenis_bidang_asosiasi = $request->jenis_bidang_asosiasi;
        $asosiasi->jumlah_anggota_umkm = $request->jumlah_anggota_umkm;
        $asosiasi->legalitas_asosiasi = $request->legalitas_asosiasi;
        $asosiasi->image = $request->image;
        $asosiasi->user()->associate($user);
        $asosiasi->save();

        return response()->json([
            'success' => true,
            'message' => 'Asosiasi created successfully',
            'asosiasi' => $asosiasi
        ], 200);
    }

    public function show($id)
    {
        $asosiasi = app('db')->select("SELECT * FROM asosiasi WHERE user_id = :user_id", ['user_id' => $id]);
        if (!$asosiasi) {
            return response()->json(['message' => 'Asosiasi not found'], 404);
        }
        return response()->json($asosiasi[0], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'namalengkap_asosiasi' => 'required',
            'namasingkat_asosiasi' => 'required',
            'alamat_asosiasi' => 'required',
            'domisili_asosiasi' => 'required',
            'email_asosiasi' => 'required',
            'nomor_wa_asosiasi' => 'required',
            'website_asosiasi' => 'required',
            'nama_pimpinan_asosiasi' => 'required',
            'tahun_berdiri_asosiasi' => 'required',
            'jenis_bidang_asosiasi' => 'required',
            'jumlah_anggota_umkm' => 'required',
            'legalitas_asosiasi' => 'required',
        ]);

        $inputs = $request->all();
        $asosiasi = asosiasi::where('user_id', $id)->firstOrFail();
        $asosiasi->update($inputs);


        return response()->json([
            'success' => true,
            'message' => 'Asosiasi updated successfully',
            'asosiasi' => $asosiasi
        ], 200);
    }

    public function destroy($id)
    {
        $asosiasi = asosiasi::whereId($id)->first();
        $asosiasi->delete();

        if ($asosiasi) {
            return response()->json([
                'success' => true,
                'message' => 'Asosiasi Berhasil Dihapus!',
            ], 200);
        }
    }

    public function hitungJumlahAsosiasi()
    {
        // Menggunakan query builder untuk menghitung jumlah UMKM
        $jumlahAsosiasi = DB::table('asosiasi')->count();

        // Mengembalikan response dalam bentuk JSON
        return response()->json(['jumlah_asosiasi' => $jumlahAsosiasi]);
    }
}

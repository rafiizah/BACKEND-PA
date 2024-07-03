<?php

namespace App\Http\Controllers;

use App\Models\umkm;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class pemilikController extends Controller
{
    public function index()
    {
        $umkm = umkm::all();
        return response()->json([
            'success' => true,
            'message' => 'Detail UMKM',
            'umkm' => $umkm
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required',
            'nama_pemilik' => 'required',
            'nomor_pemilik' => 'required',
            'alamat_pemilik' => 'required',
            'nama_usaha' => 'required',
            'alamat_usaha' => 'required',
            'domisili_usaha' => 'required',
            'kodePos_usaha' => 'required',
            'email_usaha' => 'required',
            'tahunBerdiri_usaha' => 'required',
            'jenisbadan_usaha' => 'required',
            'kategori_usaha' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi_usaha' => 'required',
            'legalitas_usaha' => 'required',
        ]);

        $image = (object) ['image' => ""];

        if ($request->hasFile('image')) {
            $original_filename = $request->file('image')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './upload/user/';
            $image = 'U-' . time() . '.' . $file_ext;

            if ($request->file('image')->move($destination_path, $image)) {
                $request->image = '/upload/user/' . $image;
            }
        }

        $user = new user();

        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = 2;
        $user->save();

        $umkm = new Umkm();
        $umkm->nama_pemilik = $request->nama_pemilik;
        $umkm->nomor_pemilik = $request->nomor_pemilik;
        $umkm->alamat_pemilik = $request->alamat_pemilik;
        $umkm->nama_usaha = $request->nama_usaha;
        $umkm->alamat_usaha = $request->alamat_usaha;
        $umkm->domisili_usaha = $request->domisili_usaha;
        $umkm->kodePos_usaha = $request->kodePos_usaha;
        $umkm->email_usaha = $request->email_usaha;
        $umkm->tahunBerdiri_usaha = $request->tahunBerdiri_usaha;
        $umkm->jenisbadan_usaha = $request->jenisbadan_usaha;
        $umkm->kategori_usaha = $request->kategori_usaha;
        $umkm->image = $request->image;
        $umkm->deskripsi_usaha = $request->deskripsi_usaha;
        $umkm->legalitas_usaha = $request->legalitas_usaha;
        $umkm->user()->associate($user);
        $umkm->save();

        return response()->json([
            'success' => true,
            'message' => 'UMKM created successfully',
            'umkm' => $umkm
        ], 200);
    }

    public function show($id)
    {
        $umkm = app('db')->select("SELECT * FROM umkm WHERE user_id = :user_id", ['user_id' => $id]);

        if (!$umkm) {
            return response()->json(['message' => 'UMKM not found'], 404);
        }

        // Mengembalikan objek JSON langsung daripada array
        return response()->json($umkm[0], 200);
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama_pemilik' => 'required',
            'nomor_pemilik' => 'required',
            'alamat_pemilik' => 'required',
            'nama_usaha' => 'required',
            'alamat_usaha' => 'required',
            'domisili_usaha' => 'required',
            'kodePos_usaha' => 'required',
            'email_usaha' => 'required',
            'tahunBerdiri_usaha' => 'required',
            'jenisbadan_usaha' => 'required',
            'kategori_usaha' => 'required',
            'deskripsi_usaha' => 'required',
            'legalitas_usaha' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $umkm = Umkm::where('user_id', $id)->firstOrFail();

        $inputs = $request->except('image'); // Ambil semua input kecuali 'image'

        if ($request->hasFile('image')) {
            $original_filename = $request->file('image')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './upload/user/';
            $image = 'U-' . time() . '.' . $file_ext;

            if ($request->file('image')->move($destination_path, $image)) {
                $inputs['image'] = '/upload/user/' . $image;
            }
        }

        $umkm->update($inputs);

        return response()->json([
            'success' => true,
            'message' => 'UMKM updated successfully',
            'umkm' => $umkm
        ], 200);
    }


    public function destroy($id)
    {
        $umkm = umkm::findOrFail($id);
        $umkm->delete();

        if ($umkm) {
            return response()->json([
                'success' => true,
                'message' => 'UMKM Berhasil Dihapus!',
            ], 200);
        }
    }

    public function hitungJumlahUMKM()
    {
        // Menggunakan query builder untuk menghitung jumlah UMKM
        $jumlahUMKM = DB::table('umkm')->count();

        // Mengembalikan response dalam bentuk JSON
        return response()->json(['jumlah_umkm' => $jumlahUMKM]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        if ($user) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Post!',
                'data'      => $user
            ], 200);
        }
    }
    public function show($id)
    {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                'success'   => true,
                'message'   => 'Detail Post!',
                'data'      => $user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Tidak Ditemukan!',
            ], 404);
        }
    }
    public function store(Request $request)
    {
        // Validasi input
        $this->validate($request, [
            'fullname' => 'required', // Sesuaikan dengan format waktu yang benar
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'contact' => 'required',
            'religion' => 'required',

        ]);

        // Buat pengguna baru
        $user = new User;
        $user->fullname = $request->input('fullname');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password')); // Menggunakan Hash::make untuk mengenkripsi kata sandi
        $user->date_of_birth = $request->input('date_of_birth');
        $user->gender = $request->input('gender');
        $user->contact = $request->input('contact');
        $user->religion = $request->input('religion');
        $user->role_id = 1; // Isi dengan nilai role yang sesuai
        $user->save();

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Disimpan!',
                'data' => $user
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Post Gagal Disimpan!',
            ], 400);
        }
    }
    public function update(Request $request, $id)
    {
        // Validasi input
        $this->validate($request, [
            'fullname' => 'required',
            'email' => 'required|email|unique:users,email,' . $id, // Tambahkan pengecualian untuk email saat mengupdate
            'date_of_birth' => 'required',
            'gender' => 'required',
            'contact' => 'required',
            'religion' => 'required',
        ]);

        // Temukan pengguna berdasarkan ID
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Pengguna tidak ditemukan!',
            ], 404);
        }

        // Update data pengguna
        $user->fullname = $request->input('fullname');
        $user->email = $request->input('email');
        $user->date_of_birth = $request->input('date_of_birth');
        $user->gender = $request->input('gender');
        $user->contact = $request->input('contact');
        $user->religion = $request->input('religion');
        $user->role_id = 1;

        // Simpan perubahan
        $user->save();

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Pengguna berhasil diperbarui!',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui pengguna!',
            ], 400);
        }
    }

    public function destroy($id)
    {
        $user = User::whereId($id)->first();
        $user->delete();

        if ($user) {
            return response()->json([
                'success' => true,
                'message' => 'Post Berhasil Dihapus!',
            ], 200);
        }
    }
    public function changePassword(Request $request)
    {

        $this->validate($request, [
            'password' => 'required',
            'new_password' => 'required|min:6',
        ]);

        $user = User::find($request->id);
        Hash::check($request->input('password'), $user->password);
        $newPassword = Hash::make($request->input('new_password'));



        if (!$user) {
            return response()->json(['message' => 'Email tidak ditemukan'], 404);
        }

        $user->update(['password' => $newPassword]);

        return response()->json(['message' => 'Kata sandi berhasil diubah']);
    }
}
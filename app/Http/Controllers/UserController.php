<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function countUsers()
    {
        // Menghitung jumlah pengguna
        $userCount = User::count();

        // Mengembalikan respons dalam format JSON
        return response()->json(['total_users' => $userCount]);
    }
}

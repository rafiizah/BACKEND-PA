<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use app\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'fullname' => 'Rafi Izah Ramadani Arief', // Sesuaikan dengan format waktu yang benar
            'email' => 'rafiizah25@gmail.com',
            'password' => Hash::make('password'),
            'date_of_birth' => '25-11-2002',
            'gender' => 'Laki-Laki',
            'contact' => '082141008901',
            'religion' => 'islam'
            // Sesuaikan dengan format waktu yang benar
        ]);
    }
}

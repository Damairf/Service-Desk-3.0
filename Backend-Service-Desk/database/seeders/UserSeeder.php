<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("user")->insert([
            [
                "ID_Role" => 1,
                "ID_Jabatan" => 1,
                "ID_Organisasi" => 1,
                "NIP" => 1111,
                "Nama_Depan" => "Damai",
                "Nama_Belakang" => "Raya",
                "Password" => Hash::make('1234'),
                "Gambar_Path" => "default.jpeg",
                'Status' => 'Aktif'
            ],
            [
                "ID_Role" => 2,
                "ID_Jabatan" => 2,
                "ID_Organisasi" => 2,
                "NIP" => 2222,
                "Nama_Depan" => "Farrel",
                "Nama_Belakang" => "Alfat'han",
                "Password" => Hash::make('1234'),
                "Gambar_Path" => "default.jpeg",
                'Status' => 'Aktif'
            ],
            [
                "ID_Role" => 3,
                "ID_Jabatan" => 3,
                "ID_Organisasi" => 3,
                "NIP" => 3333,
                "Nama_Depan" => "Farrel",
                "Nama_Belakang" => "Razaan",
                "Password" => Hash::make('1234'),
                "Gambar_Path" => "default.jpeg",
                'Status' => 'Aktif'
            ],
            [
                "ID_Role" => 4,
                "ID_Jabatan" => 5,
                "ID_Organisasi" => 4,
                "NIP" => 4444,
                "Nama_Depan" => "Syahbana",
                "Nama_Belakang" => "Hatab",
                "Password" => Hash::make('1234'),
                "Gambar_Path" => "default.jpeg",
                'Status' => 'Aktif'
            ],
            [
                "ID_Role" => 5,
                "ID_Jabatan" => 6,
                "ID_Organisasi" => 5,
                "NIP" => 5555,
                "Nama_Depan" => "Syaiful",
                "Nama_Belakang" => "Iful",
                "Password" => Hash::make('1234'),
                "Gambar_Path" => "default.jpeg",
                'Status' => 'Aktif'
            ],
            [
                "ID_Role" => 1,
                "ID_Jabatan" => 1,
                "ID_Organisasi" => 1,
                "NIP" => 6666,
                "Nama_Depan" => "User",
                "Nama_Belakang" => "Lain",
                "Password" => Hash::make('1234'),
                "Gambar_Path" => "default.jpeg",
                'Status' => 'Aktif'
            ],
        ]);
    }
}
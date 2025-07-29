<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("reff_organisasi")->insert([
            [
                "Nama_OPD" => "Dinas Ketahanan Pangan dan Peternakan",
                "ID_Induk_Organisasi" => null,
                "Nama_Pengelola" => "Pengelola 1",
                "No_HP_Pengelola" => "081234567890",
                "Email" => "pengelola1@gmail.com",
                'Status' => 'Aktif'
            ],
            [
                "Nama_OPD" => "Dinas Komunikasi dan Informatika Jawa Barat",
                "ID_Induk_Organisasi" => null,
                "Nama_Pengelola" => "Pengelola 2",
                "No_HP_Pengelola" => "081234567890",
                "Email" => "pengelola2@gmail.com",
                'Status' => 'Aktif'
            ],
            [
                "Nama_OPD" => "Dinas Pekerjaan Umum dan Penataan Ruang",
                "ID_Induk_Organisasi" => null,
                "Nama_Pengelola" => "Pengelola 3",
                "No_HP_Pengelola" => "081234567890",
                "Email" => "pengelola3@gmail.com",
                'Status' => 'Aktif'
            ],
            [
                "Nama_OPD" => "Dinas Lingkungan Hidup",
                "ID_Induk_Organisasi" => null,
                "Nama_Pengelola" => "Pengelola 4",
                "No_HP_Pengelola" => "081234567890",
                "Email" => "pengelola4@gmail.com",
                'Status' => 'Aktif'
            ],
            [
                "Nama_OPD" => "Dinas Komunikasi dan Informatika Bandung",
                "ID_Induk_Organisasi" => 2,
                "Nama_Pengelola" => "Pengelola 5",
                "No_HP_Pengelola" => "081234567890",
                "Email" => "pengelola5@gmail.com",
                'Status' => 'Nonaktif'
            ],
        ]);
    }
}
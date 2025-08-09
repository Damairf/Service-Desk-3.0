<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class JenisPelayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("reff_jenis_pelayanan")->insert([
            [
                "Nama_Jenis_Pelayanan" => "Aptika",
            ],
            [
                "Nama_Jenis_Pelayanan" => "Server",
            ],
            [
                "Nama_Jenis_Pelayanan" => "Multimedia",
            ],
            [
                "Nama_Jenis_Pelayanan" => "Administrasi",
            ],
        ]);
    }
}

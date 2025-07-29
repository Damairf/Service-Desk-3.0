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
                "Nama_Jenis_Pelayanan" => "Perbaikan Server",
                "Persyaratan" => "Website harus sudah ada"
            ],
            [
                "Nama_Jenis_Pelayanan" => "Desain Laman Web",
                "Persyaratan" => "Konsep harus sudah ada"
            ],
            [
                "Nama_Jenis_Pelayanan" => "Pembuatan Website",
                "Persyaratan" => "Peruntukannya jelas"
            ],
            [
                "Nama_Jenis_Pelayanan" => "Hosting Website",
                "Persyaratan" => "Harus sudah memiliki website"
            ],
            [
                "Nama_Jenis_Pelayanan" => "Pembuatan Desain Logo",
                "Persyaratan" => "Memiliki konsep logo"
            ],
        ]);
    }
}

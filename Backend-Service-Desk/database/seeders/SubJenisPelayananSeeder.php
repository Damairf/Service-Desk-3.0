<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class SubJenisPelayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("reff_sub_jenis_pelayanan")->insert([
            [
                "Nama_Sub_Jenis_Pelayanan" => "Perbaikan Server",
                "Persyaratan" => "Website harus sudah ada",
                "ID_Jenis_Pelayanan" => 2
            ],
            [
                "Nama_Sub_Jenis_Pelayanan" => "Desain Laman Web",
                "Persyaratan" => "Konsep harus sudah ada",
                "ID_Jenis_Pelayanan" => 3
            ],
            [
                "Nama_Sub_Jenis_Pelayanan" => "Pembuatan Website",
                "Persyaratan" => "Peruntukannya jelas",
                "ID_Jenis_Pelayanan" => 1
            ],
            [
                "Nama_Sub_Jenis_Pelayanan" => "Hosting Website",
                "Persyaratan" => "Harus sudah memiliki website",
                "ID_Jenis_Pelayanan" => 2
            ],
            [
                "Nama_Sub_Jenis_Pelayanan" => "Pembuatan Desain Logo",
                "Persyaratan" => "Memiliki konsep logo",
                "ID_Jenis_Pelayanan" => 3
            ],
        ]);
    }
}

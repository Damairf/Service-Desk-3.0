<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class IsiAlurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("reff_isi_alur")->insert([
            ["Nama_Alur" => "Permintaan Masuk"],
            ["Nama_Alur" => "Verifikasi Dokumen"],
            ["Nama_Alur" => "Permintaan Diproses"],
            ["Nama_Alur" => "Perbaikan Server Dikerjakan"],
            ["Nama_Alur" => "Desain Laman Web Dikerjakan"],
            ["Nama_Alur" => "Pembuatan Website Dikerjakan"],
            ["Nama_Alur" => "Hosting Website Dikerjakan"],
            ["Nama_Alur" => "Pembuatan Desain Logo Dikerjakan"],
        ]);
    }
}
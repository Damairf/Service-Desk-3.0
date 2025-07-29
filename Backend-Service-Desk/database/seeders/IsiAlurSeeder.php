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
        DB::table("isi_alur")->insert([
            ["Isi_Bagian_Alur" => "Permintaan Masuk"],
            ["Isi_Bagian_Alur" => "Verifikasi Dokumen"],
            ["Isi_Bagian_Alur" => "Permintaan Diproses"],
            ["Isi_Bagian_Alur" => "Perbaikan Server Dikerjakan"],
            ["Isi_Bagian_Alur" => "Desain Laman Web Dikerjakan"],
            ["Isi_Bagian_Alur" => "Pembuatan Website Dikerjakan"],
            ["Isi_Bagian_Alur" => "Hosting Website Dikerjakan"],
            ["Isi_Bagian_Alur" => "Pembuatan Desain Logo Dikerjakan"],
        ]);
    }
}
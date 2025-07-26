<?php

namespace Database\Seeders;

use App\Models\Pelayanan;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class PelayananSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pelayanan::create([
            
                "ID_User" => 1,
                "ID_Jenis_Pelayanan" => 1,
                "Perihal" => "Perbaikan Server",
                "Deskripsi" => "Server error sampai terjadi down",
                "Surat_Dinas_Path" => "Surat Dinas A",
                "Lampiran_Path" => "Lampiran A",
        ]);
        Pelayanan::create([
                "ID_User" => 6,
                "ID_Jenis_Pelayanan" => 2,
                "Perihal" => "Desain untuk website",
                "Deskripsi" => "Buatkan desain website yang mengusung tema olahraga",
                "Surat_Dinas_Path" => "Surat Dinas B",
                "Lampiran_Path" => "Lampiran B",
        ]);
        Pelayanan::create([
                "ID_User" => 1,
                "ID_Jenis_Pelayanan" => 3,
                "Perihal" => "Buatkan website",
                "Deskripsi" => "Buatkan website dengan tenggat waktu 2 minggu",
                "Surat_Dinas_Path" => "Surat Dinas C",
                "Lampiran_Path" => "Lampiran C",
        ]);
        Pelayanan::create([
                "ID_User" => 6,
                "ID_Jenis_Pelayanan" => 4,
                "Perihal" => "Selesaikan Masalah",
                "Deskripsi" => "Selesaikan masalah yang diberikan",
                "Surat_Dinas_Path" => "Surat Dinas D",
                "Lampiran_Path" => "Lampiran D",
        ]);
    }
}
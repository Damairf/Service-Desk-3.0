<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::insert([
            ["Nama_Status" => "Aktif"],
            ["Nama_Status" => "Nonaktif"],
            ["Nama_Status" => "Baru"],
            ["Nama_Status" => "Proses"],
            ["Nama_Status" => "Selesai"],
            ["Nama_Status" => "Tutup"],
        ]);
    }
}

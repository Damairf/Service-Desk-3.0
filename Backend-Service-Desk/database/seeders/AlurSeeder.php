<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class AlurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("alur")->insert([
            [
                "ID_Jenis_Pelayanan" => 1,
                "ID_Isi_Alur" => 1,
            ],
            [
                "ID_Jenis_Pelayanan" => 1,
                "ID_Isi_Alur" => 2,
            ],
            [
                "ID_Jenis_Pelayanan" => 1,
                "ID_Isi_Alur" => 3,
            ],
            [
                "ID_Jenis_Pelayanan" => 1,
                "ID_Isi_Alur" => 4,
            ],
            [
                "ID_Jenis_Pelayanan" => 2,
                "ID_Isi_Alur" => 1,
            ],
            [
                "ID_Jenis_Pelayanan" => 2,
                "ID_Isi_Alur" => 2,
            ],
            [
                "ID_Jenis_Pelayanan" => 2,
                "ID_Isi_Alur" => 3,
            ],
            [
                "ID_Jenis_Pelayanan" => 2,
                "ID_Isi_Alur" => 5,
            ],
            [
                "ID_Jenis_Pelayanan" => 3,
                "ID_Isi_Alur" => 1,
            ],
            [
                "ID_Jenis_Pelayanan" => 3,
                "ID_Isi_Alur" => 2,
            ],
            [
                "ID_Jenis_Pelayanan" => 3,
                "ID_Isi_Alur" => 3,
            ],
            [
                "ID_Jenis_Pelayanan" => 3,
                "ID_Isi_Alur" => 6,
            ],
            [
                "ID_Jenis_Pelayanan" => 4,
                "ID_Isi_Alur" => 1,
            ],
            [
                "ID_Jenis_Pelayanan" => 4,
                "ID_Isi_Alur" => 2,
            ],
            [
                "ID_Jenis_Pelayanan" => 4,
                "ID_Isi_Alur" => 3,
            ],
            [
                "ID_Jenis_Pelayanan" => 4,
                "ID_Isi_Alur" => 7,
            ],
            [
                "ID_Jenis_Pelayanan" => 5,
                "ID_Isi_Alur" => 1,
            ],
            [
                "ID_Jenis_Pelayanan" => 5,
                "ID_Isi_Alur" => 2,
            ],
            [
                "ID_Jenis_Pelayanan" => 5,
                "ID_Isi_Alur" => 3,
            ],
            [
                "ID_Jenis_Pelayanan" => 5,
                "ID_Isi_Alur" => 8,
            ],
        ]);
    }
}
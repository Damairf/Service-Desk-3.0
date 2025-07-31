<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class progressAlurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("progress_alur")->insert([
            [
                "ID_Pelayanan" => "P-00001",
                "ID_Alur" => 1,
                "Is_Done" => true
            ],
            [
                "ID_Pelayanan" => "P-00001",
                "ID_Alur" => 2,
                "Is_Done" => true
            ],
            [
                "ID_Pelayanan" => "P-00001",
                "ID_Alur" => 3,
                "Is_Done" => false
            ],
            [
                "ID_Pelayanan" => "P-00001",
                "ID_Alur" => 4,
                "Is_Done" => false
            ],
            [
                "ID_Pelayanan" => "P-00002",
                "ID_Alur" => 5,
                "Is_Done" => true
            ],
            [
                "ID_Pelayanan" => "P-00002",
                "ID_Alur" => 6,
                "Is_Done" => true
            ],
            [
                "ID_Pelayanan" => "P-00002",
                "ID_Alur" => 7,
                "Is_Done" => false
            ],
            [
                "ID_Pelayanan" => "P-00002",
                "ID_Alur" => 8,
                "Is_Done" => false
            ],
            [
                "ID_Pelayanan" => "P-00003",
                "ID_Alur" => 9,
                "Is_Done" => true
            ],
            [
                "ID_Pelayanan" => "P-00003",
                "ID_Alur" => 10,
                "Is_Done" => true
            ],
            [
                "ID_Pelayanan" => "P-00003",
                "ID_Alur" => 11,
                "Is_Done" => false
            ],
            [
                "ID_Pelayanan" => "P-00003",
                "ID_Alur" => 12,
                "Is_Done" => false
            ],
            [
                "ID_Pelayanan" => "P-00004",
                "ID_Alur" => 13,
                "Is_Done" => true
            ],
            [
                "ID_Pelayanan" => "P-00004",
                "ID_Alur" => 14,
                "Is_Done" => true
            ],
            [
                "ID_Pelayanan" => "P-00004",
                "ID_Alur" => 15,
                "Is_Done" => false
            ],
            [
                "ID_Pelayanan" => "P-00004",
                "ID_Alur" => 16,
                "Is_Done" => false
            ],
        ]);
    }
}
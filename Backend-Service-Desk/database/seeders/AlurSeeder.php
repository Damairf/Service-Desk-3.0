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
        ]);
    }
}
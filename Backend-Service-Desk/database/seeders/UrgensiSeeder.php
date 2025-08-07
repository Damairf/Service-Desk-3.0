<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UrgensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("reff_urgensi")->insert([
            ["Nama_Urgensi" => "Sangat Rendah"],
            ["Nama_Urgensi" => "Rendah"],
            ["Nama_Urgensi" => "Sedang"],
            ["Nama_Urgensi" => "Tinggi"],
            ["Nama_Urgensi" => "Sangat Tinggi"],
        ]);
    }
}

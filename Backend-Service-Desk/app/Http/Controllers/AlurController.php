<?php

namespace App\Http\Controllers;
use App\Models\Alur;
use App\Models\Isi_Alur;
use App\Models\JenisPelayanan;
use Illuminate\Http\Request;

class AlurController extends Controller
{
    public function getAlurByJenisPelayanan($id)
    {
        $jenisPelayanan = JenisPelayanan::with('alur_jnsPelayanan.isi_alur')
            ->where('ID_Jenis_Pelayanan', $id)
            ->first();
    
        if (!$jenisPelayanan) {
            return response()->json(['message' => 'Jenis Pelayanan tidak ditemukan'], 404);
        }
    
        return response()->json($jenisPelayanan->alur_jnsPelayanan);
    }
    public function postAlur(Request $request){
        $ID_Jenis_Pelayanan = $request->ID_Jenis_Pelayanan;
        $ID_Isi_Alur = $request->ID_Isi_Alur;

        $newAlurPelayanan = Alur::create([
            'ID_Jenis_Pelayanan' => $ID_Jenis_Pelayanan,
            'ID_Isi_Alur' => $ID_Isi_Alur,
        ]);
        return response(["message" => "Alur dari jenis layanan ditambahkan", "data" => $newAlurPelayanan]);
    }
    public function postIsi_Alur(Request $request){
        $Nama_Alur = $request->Nama_Alur;

        $newIsiAlur = Isi_Alur::create([
            'Nama_Alur' => $Nama_Alur
        ]);
        return response(["message" => "Nama Alur berhasil ditambahkan", "data" => $newIsiAlur]);
    }
}
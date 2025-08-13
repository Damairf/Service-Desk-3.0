<?php

namespace App\Http\Controllers;
use App\Models\Alur;
use App\Models\Isi_Alur;
use App\Models\SubJenisPelayanan;
use Illuminate\Http\Request;

class AlurController extends Controller
{
    public function getAlurBySubJenisPelayanan($id)
    {
        $subjenisPelayanan = SubJenisPelayanan::with('alur_subjnsPelayanan.isi_alur')
            ->where('ID_Sub_Jenis_Pelayanan', $id)
            ->first();
    
        if (!$subjenisPelayanan) {
            return response()->json(['message' => 'Sub Jenis Pelayanan tidak ditemukan'], 404);
        }
    
        return response()->json($subjenisPelayanan->alur_subjnsPelayanan);
    }
    public function postAlur(Request $request){
        $ID_Sub_Jenis_Pelayanan = $request->ID_Sub_Jenis_Pelayanan;
        $ID_Isi_Alur = $request->ID_Isi_Alur;

        $newSubAlurPelayanan = Alur::create([
            'ID_Sub_Jenis_Pelayanan' => $ID_Sub_Jenis_Pelayanan,
            'ID_Isi_Alur' => $ID_Isi_Alur,
        ]);
        return response(["message" => "Alur dari sub jenis layanan ditambahkan", "data" => $newSubAlurPelayanan]);
    }
    public function postIsi_Alur(Request $request){
        $Nama_Alur = $request->Nama_Alur;

        $newIsiAlur = Isi_Alur::create([
            'Nama_Alur' => $Nama_Alur
        ]);
        return response(["message" => "Nama Alur berhasil ditambahkan", "data" => $newIsiAlur]);
    }
    public function getAll_IsiAlur(){
        $Nama_Alur = Isi_Alur::get();
        return response()->json([
            'message' => 'Berhasil mengambil data',
            'data' => $Nama_Alur
        ]);
    }
}
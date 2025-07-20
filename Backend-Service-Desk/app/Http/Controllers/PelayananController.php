<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelayanan;
use App\Models\User;

class PelayananController extends Controller
{
    public function getAll_Layanan(){
        $pelayanans = Pelayanan::get();
        return response()->json($pelayanans);
    }

    public function getByID_Layanan(Request $request){
        $pelayananId = $request->route('pelayananId');
        $pelayanan = Pelayanan::where('ID_Pelayanan', $pelayananId)->get();

        return response()->json($pelayanan);
    }

    public function postLayanan(Request $request){
        $ID_User = User::where('ID_User', $request->ID_User)->pluck('ID_User')->first();
        $ID_Jenis_Pelayanan = $request->ID_Jenis_Pelayanan;
        $Perihal = $request->Perihal;
        $Deskripsi = $request->Deskripsi;
        $Surat_Dinas_Path = $request->Surat_Dinas_Path;
        $Lampiran_Path = $request->Lampiran_Path; 
        $ID_Unit = $request->ID_Unit; 
        $ID_Teknis = $request->ID_Teknis;
        $Rating = $request->Rating;
        $Isi_Survey = $request->Isi_Survey;

        $newPelayanan = Pelayanan::create([
            'ID_User' => $ID_User,
            'ID_Jenis_Pelayanan' => $ID_Jenis_Pelayanan,
            'Perihal' => $Perihal,
            'Deskripsi' => $Deskripsi,
            'Surat_Dinas_Path' => $Surat_Dinas_Path,
            'Lampiran_Path' => $Lampiran_Path,
            'ID_Unit' => $ID_Unit,
            'ID_Teknis' => $ID_Teknis,
            'Rating' => $Rating,
            'Isi_Survey' => $Isi_Survey
        ]);

        return response(["message" => "Layanan ditambahkan", "data" => $newPelayanan]);
    }

    public function Verif_Pengelola(Request $request){
        $pelayananId = $request->route('pelayananId');
        $dataPelayanan = $request->only([
            'ID_Unit'
        ]);

        $pelayanan = Pelayanan::where('ID_Pelayanan', $pelayananId)->first();

        $pelayanan->update($dataPelayanan);

        return response(["Pelayanan diverifikasi menjadi " => $pelayanan->fresh()]);
    
    }
        
}

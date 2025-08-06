<?php

namespace App\Http\Controllers;
use App\Models\Alur;
use App\Models\JenisPelayanan;
use Illuminate\Http\Request;

class JenisPelayananController extends Controller
{
    public function getAll_JnsPelayanan(){
        $jenispelayanan = JenisPelayanan::get();
        return response()->json($jenispelayanan);
    }
    public function getAll_Alur_JnsPelayanan_byId(Request $request){
        $alurId = $request->route("alurId");
        $alur = Alur::with("alur_jnsPelayanan")->where('ID_Alur', $alurId)->get();
        return response()->json($alur);
    }
    public function findOne_JnsPelayanan(Request $request){
        $jnspelayananId = $request->route('jnspelayananId');
        $jnspelayananId = JenisPelayanan::where('ID_Jenis_Pelayanan', $jnspelayananId)->get();

        return response()->json($jnspelayananId);
    }
    public function postJenis_Pelayanan(Request $request){
        $Nama_Jenis_Pelayanan = $request->Nama_Jenis_Pelayanan;
        $Persyaratan = $request->Persyaratan;

        $newJenisPelayanan = JenisPelayanan::create([
            'Nama_Jenis_Pelayanan' => $Nama_Jenis_Pelayanan,
            'Persyaratan' => $Persyaratan,
        ]);
        return response(["message" => "Jenis Pelayanan ditambahkan", "data" => $newJenisPelayanan]);
    }
}
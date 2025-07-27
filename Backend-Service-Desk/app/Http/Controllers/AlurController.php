<?php

namespace App\Http\Controllers;
use App\Models\Alur;
use App\Models\JenisPelayanan;
use Illuminate\Http\Request;

class AlurController extends Controller
{
    public function getAll_Alur_JnsPelayanan_byId(Request $request){
        $jnspelId = $request->route("jnspelId");
        $jenis_pelayanan_alur = JenisPelayanan::with("alur_jnsPelayanan.isi_alur")->where('ID_Jenis_Pelayanan', $jnspelId)->get();
        return response()->json($jenis_pelayanan_alur);
    }
}
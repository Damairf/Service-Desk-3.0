<?php

namespace App\Http\Controllers;
use App\Models\JenisPelayanan;
use Illuminate\Http\Request;

class JenisPelayananController extends Controller
{
    public function getAll_JnsPelayanan(){
        $jenispelayanan = JenisPelayanan::get();
        return response()->json($jenispelayanan);
    }
    public function findOne_JnsPelayanan(Request $request){
        $jnspelayananId = $request->route('jnspelayananId');
        $jnspelayananId = JenisPelayanan::where('ID_Jenis_Pelayanan', $jnspelayananId)->get();

        return response()->json($jnspelayananId);
    }
}

<?php

namespace App\Http\Controllers;
use App\Models\JenisPelayanan;
use App\Models\SubJenisPelayanan;
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
    public function update_JnsPelayanan(Request $request){
        $jnspelayananId = $request->route('jnspelayananId');
        $Nama_Jenis_Pelayanan = $request->Nama_Jenis_Pelayanan;

        JenisPelayanan::where('ID_Jenis_Pelayanan', $jnspelayananId)
        ->update(['Nama_Jenis_Pelayanan'=>$Nama_Jenis_Pelayanan]);

        return response("Jenis Pelayanan Diperbarui");
    }
    public function post_Jenis_Pelayanan(Request $request){
        $Nama_Jenis_Pelayanan = $request->Nama_Jenis_Pelayanan;
        $newJenisPelayanan = JenisPelayanan::create([
            'Nama_Jenis_Pelayanan' => $Nama_Jenis_Pelayanan,
        ]);
        return response(["message" => "Jenis Pelayanan ditambahkan", "data" => $newJenisPelayanan]);
    }
    public function deleteOne_JnsPelayanan(Request $request){
        $jnspelayananId = $request->route('jnspelayananId');
        JenisPelayanan::where('ID_Jenis_Pelayanan', $jnspelayananId)->delete();

        return response("Jenis Pelayanan Dihapus");
    }   
}
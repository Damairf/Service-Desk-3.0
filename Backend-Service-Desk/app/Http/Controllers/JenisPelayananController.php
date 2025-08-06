<?php

namespace App\Http\Controllers;
use App\Models\Alur;
use App\Models\Isi_Alur;
use App\Models\JenisPelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    public function postJenisPelayananFull(Request $request){
        $request->validate([
            'Nama_Jenis_Pelayanan' => 'required|string',
            'Persyaratan' => 'required|string',
            'Langkah_Pelayanan' => 'required|array|min:3',
            'Langkah_Pelayanan.*' => 'required|string'
        ]);
    
        DB::beginTransaction();
        try {
            // 1. Tambah Jenis Pelayanan
            $jenisPelayanan = JenisPelayanan::create([
                'Nama_Jenis_Pelayanan' => $request->Nama_Jenis_Pelayanan,
                'Persyaratan' => $request->Persyaratan,
            ]);
    
            // 2. Tambah setiap Langkah Pelayanan
            foreach($request->Langkah_Pelayanan as $namaLangkah){
                $isiAlur = Isi_Alur::create([
                    'Nama_Alur' => $namaLangkah
                ]);
    
                // 3. Hubungkan ke tabel Alur
                Alur::create([
                    'ID_Jenis_Pelayanan' => $jenisPelayanan->ID_Jenis_Pelayanan,
                    'ID_Isi_Alur' => $isiAlur->ID_Isi_Alur
                ]);
            }
    
            DB::commit();
    
            return response()->json([
                "message" => "Semua data berhasil disimpan",
                "data" => [
                    "jenis_pelayanan" => $jenisPelayanan,
                    "langkah_pelayanan" => $request->Langkah_Pelayanan
                ]
            ], 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Terjadi kesalahan: " . $e->getMessage()], 500);
        }
    }
    
}
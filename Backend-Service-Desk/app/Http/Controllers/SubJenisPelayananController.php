<?php

namespace App\Http\Controllers;
use App\Models\Alur;
use App\Models\Isi_Alur;
use App\Models\JenisPelayanan;
use App\Models\SubJenisPelayanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubJenisPelayananController extends Controller
{
    public function getAll_SubJnsPelayanan(){
        $sub_jenispelayanan = SubJenisPelayanan::get();
        return response()->json($sub_jenispelayanan);
    }
    public function getAll_Alur_SubJnsPelayanan_byId(Request $request){
        $alurId = $request->route("alurId");
        $alur = Alur::with("alur_subjnsPelayanan")->where('ID_Alur', $alurId)->get();
        return response()->json($alur);
    }
    public function findOne_SubJnsPelayanan(Request $request){
        $subjnspelayananId = $request->route('subjnspelayananId');
        $subjnspelayananId = SubJenisPelayanan::where('ID_Sub_Jenis_Pelayanan', $subjnspelayananId)->get();

        return response()->json($subjnspelayananId);
    }
    public function post_Sub_Jenis_Pelayanan(Request $request){
        $Nama_Sub_Jenis_Pelayanan = $request->Nama_Sub_Jenis_Pelayanan;
        $Persyaratan = $request->Persyaratan;

        $newSubJenisPelayanan = SubJenisPelayanan::create([
            'Nama_Sub_Jenis_Pelayanan' => $Nama_Sub_Jenis_Pelayanan,
            'Persyaratan' => $Persyaratan,
            'ID_Jenis_Pelayanan' => $request->ID_Jenis_Pelayanan,
        ]);
        return response(["message" => "Sub Jenis Pelayanan ditambahkan", "data" => $newSubJenisPelayanan]);
    }
    public function post_Sub_Jenis_Pelayanan_Full(Request $request){
        $request->validate([
            'Nama_Sub_Jenis_Pelayanan' => 'required|string',
            'Persyaratan' => 'required|string',
            'ID_Jenis_Pelayanan' => 'required|integer|exists:reff_jenis_pelayanan,ID_Jenis_Pelayanan',
            'Langkah_Pelayanan' => 'required|array|min:3',
            'Langkah_Pelayanan.*' => 'required|string'
        ]);
    
        DB::beginTransaction();
        try {
            // 1. Tambah Jenis Pelayanan
            $subjenisPelayanan = SubJenisPelayanan::create([
                'Nama_Sub_Jenis_Pelayanan' => $request->Nama_Sub_Jenis_Pelayanan,
                'Persyaratan' => $request->Persyaratan,
                'ID_Jenis_Pelayanan' => $request->ID_Jenis_Pelayanan,
            ]);
    
            // 2. Tambah setiap Langkah Pelayanan
            foreach($request->Langkah_Pelayanan as $namaLangkah){
                $isiAlur = Isi_Alur::create([
                    'Nama_Alur' => $namaLangkah
                ]);
    
                // 3. Hubungkan ke tabel Alur
                Alur::create([
                    'ID_Sub_Jenis_Pelayanan' => $subjenisPelayanan->ID_Sub_Jenis_Pelayanan,
                    'ID_Isi_Alur' => $isiAlur->ID_Isi_Alur
                ]);
            }
    
            DB::commit();
    
            return response()->json([
                "message" => "Semua data berhasil disimpan",
                "data" => [
                    "sub_jenis_pelayanan" => $subjenisPelayanan,
                    "langkah_pelayanan" => $request->Langkah_Pelayanan
                ]
            ], 201);
        } catch(\Exception $e) {
            DB::rollBack();
            return response()->json(["error" => "Terjadi kesalahan: " . $e->getMessage()], 500);
        }
    }
}
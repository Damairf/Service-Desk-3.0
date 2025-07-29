<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use Illuminate\Http\Request;


class OrganisasiController extends Controller
{
    public function findAll_Organisasi(){
        $organisasis = Organisasi::select('ID_Organisasi', 'ID_Induk_Organisasi','Nama_OPD', 'Email', 'Status')->with(['induk' => function ($query) {
                $query->select( 'ID_Organisasi','Nama_OPD');
            }])->get();
        return response()->json($organisasis);
    }

    public function jumlah_Organisasi(){
        $OrganisasiCounts = Organisasi::where('Status', 'Aktif')->count();
        
        return response()->json($OrganisasiCounts);
    }

    public function findOne_Organisasi(Request $request){
        $organisasiId = $request->route('organisasiId');
        $jabatan = Organisasi::where('ID_Organisasi', $organisasiId)->with('status')->get();

        return response()->json($jabatan);
    }

    public function insertOne_Organisasi(Request $request){
        $dataOrganisasi = $request->only([
        'Nama_OPD',
        'ID_Induk_Organisasi',
        'Nama_Pengelola',
        'No_HP_Pengelola',
        'Email',
        'Status'
        ]);
        
        $organisasi = Organisasi::create($dataOrganisasi);

        return response()->json([$organisasi->fresh()]);
    }

    public function updateOne_Organisasi(Request $request){
        $organisasiId = $request->route('organisasiId');
        $dataOrganisasi = $request->all();

        $organisasi = Organisasi::where('ID_Organisasi', $organisasiId)->first();

        $organisasi->update($dataOrganisasi);

        return response(["Organisasi Diperbarui menjadi " => $organisasi->fresh()]);
    }

    public function deleteOne_Organisasi(Request $request){
        $organisasiId = $request->route('organisasiId');
        Organisasi::where('ID_Organisasi', $organisasiId)->delete();

        return response("Organisasi Dihapus");
    }
}

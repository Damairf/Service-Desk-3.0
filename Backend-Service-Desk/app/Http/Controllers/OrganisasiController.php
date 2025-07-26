<?php

namespace App\Http\Controllers;

use App\Models\Organisasi;
use Illuminate\Http\Request;


class OrganisasiController extends Controller
{
    public function findAll_Organisasi(){
        $organisasis = Organisasi::select('ID_Organisasi', 'Nama_OPD', 'Status')->get();
        return response()->json($organisasis);
    }

    public function findOne_Organisasi(Request $request){
        $organisasiId = $request->route('organisasiId');
        $jabatan = Organisasi::where('ID_Organisasi', $organisasiId)->with('status')->get();

        return response()->json($jabatan);
    }

    public function insertOne_Organisasi(Request $request){
        $dataOrganisasi = $request->only([
        'Nama_OPD',
        'Induk_OPD',
        'Nama_Pengelola',
        'No_HP_Pengelola',
        'Email',
        'ID_Status'
        ]);
        
        Organisasi::insert($dataOrganisasi);

        return response("Jabatan Ditambahkan", 201);
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

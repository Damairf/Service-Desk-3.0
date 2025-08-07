<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Urgensi;

class UrgensiController extends Controller
{
    public function findAll_Urgensi(){
        $urgensi = Urgensi::get();
        return response()->json($urgensi);
    }

    public function insertOne_Urgensi(Request $request)
    {
        $Nama_Urgensi = $request->Nama_Urgensi;

        Urgensi::create([
            'Nama_Urgensi'=>$Nama_Urgensi,
        ]); 

        return response("Urgensi Ditambahkan", 201);
    }

    public function updateOne_Urgensi(Request $request){
        $urgensiId = $request->route('urgensiId');
        $Nama_Urgensi = $request->Nama_Urgensi;

        Urgensi::where('ID_Urgensi', $urgensiId)
        ->update(['Nama_Urgensi'=>$Nama_Urgensi]);

        return response("Urgensi Diperbarui");
    }
}

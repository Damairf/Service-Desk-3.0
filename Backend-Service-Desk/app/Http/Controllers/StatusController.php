<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Status;

class StatusController extends Controller
{
    
    public function findAll_Status(){
        $status = Status::get();
        return response()->json($status);
    }

    public function updateOne_Status(Request $request){
        $statusId = $request->route('statusId');
        $Nama_Status = $request->Nama_Status;

        Status::where('ID_Status', $statusId)
        ->update(['Nama_Status'=>$Nama_Status]);

        return response("Status Diperbarui");
    }
    public function findAll_Organisasi_Status(){
        $status = Status::with("organisasi")->get();
        return response()->json($status);
    }
    public function findAll_Pelayanan_Status(){
        $status = Status::with("status_pelayanan")->get();
        return response()->json($status);
    }
}

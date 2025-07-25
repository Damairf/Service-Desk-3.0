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
    public function findAll_Organisasi_Status(){
        $status = Status::with("organisasi")->get();
        return response()->json($status);
    }
    public function findAll_Pelayanan_Status(){
        $status = Status::with("status_pelayanan")->get();
        return response()->json($status);
    }
    public function findOne_Status_Organisasi(Request $request){
        $statusId = $request->route("statusId");
        $status = Status::with("organisasi")->where('ID_Status', $statusId)->get();
        return response()->json($status);
    }
    public function findOne_Status_Pelayanan(Request $request){
        $statusId = $request->route("statusId");
        $status = Status::with("status_pelayanan")->where('ID_Status', $statusId)->get();
        return response()->json($status);
    }
}

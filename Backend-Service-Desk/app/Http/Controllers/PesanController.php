<?php

namespace App\Http\Controllers;
use App\Models\Pesan;
use App\Models\Pelayanan;




use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class PesanController extends Controller
{
    public function PesanPengelola(Request $request){
        $pelayananId = $request->route('pelayananId');
        $pesan = Pelayanan::where("ID_Pelayanan", $pelayananId)->with('pelayanan_pesan')->first();

        return response($pesan);

    }
}

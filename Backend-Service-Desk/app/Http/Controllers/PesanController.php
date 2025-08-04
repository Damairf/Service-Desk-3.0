<?php

namespace App\Http\Controllers;
use App\Models\Pesan;
use App\Models\Pelayanan;
use App\Models\User;




use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class PesanController extends Controller
{
    public function kirimPesan(Request $request){
        $pelayananId = $request->route('pelayananId');
        $userId = User::where('ID_User', $request->ID_User)->pluck('ID_User')->first();
        $pesan = $request->Pesan;;

        $pesan = Pesan::create([
            "ID_Pelayanan" => $pelayananId,
            "ID_User" => $userId,
            "Pesan" => $pesan,
        ]);

        return response("Chat Ditambahkan");

    }
}

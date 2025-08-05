<?php

namespace App\Http\Controllers;
use App\Models\Pesan;
use App\Models\Pelayanan;
use App\Models\User;




use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class PesanController extends Controller
{
    public function kirimPesan(Request $request)
{
    $request->validate([
        'ID_User' => 'required|exists:user,ID_User',
        'Pesan' => 'required|string',
        'Dokumen_Path' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:8192',
    ]);

    $pelayananId = $request->route('pelayananId');
    $userId = $request->ID_User;
    $pesan = $request->Pesan;
    $dokumenPath = null;

    // Cek apakah ada file dokumen yang diunggah
    if ($request->hasFile('Dokumen_Path')) {
        $dokumenFile = $request->file('Dokumen_Path');
        $datetime = date('d-m-Y_H-i-s');
        $dokumenName = $datetime . '_' . hash('sha256', time() . $dokumenFile->getClientOriginalName()) . '.' . $dokumenFile->getClientOriginalExtension();
        $dokumenPath = $dokumenFile->storeAs('file/Dokumen_Pesan', $dokumenName, 'public');
        $dokumenPath = 'storage/' . $dokumenPath;
    }

    // Simpan ke tabel pesan
    Pesan::create([
        'ID_Pelayanan' => $pelayananId,
        'ID_User' => $userId,
        'Pesan' => $pesan,
        'Dokumen_Path' => $dokumenPath,
    ]);

    return response()->json(['message' => 'Pesan berhasil dikirim.' , 'dokumen' => $dokumenPath]);
}


}

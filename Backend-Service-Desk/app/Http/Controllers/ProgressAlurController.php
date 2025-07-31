<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgressAlur;
use App\Models\Pelayanan;
use App\Models\Alur;

class ProgressAlurController extends Controller
{
    public function getAlurByPelayanan($id)
    {
        $id_pelayanan = Pelayanan::with('progress_to_pelayanan.progress_to_alur')
            ->where('ID_Pelayanan', $id)
            ->first();
    
        if (!$id_pelayanan) {
            return response()->json(['message' => 'Jenis Pelayanan tidak ditemukan'], 404);
        }
    
        return response()->json($id_pelayanan->progress_to_pelayanan);
    }
    public function updateStatus(Request $request, $idProgress)
    {
        $request->only([
            'Is_Done',
        ]);

        $progress = ProgressAlur::findOrFail($idProgress);
        $progress->Is_Done = $request->Is_Done;
        $progress->save();

        return response()->json(['message' => 'Status progress diperbarui.']);
    }
}
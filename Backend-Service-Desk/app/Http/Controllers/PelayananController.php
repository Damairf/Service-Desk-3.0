<?php

namespace App\Http\Controllers;

use App\Models\Status;
use App\Models\JenisPelayanan;
use Illuminate\Http\Request;
use App\Models\Pelayanan;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


class PelayananController extends Controller
{
    public function getAll_Layanan(){
        $pelayanans = Pelayanan::with('Jenis_Pelayanan', 'status_pelayanan', 'teknis_pelayanan', 'User.user_organisasi')->get();
        return response()->json($pelayanans);
    }

    public function getByID_Layanan(Request $request){
        $pelayananId = $request->route('pelayananId');
        $pelayanan = Pelayanan::where('ID_Pelayanan', $pelayananId)->with('User.user_organisasi', 'Jenis_Pelayanan')->first();

        return response()->json($pelayanan);
    }

    public function getByID_Pelayanan_Jenis_User($id)
    {
        $pelayanan = Pelayanan::select('ID_Pelayanan', 'ID_Jenis_Pelayanan')->find($id);

        if (!$pelayanan) {
            return response()->json(['message' => 'Pelayanan tidak ditemukan'], 404);
        }

        return response()->json($pelayanan);
    }

    // hanya untuk role user mengajukan layanan baru
    public function postLayanan(Request $request){
        $ID_User = User::where('ID_User', $request->ID_User)->pluck('ID_User')->first();
        $ID_Jenis_Pelayanan = $request->ID_Jenis_Pelayanan;
        $Perihal = $request->Perihal;
        $Deskripsi = $request->Deskripsi;
        $Surat_Dinas_Path = $request->Surat_Dinas_Path;
        $Lampiran_Path = $request->Lampiran_Path;
        $ID_Status = $request->ID_Status;

        $newPelayanan = Pelayanan::create([
            'ID_User' => $ID_User,
            'ID_Jenis_Pelayanan' => $ID_Jenis_Pelayanan,
            'Perihal' => $Perihal,
            'Deskripsi' => $Deskripsi,
            'Surat_Dinas_Path' => $Surat_Dinas_Path,
            'Lampiran_Path' => $Lampiran_Path,
            'ID_Status' => $ID_Status,
        ]);

        return response(["message" => "Layanan ditambahkan", "data" => $newPelayanan]);
    }

    // untuk role pengelola memberikan ID Unit Pelaksana
    public function Verif_Pengelola(Request $request){
        $pelayananId = $request->route('pelayananId');
        $dataPelayanan = $request->only([
            'ID_Unit',
            'ID_Status'
        ]);

        $pelayanan = Pelayanan::where('ID_Pelayanan', $pelayananId)->first();

        $pelayanan->update($dataPelayanan);

        return response(["Pelayanan diverifikasi menjadi " => $pelayanan->fresh()]);
    
    }
        
    // hanya untuk role user memberikan survey
    public function putSurvey(Request $request){
        $pelayananId = $request->route('pelayananId');
        $Rating = $request->Rating;
        $Isi_Survey = $request->Isi_Survey;

        Pelayanan::where('ID_Pelayanan', $pelayananId)->update([
            'Rating' => $Rating,
            'Isi_Survey' => $Isi_Survey
        ]);

        $updateSurvey = Pelayanan::where('ID_Pelayanan', $pelayananId)
        ->select('ID_Pelayanan', 'Rating', 'Isi_Survey')
        ->first();

        return response(["message" => "Survey ditambahkan", "data" => $updateSurvey]);
    }

    // untuk role pelaksana teknis mengunggah laporan hasil 
    public function putLaporan_Hasil(Request $request){
        $pelayananId = $request->route('pelayananId');
        $Surat_Laporan_Hasil = $request->Surat_Laporan_Hasil;

        Pelayanan::where('ID_Pelayanan', $pelayananId)->update([
            'Surat_Laporan_Hasil' => $Surat_Laporan_Hasil
        ]);

        $updateLaporan = Pelayanan::where('ID_Pelayanan', $pelayananId)
        ->select('ID_Pelayanan', 'Surat_Laporan_Hasil')
        ->first();

        return response(["message" => "Laporan hasil ditambahkan", "data" => $updateLaporan]);
    }

    public function Pelayanan_byUser(Request $request){
        $userId = User::where('ID_User', $request->ID_User)->pluck('ID_User')->first();
        $pelayanans = Pelayanan::with('jenis_pelayanan', 'status_pelayanan', 'teknis_pelayanan')->where('ID_User', $userId)->get();
        return response()->json($pelayanans);
    }

    public function Chart_PelayananSts(){
        $statusCounts = Pelayanan::select('ID_Status' , Status::raw('count(*) as total'))->with([
        'status_pelayanan' => function ($query) {
            $query->select('ID_Status', 'Nama_Status');
         }])->groupBy('ID_Status')->get();

        $dataPoints = [];
        foreach ($statusCounts as $row) {
            $dataPoints[] = [
                "status" => $row->status_pelayanan->Nama_Status,
                "total" => $row->total
        ];
        }
        return response()->json($dataPoints);
    }

    public function Chart_PelayananJns(){
        $JnsCounts = Pelayanan::select('ID_Jenis_Pelayanan' , JenisPelayanan::raw('count(*) as total'))->with([
        'Jenis_Pelayanan' => function ($query) {
            $query->select('ID_Jenis_Pelayanan', 'Nama_Jenis_Pelayanan');
         }])->groupBy('ID_Jenis_Pelayanan')->get();

        $dataPoints = [];
        foreach ($JnsCounts as $row) {
            $dataPoints[] = [
                "Jenis_Pelayanan" => $row->Jenis_Pelayanan->Nama_Jenis_Pelayanan,
                "total" => $row->total
        ];
        }
        return response()->json($dataPoints);
    }

    public function Chart_PelayananTkns(){
        $TknsCounts = Pelayanan::select('ID_Teknis', User::raw('count(*) as total'))->with([
        'teknis_pelayanan' => function ($query) {   
            $query->select('ID_User', 'Nama_Depan');
         }])->groupBy('ID_Teknis')->get();

        $dataPoints = [];
        foreach ($TknsCounts as $row) {
            $dataPoints[] = [
                "Nama" => $row->teknis_pelayanan->Nama_Depan ?? 'Kosong',
                "total" => $row->total
        ];
        }
        return response()->json($dataPoints);
    }
    public function Chart_PelayananRate(){
        $RateCounts = Pelayanan::select('Rating', Pelayanan::raw('count(*) as total'))->groupBy('Rating')->get();

        $dataPoints = [];
        foreach ($RateCounts as $row) {
            $dataPoints[] = [
                "Rating" => $row->Rating ?? 'Belum Diisi',
                "total" => $row->total
        ];
        }
        return response()->json($dataPoints);
    }

    public function jumlah_Pelayanan(){
        $PelayananCounts = Pelayanan::where('ID_Status', 1)->count();
        
        return response()->json($PelayananCounts);
    }
    

    // untuk user mengunggah file
    public function uploadKeperluan(Request $request)
    {
        $request->validate([
            'surat_dinas' => 'required|file|mimes:pdf|max:8192',
            'lampiran' => 'required|file|mimes:pdf|max:8192',
        ]);

        $suratPath = $request->file('surat_dinas')->store('file/Surat-Dinas', 'public');
        $lampiranPath = $request->file('lampiran')->store('file/lampiran', 'public');

        return response()->json([
            'message' => 'Berkas berhasil diupload',
            'surat_dinas' => 'storage/' . $suratPath,
            'lampiran' => 'storage/' . $lampiranPath,
        ]);
    }

    public function getPdfUrl($filename)
    {
    // Cek apakah file benar-benar ada
    if (!Storage::disk('public')->exists("file/{$filename}")) {
        return response()->json(['message' => 'File not found.'], 404);
    }

    // Dapatkan URL publik
    $url = asset("storage/file/lampiran/{$filename}");

    return response()->json([
        'filename' => $filename,
        'url' => $url
    ]);
    }
}

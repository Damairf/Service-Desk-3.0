<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\Relation;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestPayloadValueResolver;

class UserController extends Controller
{
    
    public function findAll_User(){
        $users = User::get();
        return response()->json($users);
    }
    
    public function createOne_User(Request $request){

        $Nama_Depan = $request->Nama_Depan;
        $Nama_Belakang = $request->Nama_Belakang;
        $NIP = $request->NIP;
        $Password = Hash::make($request->Password);
        $ID_Role = $request->ID_Role;
        $ID_Jabatan = $request->ID_Jabatan;
        $ID_Status = $request->ID_Status;
        $ID_Organisasi = $request->ID_Organisasi;

        $newUser = User::create([
            'Nama_Depan' => $Nama_Depan,
            'Nama_Belakang' => $Nama_Belakang,
            'NIP' => $NIP,
            'Password' => $Password,
            'ID_Role' => $ID_Role,
            'ID_Jabatan' => $ID_Jabatan,
            'ID_Status' => $ID_Status,
            'ID_Organisasi'=> $ID_Organisasi
        ]);

        return response(["message" => "User ditambahkan", "data" => $newUser]);
    }

    public function profile(Request $request){
        $user = User::select('ID_User', 'NIP', 'Nama_Depan', 'Nama_Belakang', 'Gambar_Path')
    ->with([
        'user_role' => function ($query) {
            $query->select('ID_Role', 'Nama_Role');
        },
        'user_jabatan' => function ($query) {
            $query->select('ID_Jabatan', 'Nama_Jabatan');
        },
        'user_organisasi' => function ($query) {
            $query->select('ID_Organisasi', 'Nama_OPD');
        }
    ])
    ->where('ID_User', $request->ID_User)
    ->first();
        return response()->json($user);
    }

    public function update_Password(Request $request){
        $PasswordLama = $request->PasswordLama;
        $PasswordBaru = $request->PasswordBaru;

        $user = User::where("ID_User", $request->ID_User)->first();

    if (!$user) {
        return response()->json(['message' => 'User tidak ditemukan'], 404);
    }

    if (!Hash::check($PasswordLama, $user->Password)) {
        return response()->json(['message' => 'Password lama salah!'], 400);
    }

    $user->Password = Hash::make($PasswordBaru);
    $user->save();

    return response()->json(['message' => 'Password berhasil diubah!'], 200);
}

public function update_Photo(Request $request){
    $userId = User::where('ID_User', $request->ID_User)->pluck('ID_User')->first();

    $Gambar_Path = $request->Gambar_Path;

    User::where('ID_User', $userId)->update(['Gambar_Path'=>$Gambar_Path]);

        return response("Gambar Diperbarui");
}
    public function update_User(Request $request){
        $userId = $request->route('userId');
        $dataUser = $request->except('Password');
        $user = User::where('ID_User', $userId)->first();

        $user->update($dataUser);

        return response(["User Diperbarui menjadi " => $user->fresh()]);
    }
}
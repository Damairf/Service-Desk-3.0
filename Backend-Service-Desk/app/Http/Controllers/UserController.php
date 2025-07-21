<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
        $user = User::where("ID_User", $request->ID_User)->get();

        return response(["message"=>"ini endpoint profile", "data user" => $user]);
    }

    public function update_Profile(Request $request){
        $user = User::where("ID_User", $request->ID_User)->first();
        $Password = Hash::make($request->Password);
        $Nama_Depan = $request->Nama_Depan;

        User::where('ID_User', $user->ID_User)
        ->update(['Nama_Depan'=>$Nama_Depan, 'Password'=>$Password]);


        return response (["profile Anda     diupdate menjadi " => $user->fresh()]);
    }

    public function update_User(Request $request){
        $userId = $request->route('userId');
        $dataUser = $request->except('Password');
        $user = User::where('ID_User', $userId)->first();

        $user->update($dataUser);

        return response(["User Diperbarui menjadi " => $user->fresh()]);
    }
}
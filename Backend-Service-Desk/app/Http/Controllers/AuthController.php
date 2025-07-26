<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
     public function login(Request $request){

        $NIP = $request->NIP;
        $Password = $request->Password;

        $user = User::where('NIP', $NIP)->first();
        

        if(!$user){
            return response("NIP tidak ditemukan", 404);
        }

        if(!Hash::check($Password, $user->Password)){
            return response("Password salah", 401);
        }
       

        $key = env("JWT_SECRET");
        $payload = [
            "ID_User" => $user->ID_User,
            "iat" => time(),
        ];
        $hash = "HS256";

        $token = JWT::encode($payload, $key, $hash);
        $datauser = User::select('Nama_Depan', 'Nama_Belakang', 'Gambar_Path', 'ID_Role')
        ->with([
            'user_role' => function ($query) {
                $query->select('ID_Role', 'Nama_Role');
            }
        ])->where("ID_User", $user->ID_User)->first();


        return response([
            "message" => "Login Berhasil",
            "data" => $token,
            "data_user" => $datauser,
        ]);

    }

}

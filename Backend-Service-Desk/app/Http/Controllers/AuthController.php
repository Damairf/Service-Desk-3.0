<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request){

        $request->validate([
            'NIP' => 'required|string',
            'Password' => 'required|string',
        ]);

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
        $datauser = User::select('ID_User','Nama_Depan', 'Nama_Belakang', 'Gambar_Path', 'ID_Role')
        ->with([
            'user_role' => function ($query) {
                $query->select('ID_Role', 'Nama_Role');
            }
        ])->where("ID_User", $user->ID_User)->first();

        // untuk debugging (hapus jika production)
        if (!$request->has('recaptcha_token')) {
            // Skip reCAPTCHA verification
            return response([
                "token" => $token,
                "data_user" => $datauser,
                "bypass_recaptcha" => true,
            ]);
        }

        $recaptchaToken = $request->input('recaptcha_token');
        $secretKey = env('RECAPTCHA_SECRET');

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => $secretKey,
            'response' => $recaptchaToken
        ]);

        $result = $response->json();
        if (!$result['success'] || $result['score'] < 0.5) {
            return response()->json(['message' => 'reCAPTCHA gagal, terdeteksi aktivitas mencurigakan'], 400);
        }
            return response([
                "token" => $token,
                "data_user" => $datauser,
            ]);
    }
}

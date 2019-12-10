<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('nik', $request->nik)->first();
        if($user){
            if (Hash::check($request->password,$user->password)) {
                    return response()->json([
                        'status' => true,
                        'data' => $user,
                        'api_token' => $user->createToken($user->nik)->accessToken
                    ],200);
            }else{
                    return response()->json(['status' => false],401);
            }
        }else{
                return response()->json(['status' => false],401);
        }
    }
    public function getUser(Request $req){
        $nik = $req->nik;
        $user = User::where('nik',$nik)->first();
        if($user){
            return response()->json([
                'status' => true,
                'data' => $user
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'data' => 'NIK tidak ada!'
            ],401);
        }
    }

    public function setUser(Request $req){
        $nik = $req->nik;
        if($nik){
            $data = [
                'email' => e($req->email),
                'no_hp' => e($req->no_hp),
                'password' => Hash::make($req->password),
            ];
            $res = User::where('nik',$nik)
                    ->update($data);
            return response()->json([
                'status' => true,
                'data' => $res
            ],200);
        }else{
            return response()->json([
                'status' => false
            ],401);
        }
    }
}

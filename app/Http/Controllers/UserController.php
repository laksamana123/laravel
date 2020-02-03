<?php

namespace App\Http\Controllers;

use App\User;
use Session;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
        return response()->json(compact('token'));
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telp' => 'required|max:12',
            'username' => 'required|string|max:200',
            'password' => 'required|string|min:6',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'nama_petugas' => $request->get('nama_petugas'),
            'alamat' => $request->get('alamat'),
            'telp' => $request->get('telp'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
        ]);
        $token = JWTAuth::fromUser($user);
        $update = User::where('nama_petugas',$request->nama_petugas)->update([
            'nama_petugas' => $request->get('nama_petugas'),
            'alamat' => $request->get('alamat'),
            'telp' => $request->get('telp'),
            'username' => $request->get('username'),
            'password' => Hash::make($request->get('password')),
            'token' => $token
        ]);
        $tambahan = "token telah disimpan di database";

        return response()->json(compact('user','token','tambahan'),201);
    }
    public function updatepetugas($id,Request $request){
        $petugas1 = Auth::user()->id;
        $level =Auth::user()->id_level;
        if($petugas1 == $id){
            $update = User::where('id',$id)->update([
                'nama_petugas' => $request->get('nama_petugas'),
                'alamat' => $request->get('alamat'),
                'telp' => $request->get('telp'),
                'username' => $request->get('username'),
                'password' => Hash::make($request->get('password')),
            ]);
            if($update){
                $status = "Data anda berhasil diperbarui";
                return response()->json(compact('status'));
            }
            else{
                $status = "Data anda gagal diperbarui";
                return response()->json(compact('status'));
            }
        }
        else{
            $peringatan = "Anda hanya bisa memperbarui data anda sendiri";
            return response()->json(compact('peringatan'));
        }
    }
    public function destroy($id){
        $level =Auth::user()->id_level;
        if($level == 2){
            $hapus = User::where('id',$id)->delete();
            if($hapus){
            $status = "Data berhasil dihapus :)";
            return response()->json(compact('status'));
            }
            else{
            $status = "Data gagal dihapus :(";
            return response()->json(compact('status'));
           }
        }
        else{
            $status = "Anda tidak ada hak untuk menghapus";
            return response()->json(compact('status'));
        }
    }

    public function getAuthenticatedUser()
    {
        try {

            if (! $user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }
}

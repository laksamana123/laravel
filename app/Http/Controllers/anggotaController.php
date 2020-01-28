<?php

namespace App\Http\Controllers;

use App\Anggota;
use Session;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class anggotaController extends Controller
{
    public function addanggota(Request $req){
        $anggota = Anggota::create([
            'nama_anggota' => $req->get('nama_anggota'),
            'alamat' => $req->get('alamat'),
            'telp' => $req->get('telp'),
        ]);
        if($anggota){
            $status = "Data anggota berhasil ditambahkan :)";
            return response()->json(compact('status'));
        }
        else{
            $status = "Data anggota gagal ditambahkan :(";
            return response()->json(compact('status'));
        }
        }
        public function updateanggota($id,Request $req){
            $validator = Validator::make($req->all(),[
                'nama_anggota' => 'required',
                'alamat' => 'required',
                'telepon' => 'required|max:12',
            ]);
            if($validator->fails()){
                return response()->json('Data salah / data belum lengkap');
            }
            $anggota = anggota::where('id',$id)->update([
                'nama_anggota' => $req->get('nama_anggota'),
                'alamat' => $req->get('alamat'),
                'telp' => $req->get('telp'),
            ]);
            if($anggota){
                $status = "Data anggota berhasil ditambahkan :)";
                return response()->json(compact('status'));
            }
            else{
                $status = "Data anggota gagal ditambahkan :(";
                return response()->json(compact('status'));
            }
        }
        public function destroy($id){
            $nama = anggota::where('id',$id)->get('nama_anggota');
            $hapus = anggota::where('id',$id)->delete();
            if($hapus){
                $status = "Data anggota bernama ".$nama." berhasil dihapus :)";
                return response()->json(compact('status','nama'));
            }
            else{
                $status = "Data anggota bernama ".$nama." gagal dihapus :(";
                return response()->json(compact('status','nama'));
            }
        }
        public function search(Request $req){
            $search = $req->get('nama_anggota');
            $hasil = DB::table('anggota')->where('nama_anggota','like','%'.$search.'%')->get();
            return response()->json(compact('search','hasil'));
        }
}

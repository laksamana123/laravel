<?php

namespace App\Http\Controllers;

use App\buku;
use Session;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use DB;

class bukuController extends Controller
{
    public function addbuku(Request $req){
    $validator = Validator::make($req->all(),[
        'judul' => 'required',
        'penerbit' => 'required',
        'pengarang' => 'required|string',
    ]);
    if($validator->fails()){
        return response()->json('Data salah / data belum lengkap');
    }
    $buku = buku::create([
        'judul' => $req->get('judul'),
        'penerbit' => $req->get('penerbit'),
        'pengarang' => $req->get('pengarang'),
    ]);
    if($buku){
        $status = "Data buku berhasil ditambahkan :)";
        return response()->json(compact('status'));
    }
    else{
        $status = "Data buku gagal ditambahkan :(";
        return response()->json(compact('status'));
    }
    }
    public function updatebuku($id,Request $req){
        $validator = Validator::make($req->all(),[
            'judul' => 'required',
            'penerbit' => 'required',
            'pengarang' => 'required|string',
        ]);
        if($validator->fails()){
            return response()->json('Data salah / data belum lengkap');
        }
        $buku = buku::where('id',$id)->update([
            'judul' => $req->get('judul'),
            'penerbit' => $req->get('penerbit'),
            'pengarang' => $req->get('pengarang'),
        ]);
        if($buku){
            $status = "Data buku berhasil diperbarui :)";
            return response()->json(compact('status'));
        }
        else{
            $status = "Data buku gagal diperbarui :(";
            return response()->json(compact('status'));
        }
    }
    public function destroy($id){
        $nama = buku::where('id',$id)->first();
        $hapus = buku::where('id',$id)->delete();
        if($hapus){
            $status = "Data buku berjudul ".$nama->judul." berhasil dihapus :)";
            return response()->json(compact('status'));
        }
        else{
            $status = "Data buku berjudul ".$nama." gagal dihapus :(";
            return response()->json(compact('status'));
        }
    }
    public function search(Request $req){
        $search = $req->get('judul');
        $hasil = DB::table('buku')->where('judul','like','%'.$search.'%')->get();
        return response()->json(compact('search','hasil'));
    }
}

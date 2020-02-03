<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use DB;
use Auth;
use Session;
use App\peminjaman;
use App\Anggota;
use App\petugas;
use App\detail_pinjam;

class peminjamanController extends Controller
{
    public function insert(request $r){
      $validator = Validator::make($r->all(),
      [
          'id_anggota' => 'required',
          'id_buku' => 'required',
          'qty' => 'required'
      ]);
      if($validator->fails()){
          return response()->json('Invalid Input');
      }
      $tanggal = date("Y-m-d H:i:s");
      $deadline = date("Y-m-d H:i:s", strtotime('+7 days',strtotime($tanggal)));
      $id = 2;
      if(Auth::user()->id_level == $id){
         $peminjaman = peminjaman::create([
          'tgl_pinjam' => $tanggal,
          'id_anggota' => $r->id_anggota,
          'id_petugas' => Auth::user()->id,
          'tgl_deadline' => $deadline,
          'denda' => "0",
        ]);
        if($peminjaman){
          $anggota = peminjaman::where('tgl_pinjam',$tanggal)->first();
          $detail = detail_pinjam::create([
              'id_pinjam' => $anggota->id,
              'id_buku' => $r->id_buku,
              'qty' => $r->qty
          ]);
          if($detail){
              $status = "berhasil input";
              return response()->json(compact('status'));
          }
          else{
            $status = "gagal input";
            return response()->json(compact('status'));
          }
        }
        else{
            $status = "gagal input";
            return response()->json(compact('status'));
        }
      }
      else{
        $status = "anda bukan petugas";
        return response()->json(compact('status'));
      }
    }
    public function show($id){
        $datapinjam = DB::table('peminjaman')->join('anggota','peminjaman.id_anggota','=','anggota.id')
                      ->where('peminjaman.id','=',$id)
                      ->select('peminjaman.*','anggota.*')->first();
        $data_peminjam = array();
            $buku = DB::table('detail_pinjam')->join('buku','detail_pinjam.id_buku','=','buku.id')
                    ->where('detail_pinjam.id_pinjam','=',$id)
                    ->select('detail_pinjam.*','buku.*')->get();
            $arr_buku = array();
            foreach($buku as $b){
                $arr_buku[] = array(
                    'nama buku' => $b->judul,
                    'jumlah dipinjam' => $b->qty
                );
            }
            $data_peminjam[] = array(
                'id anggota' => $datapinjam->id_anggota,
                'nama anggota' => $datapinjam->nama_anggota,
                'id petugas' => $datapinjam->id_petugas,
                'tanggal pinjam' => $datapinjam->tgl_pinjam,
                'tanggal deadline' => $datapinjam->tgl_deadline,
                'denda' => $datapinjam->denda,
                'daftar buku dipinjam' => $arr_buku 
            );   
        return response()->json(compact('data_peminjam'));
    }
}

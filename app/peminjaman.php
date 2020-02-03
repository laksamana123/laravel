<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class peminjaman extends Model
{
    protected $table="peminjaman";
    protected $fillable=['tgl_pinjam','id_anggota','id_petugas','tgl_deadline','denda'];
    public function anggota(){
        return this()->hasOne('App\Anggota','id_anggota');
    }
    public function petugas(){
        return this()->hasOne('App\petugas','id_petugas');
    }
}

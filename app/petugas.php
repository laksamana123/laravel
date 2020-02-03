<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class petugas extends Model
{
    protected $table="petugas";
    protected $fillable=['nama_petugas','alamat','telp','username','password','created_at'];
    public function peminjaman(){
        return this()->hasMany('App\Peminjaman','id');
    }
   
}

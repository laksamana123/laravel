<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Anggota extends Model
{
    protected $table="anggota";
    protected $fillable=['nama_anggota','alamat','telepon'];
    public function peminjaman(){
        return this()->hasMany('App\Peminjaman','id');
    }
}

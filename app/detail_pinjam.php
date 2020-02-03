<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detail_pinjam extends Model
{
    protected $table="detail_pinjam";
    protected $fillable = ['id_pinjam','id_buku','qty'];
    public function buku(){
        return this()->hasMany('App\buku','id_buku');
    }
}

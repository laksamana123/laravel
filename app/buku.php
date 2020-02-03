<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class buku extends Model
{
    protected $table="buku";
    protected $fillable=['judul','penerbit','pengarang','foto'];
    public function detail_pinjam(){
        return this()->hasMany('App\detail_pinjam','id');
}
}

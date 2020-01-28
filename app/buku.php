<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class buku extends Model
{
    protected $table="buku";
    protected $fillable=['judul','penerbit','pengarang','foto'];
}

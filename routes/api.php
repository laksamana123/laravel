<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//petugas
Route::post('register', 'UserController@register');
Route::post('login', 'UserController@login');
Route::put('update/{user}','userController@updatepetugas')->middleware('jwt.verify');
Route::get('/',function(){
    return Auth::user()->id_level;
})->middleware('jwt.verify');
Route::delete('deleteuser/{user}','userController@destroy')->middleware('jwt.verify');
//buku
Route::post('searchbuku','bukuController@search')->middleware('jwt.verify');
Route::post('addbuku','bukuController@addbuku')->middleware('jwt.verify');
Route::put('updatebuku/{buku}','bukuController@updatebuku')->middleware('jwt.verify');
Route::delete('deletebuku/{buku}','bukuController@destroy')->middleware('jwt.verify');
//anggota
Route::post('searchanggota','anggotaController@search')->middleware('jwt.verify');
Route::post('addanggota','anggotaController@addanggota')->middleware('jwt.verify');
Route::put('updateanggota/{anggota}','anggotaController@updateanggota')->middleware('jwt.verify');
Route::delete('deleteanggota/{anggota}','anggotaController@destroy')->middleware('jwt.verify');
//peminjaman
Route::post('addpinjam','peminjamanController@insert')->middleware('jwt.verify');
Route::get('showpinjam/{id}','peminjamanController@show')->middleware('jwt.verify');

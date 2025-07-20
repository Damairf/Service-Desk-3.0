<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CekToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//endpoint login
Route::post('/user/login',[AuthController::class, 'login']);

Route::middleware([CekToken::class])->group(function(){

// endpoint fitur umum
Route::get('/user/profile',[UserController::class, 'profile']);
Route::put('/user/profile', [UserController::class, 'update_Profile']);


Route::get('/user/profile',[AuthController::class, 'profile']);
Route::get('/user/edit',[AuthController::class, 'edit']);
Route::get('/user/laporan',[AuthController::class, 'laporan']);

// api User Keseluruhan
Route::post('/user',[UserController::class, 'createOne_User']);
Route::get('/user',[UserController::class, 'findAll_User']);
Route::post('/user',[UserController::class, 'createOne_User']);
Route::put('/user/{userId}', [UserController::class, 'update_User']);

Route::get('/role',[RoleController::class, 'findAll_Role']);
Route::get('/role/{roleId}',[RoleController::class, 'findOne_Role']);

Route::get('/jabatan',[JabatanController::class, 'findAll_Jabatan']);
Route::get('/jabatan/{jabatanId}',[JabatanController::class, 'findOne_Jabatan']);
Route::post('/jabatan',[JabatanController::class, 'insertOne_Jabatan']);
Route::put('/jabatan/{jabatanId}',[JabatanController::class, 'updateOne_Jabatan']);
Route::delete('/jabatan/{jabatanId}',[JabatanController::class, 'deleteOne_Jabatan']);

Route::get('/organisasi',[OrganisasiController::class, 'findAll_Organisasi']);
Route::get('/organisasi/{organisasiId}',[OrganisasiController::class, 'findOne_Organisasi']);
Route::post('/organisasi',[OrganisasiController::class, 'insertOne_Organisasi']);
Route::put('/organisasi/{organisasiId}',[OrganisasiController::class, 'updateOne_Organisasi']);
Route::delete('/organisasi/{organisasiId}',[OrganisasiController::class, 'deleteOne_Organisasi']);

Route::get('/status',[StatusController::class, 'findAll_Status']);
Route::get('/status/{statusId}',[StatusController::class, 'findOne_Status']);

Route::get('/pelayanan',[PelayananController::class, 'getAll_Permintaan']);

// endpoint unit pelaksana

// endpoint pelaksana teknis

// endpoint kepala dinas

// api Pelayanan
Route::get('/pelayanan',[PelayananController::class, 'getAll_Layanan']);
Route::post('/pelayanan/tambah',[PelayananController::class, 'postLayanan']);
});
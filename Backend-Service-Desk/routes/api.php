<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JenisPelayananController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AlurController;
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
Route::put('/user/profile', [UserController::class, 'update_Password']);
Route::post('/user/profilepict', [UserController::class, 'update_Photo']);
Route::delete('/user/profilepict', [UserController::class, 'delete_Photo']);


// endpoint user
Route::get('/role/{roleId}', [RoleController::class, 'findOne_Role']);
Route::get('/jenispelayanan',[JenisPelayananController::class, 'getAll_JnsPelayanan']);
Route::get('/jenispelayanan/{jnspelayananId}',[JenisPelayananController::class, 'findOne_JnsPelayanan']);

Route::post('/pelayanan/tambah',[PelayananController::class, 'postLayanan']);
Route::post('/uploadKeperluan',[PelayananController::class, 'uploadKeperluan']);
Route::put('/pelayanan/tambah/survey/{pelayananId}',[PelayananController::class, 'putSurvey']);
Route::get('/pelayananUser',[PelayananController::class, 'Pelayanan_byUser']);
Route::get('/pelayananUser/{pelayananId}',[PelayananController::class, 'getByID_Pelayanan_Jenis_User']);
Route::get('/alur/jenis_pelayanan/{id}',[AlurController::class, 'getAlurByJenisPelayanan']);



// endpoint pengelola
Route::post('/user',[UserController::class, 'createOne_User']);
Route::get('/user',[UserController::class, 'findAll_User']);
Route::post('/user',[UserController::class, 'createOne_User']);
Route::put('/user/{userId}', [UserController::class, 'update_User']);
Route::get('/userCount',[UserController::class, 'jumlah_User']);


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
Route::get('/organisasiCount',[OrganisasiController::class, 'jumlah_Organisasi']);


Route::get('/status',[StatusController::class, 'findAll_Status']);
Route::get('/status/organisasi',[StatusController::class, 'findAll_Organisasi_Status']);
Route::get('/status/pelayanan',[StatusController::class, 'findAll_Pelayanan_Status']);
Route::get('/status/pelayanan/{statusId}',[StatusController::class, 'findOne_Status_Pelayanan']);
Route::get('/status/{statusId}',[StatusController::class, 'findOne_Status']);

Route::get('/pelayanan',[PelayananController::class, 'getAll_Layanan']);
Route::put('/pelayanan/{pelayananId}', [PelayananController::class, 'Verif_Pengelola']);
Route::get('/stsPelayananChart',[PelayananController::class, 'Chart_PelayananSts']);
Route::get('/jnsPelayananChart',[PelayananController::class, 'Chart_PelayananJns']);
Route::get('/TknsPelayananChart',[PelayananController::class, 'Chart_PelayananTkns']);
Route::get('/ratePelayananChart',[PelayananController::class, 'Chart_PelayananRate']);
Route::get('/allPelayanan',[PelayananController::class, 'jumlah_Pelayanan']);
Route::post('/jenis_pelayanan/alur',[AlurController::class, 'postAlur']);

Route::get('/pdf/{filename}', [PelayananController::class, 'getPdfUrl']);




// endpoint unit pelaksana

// endpoint pelaksana teknis
Route::put('/pelayanan/tambah/hasil/{pelayananId}',[PelayananController::class, 'putLaporan_Hasil']);
Route::get('/status/pelayanan/{statusId}',[StatusController::class, 'findOne_Status_Pelayanan']);

// endpoint kepala dinas
Route::get('/pelayanan/{pelayananId}',[PelayananController::class, 'getByID_Layanan']);
Route::get('/pelayanan',[PelayananController::class, 'getAll_Layanan']);

});
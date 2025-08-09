<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\JenisPelayananController;
use App\Http\Controllers\SubJenisPelayananController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\PelayananController;
use App\Http\Controllers\PesanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AlurController;
use App\Http\Controllers\ProgressAlurController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UrgensiController;
use App\Http\Middleware\CekToken;
use App\Models\JenisPelayanan;
use Illuminate\Support\Facades\Route;


//endpoint login
Route::post('/user/login',[AuthController::class, 'login']);

Route::middleware([CekToken::class])->group(function(){

// endpoint fitur umum
Route::get('/user/profile',[UserController::class, 'profile']);
Route::put('/user/profile', [UserController::class, 'update_Password']);
Route::post('/user/profilepict', [UserController::class, 'update_Photo']);
Route::delete('/user/profilepict', [UserController::class, 'delete_Photo']);
Route::post('/pesan/{pelayananId}',[PesanController::class, 'kirimPesan']);


// endpoint user
Route::get('/role/{roleId}', [RoleController::class, 'findOne_Role']);
Route::get('/subjenispelayanan',[SubJenisPelayananController::class, 'getAll_SubJnsPelayanan']);
Route::get('/subjenispelayanan/{subjnspelayananId}',[SubJenisPelayananController::class, 'findOne_SubJnsPelayanan']);

Route::post('/pelayanan/tambah',[PelayananController::class, 'postLayanan']);
Route::post('/uploadKeperluan',[PelayananController::class, 'uploadKeperluan']);
Route::put('/pelayanan/survey/{pelayananId}',[PelayananController::class, 'putSurvey']);
Route::get('/pelayananUser',[PelayananController::class, 'Pelayanan_byUser']);
Route::get('/pelayananUser/{pelayananId}',[PelayananController::class, 'getByID_Pelayanan_Jenis_User']);
// Route::get('/pelayanan/teknis/{pelayananId}',[PelayananController::class, 'getTeknis']);

Route::get('/alur/sub_jenis_pelayanan/{id}',[AlurController::class, 'getAlurBySubJenisPelayanan']);
Route::get('/pelayanan/alur/progress/{id}',[ProgressAlurController::class, 'getAlurByPelayanan']);


// endpoint pengelola
Route::post('/user',[UserController::class, 'createOne_User']);
Route::get('/user',[UserController::class, 'findAll_User']);
Route::post('/user',[UserController::class, 'createOne_User']);
Route::put('/user/{userId}', [UserController::class, 'update_User']);
Route::get('/userCount',[UserController::class, 'jumlah_User']);
Route::get('/pelayanan/unit',[UserController::class, 'getUnit']);


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
Route::put('/status/{statusId}',[StatusController::class, 'updateOne_Status']);
Route::get('/status/pelayanan',[StatusController::class, 'findAll_Pelayanan_Status']);
Route::get('/status/pelayanan/{statusId}',[StatusController::class, 'findOne_Status_Pelayanan']);
Route::get('/status/{statusId}',[StatusController::class, 'findOne_Status']);
Route::put('/progress-alur/update-status/{id}', [ProgressAlurController::class, 'updateStatus']);

Route::get('/urgensi',[UrgensiController::class, 'findAll_Urgensi']);
Route::put('/urgensi/{urgensiId}',[UrgensiController::class, 'updateOne_Urgensi']);
Route::post('/urgensi',[UrgensiController::class, 'insertOne_Urgensi']);

Route::get('/pelayanan',[PelayananController::class, 'getAll_Layanan']);
Route::get('/stsPelayananChart',[PelayananController::class, 'Chart_PelayananSts']);
Route::get('/stsPelayananChartBulanIni',[PelayananController::class, 'Chart_PelayananStsBulanIni']);
Route::get('/jnsPelayananChart',[PelayananController::class, 'Chart_PelayananJns']);
Route::get('/TknsPelayananChart',[PelayananController::class, 'Chart_PelayananTkns']);
Route::get('/ratePelayananChart',[PelayananController::class, 'Chart_PelayananRate']);
Route::get('/allPelayanan',[PelayananController::class, 'jumlah_Pelayanan']);
Route::get('/pdf/{filename}', [PelayananController::class, 'getPdfUrl']);
Route::put('/pelayanan/disposisi/{pelayananId}', [PelayananController::class, 'disposisi']);

Route::get('/isi_alur',[AlurController::class, 'getAll_IsiAlur']);
Route::post('/sub_jenis_pelayanan/tambah',[SubJenisPelayananController::class, 'post_Sub_Jenis_Pelayanan']);
Route::post('/isi_alur/tambah',[AlurController::class, 'postIsi_Alur']);
Route::post('/sub_jenis_pelayanan/alur',[AlurController::class, 'postAlur']);
Route::post('/sub_jenis_pelayanan/tambah/full',[SubJenisPelayananController::class, 'post_Sub_Jenis_Pelayanan_Full']);

// endpoint unit pelaksana

Route::get('/unit/pelayanan/',[PelayananController::class, 'getPelayananUnit']);
Route::get('/pelayanan/allTeknis',[UserController::class, 'getAllTeknis']);
Route::get('/unit/pelayanan/disposisi',[PelayananController::class, 'getDisposisiUnit']);

// endpoint pelaksana teknis
Route::get('/teknis/pelayanan/proses', [PelayananController::class, 'getPelayananTeknisNotDone']);
Route::get('/teknis/pelayanan/selesai', [PelayananController::class, 'getPelayananTeknisDone']);
Route::get('/pelayanan/disposisi/teknis', [PelayananController::class, 'getDisposisiPelayananIDTeknis']);
Route::get('/pelayanan/hasil/teknis', [PelayananController::class, 'getHasilPelayananIDTeknis']);

Route::put('/pelayanan/tambah/hasil/{pelayananId}',[PelayananController::class, 'putLaporan_Hasil']);
Route::get('/status/pelayanan/{statusId}',[StatusController::class, 'findOne_Status_Pelayanan']);

// endpoint kepala dinas
Route::get('/pelayanan/{pelayananId}',[PelayananController::class, 'getByID_Layanan']);
Route::get('/pelayanan',[PelayananController::class, 'getAll_Layanan']);

});
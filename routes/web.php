<?php

use App\Http\Controllers\DataServerController;
use App\Http\Controllers\DetailPenyediaController;
use App\Http\Controllers\DomainController;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\RakserverController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\WhmController;
use App\Http\Controllers\PermohonanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IpCheckController;

Route::get('/', [UserController::class,'login'])->name('login');
Route::get('/register',[UserController::class,'register'])->name('register');
Route::post('/register',[UserController::class,'registerStore'])->name('register.store');
Route::post('/login',[UserController::class,'loginCheck'])->name('login.check');
Route::resource('users',UserController::class);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::get('/dashboard', function() {
    return view('admin.dashboard');
})->name('dashboard')->middleware('auth');

Route::get('/logout', [UserController::class,'logout'])->name('logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/produk', [ProdukController::class, 'index'])->name('produk.index');
    route::get('/produk/logproduk', [ProdukController::class, 'logproduk'])->name('produk.logproduk');
    Route::resource('produk', ProdukController::class);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/mitra', [DetailPenyediaController::class, 'index'])->name('mitra.index');
    Route::resource('mitra', DetailPenyediaController::class);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/whm', [WhmController::class, 'index'])->name('whm.index');
    Route::resource('whm', WhmController::class);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/server', [DataServerController::class, 'index'])->name('server.index');
    Route::get('/get-satuan/{kd_ktm}', [DataServerController::class, 'getSatuan']);
    Route::resource('server', DataServerController::class);
});
    
Route::group(['middleware' => ['auth']], function () {
    Route::get('/domain', [DomainController::class, 'index'])->name('domain.index');
    Route::resource('domain', DomainController::class);
});
    
Route::group(['middleware' => ['auth']], function () {
    Route::get('/rakserver', [RakserverController::class, 'index'])->name('rakserver.index');
    Route::resource('rakserver', RakserverController::class);
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/pengaduan', [PengaduanController::class, 'index'])->name('pengaduan.index');
    Route::post('/pengaduan/store', [PengaduanController::class, 'store'])->name('pengaduan.store');
    Route::post('/pengaduan/{id}',[PengaduanController::class,'index'])->name('pengaduan.create');
    // Route::get('/pengaduan/{id}', [PengaduanController::class, 'viewFile']);
    Route::post('/app/uploads', [PengaduanController::class, 'handleFileUpload']);
    Route::resource('pengaduan', PengaduanController::class);    
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/permohonan', [PermohonanController::class, 'index'])->name('permohonan.index');
    Route::post('/permohonan/store', [PermohonanController::class, 'store'])->name('permohonan.store');
    Route::post('/permohonan/{id}',[PermohonanController::class,'index'])->name('permohonan.create');
    Route::post('/app/uploads', [PermohonanController::class, 'handleFileUpload']);
    Route::resource('permohonan', PermohonanController::class);    
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/ipcheck', [IpCheckController::class, 'index'])->name('ipcheck.index');
    Route::post('/ipcheck/check-ip', [IpCheckController::class, 'checkIp'])->name('ipcheck.checkIp');
});

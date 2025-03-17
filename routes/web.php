<?php

use App\Http\Controllers\DetailPenyediaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\WhmController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropDownController;

Route::get('/', [UserController::class,'login'])->name('login');
Route::get('/register',[UserController::class,'register'])->name('register');
Route::post('/register',[UserController::class,'registerStore'])->name('register.store');
Route::post('/login',[UserController::class,'loginCheck'])->name('login.check');
Route::resource('users',UserController::class);

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




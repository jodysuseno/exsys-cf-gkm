<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GejalaController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\PenyakitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
Route::group(['middleware' => ['role:admin,pakar,perawat', 'auth']], function () {
  Route::get('/', [AppController::class, 'dashboard'])->name('dashboard');
  Route::get('/dashboard', [AppController::class, 'dashboard'])->name('dashboard');
  Route::resource('/pasien', PasienController::class);
  // Data admin
  // Route::resource('/gejala', GejalaController::class);
  // Route::resource('/penyakit', PenyakitController::class);
});

Route::group(['middleware' => ['role:admin', 'auth']], function () {
  Route::get('/data_admin', [UserController::class, 'admin_index'])->name('admin_index');
  Route::get('/data_pakar', [UserController::class, 'pakar_index'])->name('pakar_index');
  Route::get('/data_perawat', [UserController::class, 'perawat_index'])->name('perawat_index');
  Route::resource('/user', UserController::class);

});

Route::middleware(['guest'])->group(function () {
  Route::get('/login', [AppController::class, 'login'])->name('login'); 
  Route::post('/proses_login', [AppController::class, 'proses_login'])->name('proses_login'); 
});

Route::get('/logout', [AppController::class, 'logout'])->name('logout');
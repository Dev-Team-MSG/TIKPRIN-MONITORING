<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PrinterController;
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

Route::post('/', [AuthController::class, 'login'])->name('login');
Route::get('/', [AuthController::class, 'index'])->name('login');


// Route::group(['middleware' => 'CekLoginMiddleware'], function(){
Route::group(['middleware' => 'auth'], function(){
    Route::get('dashboard', function () {return view('index');});

    //Route User
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('users/tambah', [UserController::class, 'tambah'])->name('users.tambah');
    Route::get('users/{id}/detail', [UserController::class, 'detail'])->name('users.detail');
    Route::post('users/import', [UserController::class, 'import'])->name('users.import');
    Route::post('users', [UserController::class, 'simpan'])->name('users.simpan');
    Route::delete('users/{id}', [UserController::class, 'hapus'])->name('users.hapus');
    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');

    //Route Printer
    Route::resource('printers', PrinterController::class);
    Route::post('printers/import', [PrinterController::class, 'import'])->name('printers.import');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

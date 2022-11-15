<?php

use App\Http\Controllers\AccessController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PrinterController;
use App\Http\Controllers\KanimController;
use App\Http\Controllers\PrinterKanimController;

use App\Http\Controllers\CrudController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ReportController;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;


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
    Route::get('dashboard', function () {
        return view('index');
    });

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

    //Route Kanim
    Route::resource('kanims', KanimController::class);
    Route::post('kanims/import', [KanimController::class, 'import'])->name('kanims.import');

    //Route PrinterKanim
    Route::resource('printerkanims', PrinterKanimController::class);

    //Route Tiket
    Route::get("/tiket", [TicketController::class, "showAllTicket"])->name("semua-tiket");
    // Route::get("/tiket", [TicketController::class, "buatTiket"])->name("view-create-ticket");
    Route::post("/tiket", [TicketController::class, "simpanTiket"])->name("store-create-ticket");
    Route::get("/tiket/{no_ticket}",[TicketController::class, "detailTicket"])->name("detail-ticket");
    Route::post("/ticket/{no_ticket}/ambil", [TicketController::class, "take"])->name("ambil-tiket");
    Route::get("/open-tiket", [TicketController::class, "showOpenTicket"])->name("list-open-ticket");
    Route::get("/progress-tiket", [TicketController::class, "showProgressTicket"])->name("list-progress-ticket");
    Route::get("/close-tiket", [TicketController::class, "showCloseTicket"])->name("list-close-ticket");
    
    Route::resource("roles",RoleController::class);
    Route::resource("permission", AccessController::class);
    Route::resource("reports", ReportController::class);
    Route::post("reports-tiket", [ReportController::class, "reportTiket"])->name("reports.tiket");
    Route::post("reports-relokasi-printer", [ReportController::class, "reportRelokasiPrinter"])->name("reports.relokasi-printer");
    // Route::get("konfigurasi/akses", [AccessController::class, "create"]);
});
Route::resource("menus", MenuController::class);







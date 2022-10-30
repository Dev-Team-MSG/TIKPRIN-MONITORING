<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Models\Ticket;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::get("/tiket", [TicketController::class, "showAllTicket"])->name("semua-tiket");
Route::get("/create-tiket", [TicketController::class, "buatTiket"])->name("view-create-ticket");
Route::post("/tiket", [TicketController::class, "simpanTiket"])->name("store-create-ticket");
Route::get("/tiket/{no_ticket}",[TicketController::class, "detailTicket"])->name("detail-ticket");
Route::post("/ticket/{no_ticket}/ambil", [TicketController::class, "take"])->name("ambil-tiket");
Route::get("/tikets/open", [TicketController::class, "showOpenTicket"])->name("list-open-ticket");
Route::get("/tikets/progress", [TicketController::class, "showProgressTicket"])->name("list-progress-ticket");
Route::get("/tikets/close", [TicketController::class, "showCloseTicket"])->name("list-close-ticket");
Route::resource("kategori",CategoryController::class);
Route::resource("permission",PermissionController::class);
Route::resource("roles",RoleController::class);
require __DIR__.'/auth.php';

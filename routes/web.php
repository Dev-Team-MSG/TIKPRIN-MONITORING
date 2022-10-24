<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CrudController;
use App\Http\Controllers\TicketController;
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
    return redirect(route("list-open-ticket"));
});

Route::get("/tiket", [TicketController::class, "showAllTicket"])->name("semua-tiket");

Route::get('crud', [CrudController::class, 'index']);
Route::get('crud/tambah', [CrudController::class, 'tambah']);
Route::get("/tiket", [TicketController::class, "buatTiket"])->name("view-create-ticket");
Route::post("/tiket", [TicketController::class, "simpanTiket"])->name("store-create-ticket");
Route::get("/tiket/{no_ticket}",[TicketController::class, "detailTicket"])->name("detail-ticket");
Route::post("/ticket/{no_ticket}/ambil", [TicketController::class, "take"])->name("ambil-tiket");
Route::get("/tikets/open", [TicketController::class, "showOpenTicket"])->name("list-open-ticket");
Route::get("/tikets/progress", [TicketController::class, "showProgressTicket"])->name("list-progress-ticket");
Route::get("/tikets/close", [TicketController::class, "showCloseTicket"])->name("list-close-ticket");
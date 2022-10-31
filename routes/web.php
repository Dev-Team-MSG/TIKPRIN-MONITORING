<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PrinterController;

use App\Http\Controllers\CrudController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
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
        if(Auth::user()->roles[0]->name == "engineer"){
            $count_open = Ticket::where("status", "open")->where("assign_id", null)->count();
            $count_progress = Ticket::where("status", "progress")->where("assign_id", Auth::user()->id)->count();
            $count_close = Ticket::where("status", "close")->where("assign_id", Auth::user()->id)->count();

        }else if(Auth::user()->roles[0]->name == "kanim"){
            $count_open = Ticket::where("status", "open")->where("assign_id", Auth::user()->id)->count();
            $count_progress = Ticket::where("status", "progress")->where("assign_id", Auth::user()->id)->count();
            $count_close = Ticket::where("status", "close")->where("assign_id", Auth::user()->id)->count();


        }else {
            $count_open = Ticket::where("status", "open")->count();
            $count_progress = Ticket::where("status", "progress")->count();
            $count_close = Ticket::where("status", "close")->count();
        }
        return view('index', compact("count_open", "count_progress", "count_close"));});

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

    //Route Tiket
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
    Route::resource("permission",PermissionController::class);
    Route::resource("roles",RoleController::class);
});




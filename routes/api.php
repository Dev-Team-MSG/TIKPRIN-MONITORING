<?php

use App\Http\Controllers\CommentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("/tickets", [TicketController::class, "store"]);
Route::get("/ticket/{id}", [TicketController::class, "getOne"]);
Route::post("/ticket/{id}/ambil", [TicketController::class, "take"]);
Route::post("/ticket/{id}/close", [TicketController::class, "close"]);
Route::post("/ticket/{no_ticket}/comment", [CommentController::class, "storeComment"]);
Route::get("/tickets", [TicketController::class, "index"]);

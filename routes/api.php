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


Route::post("/ticket/update-ticket", [TicketController::class, "updateTicket"])->name("update-tiket");
Route::get("/file", [TicketController::class, "attachfile"]);
Route::get("/file-comment", [CommentController::class, "attachfile"]);
Route::post("/file-comment", [CommentController::class, "storeFile"]);
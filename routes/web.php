<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\ApiController;


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
    return view('home');
})->name("home");

Route::get('/users/loginas', [UserController::class, 'loginas'])->name("users.loginas");
Route::resource("users", UserController::class);

Route::put("/events/validate/{event}", [EventController::class, "aprovar"])->name("events.validate");
Route::put("/events/invalidate/{event}", [EventController::class, "desaprovar"])->name("events.invalidate");
Route::resource("events", EventController::class);

Route::get("/attachment/download/{attachment}",[AttachmentController::class, "download"])->name("attachments.download");

Route::get("/api/getAllEvents", [ApiController::class, "getAllEvents"]);
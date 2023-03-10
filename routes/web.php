<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\DefenseController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TVController;


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

Route::get("/api/eventos", [ApiController::class, "getAllEvents"]);
Route::get("/api/defesas", [ApiController::class, "getAllDefenses"]);

Route::get("/defenses/import",[DefenseController::class, "importFromReplicado"])->name("defenses.import");
Route::resource("defenses", DefenseController::class);

Route::get("/google/login", [GoogleController::class, "login"])->name("google.login");
Route::get("/google/callback", [GoogleController::class, "callback"]);

Route::get("/inscricao/{slug}", [RegistrationController::class, "create"])->name("registration.create");
Route::post("/inscricao/{slug}", [RegistrationController::class, "store"])->name("registration.store");
Route::get("/events/{event}/subscriptions", [RegistrationController::class, "index"])->name("registration.index");

Route::get("/tv/defesas", [TVController::class, "defesas"]);
<?php

use App\Http\Controllers\CadastrosController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", [LoginController::class, "index"])->name("login");
Route::post("/", [LoginController::class, "auth"])->name("login.post");


Route::middleware("auth")->group(function () {
    Route::get("/restrito/cadastros", [CadastrosController::class, "index"])->name("restrito.cadastros");

    Route::put("/restrito/usuario/{id}/alterar-senha", [UserController::class, "changeSelfPassword"]);

    Route::get("/logout", [LoginController::class, "logout"])->name("logout");
});

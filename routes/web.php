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
    Route::get("/restrito/cadastros/fitro/1", [CadastrosController::class, "index"])->name("restrito.cadastros.filtro.aprovado");
    Route::get("/restrito/cadastros/fitro/2", [CadastrosController::class, "index"])->name("restrito.cadastros.filtro.pendente");
    Route::get("/restrito/cadastros/fitro/3", [CadastrosController::class, "index"])->name("restrito.cadastros.filtro.recusado");
    Route::get("/restrito/cadastros/fitro/4", [CadastrosController::class, "index"])->name("restrito.cadastros.filtro.naoElegivel");
    Route::post("/restrito/cadastros/search-new", [CadastrosController::class, "searchNewBeneficiaria"]);
    Route::post("/restrito/cadastros/dados-new", [CadastrosController::class, "create"]);
    Route::post("/restrito/cadastros/dados-new/submit", [CadastrosController::class, "store"])->name("restrito.benefiaria.store");

    Route::put("/restrito/usuario/{id}/alterar-senha", [UserController::class, "changeSelfPassword"]);

    Route::get("/logout", [LoginController::class, "logout"])->name("logout");
});

<?php

use App\Http\Controllers\CadastrosController;
use App\Http\Controllers\JudicializacaoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProtectedFilesController;
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
    Route::get("/restrito/cadastros/beneficiarias", [CadastrosController::class, "index"])->name("restrito.cadastros.beneficiarias");
    Route::get("/restrito/cadastros/beneficiarias/fitro/{filtro}", [CadastrosController::class, "index"])->name("restrito.cadastros.beneficiarias.filtro");
    Route::post("/restrito/cadastros/beneficiarias/search-new", [CadastrosController::class, "searchNewBeneficiaria"]);
    Route::post("/restrito/cadastros/beneficiarias/filter", [CadastrosController::class, "filter"])->name("restrito.cadastros.beneficiarias.filter.form");

    Route::post("/restrito/cadastros/beneficiarias/dados-new", [CadastrosController::class, "create"])->name("restrito.form.new.beneficiaria");
    Route::post("/restrito/cadastros/beneficiarias/dados-new/submit", [CadastrosController::class, "store"])->name("restrito.benefiaria.store");
    Route::get("/restrito/cadastros/beneficiarias/view/{idBeneficiaria}", [CadastrosController::class, "view"])->name("restrito.beneficiarias.view");
    Route::post("/restrito/cadastros/beneficiarias/view/{idBeneficiaria}/{approve}", [CadastrosController::class, "approve"])->name("restrito.beneficiaria.approve");
    Route::post("/restrito/cadastros/beneficiarias/edit-permission/{idBeneficiaria}", [CadastrosController::class, "editPermission"])->name("restrito.beneficiaria.add.edit");
    Route::post("/restrito/cadastros/beneficiarias/view-edit/{idBeneficiaria}", [CadastrosController::class, "update"]);

    Route::get("/restrito/cadastros/judicializacoes", [JudicializacaoController::class, "index"])->name("restrito.judicializacoes");
    Route::get("/restrito/cadastros/judicializacoes/create", [JudicializacaoController::class, "create"])->name("restrito.judicializacoes.create");
    Route::post("/restrito/cadastros/judicializacoes/create", [JudicializacaoController::class, "store"])->name("restrito.judicializacoes.store");
    Route::get("/restrito/cadastros/judicializacoes/view/{id}", [JudicializacaoController::class, "view"]);
    Route::get("/restrito/cadastros/judicializacoes/view/{id}/pdf", [JudicializacaoController::class, "viewPdf"])->name("restrito.judicializacoes.view.pdf");

    Route::get("/restrito/cadastros/beneficiarias/view-file/{idBeneficiaria}/{fileName}", [ProtectedFilesController::class, "showBeneficiariaFiles"])->name("restrito.view-file");

    Route::get("/restrito/check-password", [UserController::class, "checkResetPassword"]);
    Route::get("/restrito/csrf-token", function () {
        return response()->json(csrf_token());
    });

    Route::get("/restrito/cadastros/usuarios", [UserController::class, "index"])->name("restrito.usuarios");
    Route::get("/restrito/cadastros/usuarios/criar", [UserController::class, "create"])->name("restrito.usuarios.create");
    Route::post("/restrito/cadastros/usuarios/criar", [UserController::class, "store"]);
    Route::delete("/restrito/cadastros/usuarios/{id}", [UserController::class, "delete"]);
    Route::get("/restrito/cadastros/usuarios/{id}", [UserController::class, "edit"])->name("restrito.usuarios.view");
    Route::put("/restrito/cadastros/usuarios/{id}", [UserController::class, "update"]);

    Route::post("/restrito/usuario/alterar-senha", [UserController::class, "changeSelfPassword"])->name("restrito.usuario.alterar.senha");

    Route::get("/logout", [LoginController::class, "logout"])->name("logout");
});

<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Municipio;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function index()
    {
        $users = User::all();
        return view("user.list", ["users" => $users]);
    }

    function changeSelfPassword(Request $request): mixed
    {
        $user = User::find(Auth::user()->id);
        $oldPass = $user->password;
        $user->password = Hash::make($request->novaSenhaReset ?? $request->novaSenha);
        $user->reset_password = 0;
        $user->save();
        Log::create([
            "user_id" => Auth::user()->id,
            "target_id" => $user->id,
            "targeted_table" => "users",
            "action" => "update",
            "comment" => "Alteração de própria senha de usuário",
            "new_data" => "{password:$user->password}",
            "old_data" => "{password:$oldPass}",
        ]);
        return redirect()->back();
    }

    function edit($id)
    {
        $user = User::find($id);
        return view("user.view", ["user" => $user]);
    }


    function create(): View
    {
        $municipios = Municipio::all();
        return view("user.create", ["municipios" => $municipios]);
    }

    function store(Request $request)
    {
        $user = new User();
        $user->name = $request->nome;
        $user->cpf = str_replace("-", "",  str_replace(".", "",  $request->cpf));
        $user->municipio = $request->municipio;
        $user->email = $request->email;
        $user->password = str_replace("-", "",  str_replace(".", "",  $request->cpf));
        $user->save();
        $user->assignRole("municipio");
        Log::create([
            "user_id" => Auth::user()->id,
            "target_id" => $user->id,
            "targeted_table" => "users",
            "action" => "create",
            "comment" => "Cadastro de usuário município",
            "new_data" => $user->toJson(),
            "old_data" => null
        ]);
        return redirect()->route("restrito.usuarios");
    }

    function delete($userId)
    {
        $user = User::find($userId);
        $user->delete();
        Log::create([
            "user_id" => Auth::user()->id,
            "target_id" => $user->id,
            "targeted_table" => "users",
            "action" => "delete",
            "comment" => "Deletar usuário",
            "new_data" => "{deleted_at:$user->deleted_at}",
            "old_data" => null
        ]);
    }

    function update(Request $request, $id)
    {
        $user = User::find($id);
        $oldPass = $user->password;
        $user->password = bcrypt($user->cpf);
        $user->reset_password = 1;
        $user->save();
        Log::create([
            "user_id" => Auth::user()->id,
            "target_id" => $user->id,
            "targeted_table" => "users",
            "action" => "update",
            "comment" => "Redefinição de senha de usuário",
            "new_data" => "{password:$user->password}",
            "old_data" => "{password:$oldPass}",
        ]);
        return  true;
    }

    function checkResetPassword()
    {
        if (Auth::user()->reset_password == 1) {
            return json_encode(true);
        } else {
            return json_encode(false);
        }
    }
}

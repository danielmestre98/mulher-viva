<?php

namespace App\Http\Controllers;

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
        $user->password = Hash::make($request->novaSenhaReset ?? $request->novaSenha);
        $user->reset_password = 0;
        $user->save();
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
        return redirect()->route("restrito.usuarios");
    }

    function delete($userId)
    {
        $user = User::find($userId);
        $user->delete();
    }

    function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->password = bcrypt($request->password);
        $user->reset_password = 1;
        $user->save();
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

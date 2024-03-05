<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function changeSelfPassword(Request $request, $userId): mixed
    {
        if ($userId == Auth::user()->id) {
            $user = User::find($userId);
            $user->password = $request->password;
            $user->save();
            return response()->json(["success" => "Senha alterada com sucesso!"]);
        }
        return response()->json(["error" => "Erro interno entre em contato com o administrador."], 500);
    }
}

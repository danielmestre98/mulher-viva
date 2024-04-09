<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    function index(): View
    {
        return view("login");
    }

    function auth(Request $request)
    {
        $credentials = $request->only("email", "password");
        if (auth()->attempt($credentials)) {
            return redirect()->route("restrito.cadastros.beneficiarias");
        }
        return view("login", ["error" => "Usuário ou senha inválidos."]);
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route("login");
    }
}

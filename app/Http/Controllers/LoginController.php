<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
            return redirect()->route("restrito.cadastros");
        }
        return view("login", ["error" => "Usuário ou senha inválidos."]);
    }
}

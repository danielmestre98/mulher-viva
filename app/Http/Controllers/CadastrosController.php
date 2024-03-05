<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CadastrosController extends Controller
{
    function index()
    {
        return view("cadastros.index");
    }
}
